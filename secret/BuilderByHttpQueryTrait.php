<?php namespace App\Models;

use App\Components\Http\Filter\HttpQueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait BuilderByHttpQueryTrait {

    protected static $_columns = null;
    public static function getTableColumns() : array {
        if (is_null(static::$_columns)) {
            /** @var \Illuminate\Database\Eloquent\Model $model */
            $model = new static();
            static::$_columns = app('Schema')->getColumnListing($model->getTable(), $model);
        }
        return static::$_columns;
    }

    /** предоставляет коллбек в котором навешивает на запрос уникальную фильтрацию из http (не такую которая по колонке в БД)
     * @return callable см пример с заглушки */
    public static function filterSpecialCaseCallback() : callable {
        return function (Builder $builder, HttpQueryFilter $filter) {
            // implement in model
            // - $addCustomFilter(Builder, HttpQueryFilter);
        };
    }

    // если это имя BelongsTo релейшена, значит можем джойниться и делать filter->goDeeper (пример для коммента ?filter=article.section_id=123)
    public function canGoDeeperRelation(string $relation, string $builderClass = null) : bool {
        if (method_exists($this, $relation)) {
            $builder = $this->$relation();
            if ($builder && get_class($builder) == $builderClass) {
                return true;
            }
        }
        return false;
    }

    public function findRelationClass(string $relation) : ?string {
        $relation = \Str::camel($relation);
        if (method_exists($this, $relation)) {
            $builder = $this->$relation();
            return get_class($builder);
        }
        return null;
    }

    public static function filterGoDeeperRelationCallback() : callable {
        return function (Builder $builder, HttpQueryFilter $filter) {
            if (!$model = static::where('id', '>', 0)->limit(1)->get()->first()) { return; }

            if ($builderClass = $model->findRelationClass($filter->getFieldName())) {
                if (\Illuminate\Database\Eloquent\Relations\BelongsTo::class == $builderClass) {
                    $method = $model->goFilterDeeperByBelongsToRelationCallback();
                    $method($builder, $filter);
                }
                else if (\Illuminate\Database\Eloquent\Relations\BelongsToMany::class == $builderClass) {
                    $method = $model->goFilterDeeperByBelongsToManyRelationCallback();
                    $method($builder, $filter);
                }
            }
        };
    }

    /** попытается определить не является ли фильтр релейшеном BelongsTo, и если так то попытается применит указанный фильтр (пример для коммента ?filter=article.section_id=123)
     * @return callable */
    public static function goFilterDeeperByBelongsToRelationCallback() : callable {
        return function (Builder $builder, HttpQueryFilter $filter) {
            $field = \Str::camel($filter->getFieldName());
            $model = static::where('id', '>', 0)->limit(1)->get()->first();

            if ($model && $model->canGoDeeperRelation($field, \Illuminate\Database\Eloquent\Relations\BelongsTo::class)) {
                /** @var \Illuminate\Database\Eloquent\Relations\BelongsTo $relationBuilder */
                $relationBuilder = $model->$field();
                $alias = $relationBuilder->getRelationName() . '_rel';
                $filter = $filter->goDeeper($alias);
                $ownerClass = get_class($relationBuilder->getQuery()->getModel());

                $joinCallback = function (Builder $builder) use ($alias, $relationBuilder) {
                    $ownerTable = $relationBuilder->getQuery()->getModel()->getTable();
                    $ownerKey = $relationBuilder->getOwnerKeyName();
                    $foreignTable = $relationBuilder->getChild()->getModel()->getTable();
                    $foreignKey = $relationBuilder->getForeignKeyName();
                    $builder->join("$ownerTable as $alias", "$alias.$ownerKey", '=', "$foreignTable.$foreignKey");
                };
                $filter->join($joinCallback, $builder);
                $filter->apply($builder, $ownerClass::getTableColumns(), $ownerClass::filterSpecialCaseCallback(), $ownerClass::goFilterDeeperByBelongsToRelationCallback());
            }
        };
    }

    public static function goFilterDeeperByBelongsToManyRelationCallback() : callable {
        return function (Builder $builder, HttpQueryFilter $filter) {
            $field = \Str::camel($filter->getFieldName());
            $model = static::where('id', '>', 0)->limit(1)->get()->first();

            if ($model && $model->canGoDeeperRelation($field, \Illuminate\Database\Eloquent\Relations\BelongsToMany::class)) {
                /** @var \Illuminate\Database\Eloquent\Relations\BelongsToMany $relationBuilder */
                $relationBuilder = $model->$field();
                $relatedTable = $relationBuilder->getQuery()->getModel()->getTable();
                $aliasRelated = $relationBuilder->getRelationName() . '_rel_mtm';
                $relatedClass = get_class($relationBuilder->getQuery()->getModel());
                $foreignTable = $filter->getAlias() ?? $model->getTable();
                $filter = $filter->goDeeper($aliasRelated, $relatedTable);

                $joinCallback = function (Builder $builder) use ($aliasRelated, $relationBuilder, $foreignTable, $relatedTable) {
                    $foreignKey = $relationBuilder->getParentKeyName();
                    $foreignPivotKey = $relationBuilder->getForeignPivotKeyName();
                    $pivotTable = $relationBuilder->getTable();
                    $relatedKey = $relationBuilder->getRelatedKeyName();
                    $relatedPivotKey = $relationBuilder->getRelatedPivotKeyName();
                    $aliasPivot = $relationBuilder->getRelationName() . '_rel_mtm_pivot';
                    $builder->join("$pivotTable as $aliasPivot", "$aliasPivot.$foreignPivotKey", '=', "$foreignTable.$foreignKey");
                    $builder->join("$relatedTable as $aliasRelated", "$aliasRelated.$relatedKey", '=', "$aliasPivot.$relatedPivotKey");
                };
                $filter->join($joinCallback, $builder);
                $filter->apply($builder, $relatedClass::getTableColumns(), $relatedClass::filterSpecialCaseCallback(), $relatedClass::goFilterDeeperByBelongsToRelationCallback());
            }
        };
    }
}
