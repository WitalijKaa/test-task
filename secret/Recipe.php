<?php namespace App\Models\Recipe;

use App\Components\Http\Filter\HttpQueryFilter;
use App\Models\BuilderByHttpQueryTrait;
use App\Models\RelationsUpdatableTrait;
use Illuminate\Database\Eloquent\Builder;
use Shared\App\Components\Helpers\DateHelper;
use Shared\App\Models\Recipe\RecipeHelper;

/** App\Models\Recipe\Recipe
 * @property-read \App\Models\Recipe\RecipeStep[]|\Illuminate\Database\Eloquent\Collection $steps
 */
class Recipe extends \Shared\App\Models\Recipe\Recipe
{
    use BuilderByHttpQueryTrait;
    use RelationsUpdatableTrait;

    protected $guarded = ['id'];
    protected $hidden = ['pivot'];

    public function compilations() { return $this->belongsToMany(RecipeCompilation::class, 'recipe_compilation_to_recipe', 'recipe_id', 'compilation_id', 'id', 'id', 'recipe_compilation'); }
    public function steps() { return $this->hasMany(RecipeStep::class); }
    public function ingredients() { return $this->hasMany(RecipeIngredient::class); }

    public static function filterSpecialCaseCallback() : callable {
        return function (Builder $builder, HttpQueryFilter $filter) {
            $alias = $filter->getAlias() ?? static::TABLE_NAME;

            switch ($filter->getFieldName()) {

                case 'active':
                    static::embedActiveToBuilder($builder, $alias, $filter->getValue());
                    break;
            }
        };
    }

    private static function embedActiveToBuilder(Builder $builder, string $alias, $value) {
        if ($value) {
            $builder->where(function ($query) use ($alias) {
                $query->where($alias . '.status', RecipeHelper::STATUS_PUBLISHED)->where($alias . '.date', '<=', \DB::raw("'" . date(DateHelper::YMDHIS) . "'"));
            });
        }
        else {
            $builder->where(function ($query) use ($alias) {
                $query->where($alias . '.status', '!=', RecipeHelper::STATUS_PUBLISHED)->orWhere($alias . '.date', '>', \DB::raw("'" . date(DateHelper::YMDHIS) . "'"));
            });
        }
    }

    public static function createRequiredAttributes(array $attributes) : array {
        if (!\Auth::user() || !\Auth::user()->currentProjectUser->id || isset($attributes['user_id'])) { return $attributes; }

        $attributes['user_id'] = \Auth::user()->currentProjectUser->id;

        return $attributes;
    }
}
