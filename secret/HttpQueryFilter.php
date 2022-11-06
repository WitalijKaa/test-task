<?php namespace App\Components\Http\Filter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

/** фильтр из http запроса */
final class HttpQueryFilter {

    private $table;
    private $filterOriginal;
    private $field;
    private $operator;
    private $value;
    private $alias;

    const OPERATOR_DEFAULT = '=';
    const OPERATOR_OR_EQUAL = 'or_eql';
    const OPERATOR_LIKE = 'like';
    const OPERATOR_OR_LIKE = 'or_like';
    const OPERATOR_IS_NULL = 'null';
    const OPERATOR_IS_NOT_NULL = 'notnull';
    const OPERATOR_IS_NOT_NULL_2 = 'not_null';
    const OPERATOR_OR_IS_NULL = 'or_null';
    const OPERATOR_OR_IS_NOT_NULL = 'or_notnull';
    const OPERATOR_IS_IN = 'in';
    const OPERATOR_OR_IS_IN = 'or_in';
    const OPERATOR_IS_NOT_IN = 'notin';
    const OPERATOR_OR_IS_NOT_IN = 'or_notin';
    const OPERATOR_IS_NOT_IN_2 = 'not_in';
    const OPERATOR_IS_NOT_EMPTY = 'notempty';
    const OPERATOR_IS_NOT_EMPTY_2 = 'not_empty';
    const OPERATOR_GREATER_OR_EQUAL = 'gtreq';
    const OPERATOR_LESS_OR_EQUAL = 'lesseq';
    const OPERATOR_BETWEEN = 'btwn';
    const OPERATOR_SINGLE_OR = 'or';
    const OPERATORS_ALLOWED = [
        self::OPERATOR_DEFAULT,
        self::OPERATOR_OR_EQUAL,
        self::OPERATOR_LIKE,
        self::OPERATOR_OR_LIKE,
        self::OPERATOR_IS_NULL,
        self::OPERATOR_IS_NOT_NULL,
        self::OPERATOR_IS_NOT_NULL_2,
        self::OPERATOR_IS_IN,
        self::OPERATOR_OR_IS_IN,
        self::OPERATOR_IS_NOT_IN,
        self::OPERATOR_IS_NOT_IN_2,
        self::OPERATOR_OR_IS_NOT_IN,
        self::OPERATOR_IS_NOT_EMPTY,
        self::OPERATOR_IS_NOT_EMPTY_2,
        self::OPERATOR_SINGLE_OR,
        self::OPERATOR_OR_IS_NULL,
        self::OPERATOR_OR_IS_NOT_NULL,
        self::OPERATOR_GREATER_OR_EQUAL,
        self::OPERATOR_LESS_OR_EQUAL,
        self::OPERATOR_BETWEEN,
    ];
    const OPERATORS_WHERE_VALUE_CAN_BE_EMPTY = [
        self::OPERATOR_IS_NULL,
        self::OPERATOR_IS_NOT_NULL,
        self::OPERATOR_IS_NOT_NULL_2,
        self::OPERATOR_IS_NOT_EMPTY,
        self::OPERATOR_IS_NOT_EMPTY_2,
        self::OPERATOR_OR_IS_NULL,
        self::OPERATOR_OR_IS_NOT_NULL,
    ];

    /** добавляет фильтры в запрос
     *
     * @param Builder $builder сюда будут добавлены нужные ->where()
     * @param array $columns перечень имен колонок таблицы
     * @param callable $addCustomFilter коллбек из модели-таблицы в котором можно навесить не типичный фильтр
     */
    public function apply(Builder $builder, array $columns, callable $addCustomFilter, callable $goDeeperByRelation) {
        if ($this->isValid() && in_array($this->field, $columns)) {
            $column = ($this->alias ?? $this->table) . '.' . $this->field;
            if (self::OPERATOR_SINGLE_OR == $this->operator) {
                $filters = $this->parseSingleOr($columns);
                $builder->where(function ($query) use ($column, $filters) {
                    $query->where($column, self::OPERATOR_DEFAULT, $this->value);
                    foreach ($filters as $filter) {
                        if ($filter['like']) {
                            $query->orWhere($filter['field'], self::OPERATOR_LIKE, '%' . $this->value . '%');
                        }
                        else {
                            $query->orWhere($filter['field'], self::OPERATOR_DEFAULT, $this->value);
                        }
                    }
                });
            }
            else if (self::OPERATOR_OR_EQUAL == $this->operator) {
                $builder->orWhere($column, '=', $this->value);
            }
            else if (self::OPERATOR_LIKE == $this->operator) {
                $builder->where($column, self::OPERATOR_LIKE, '%' . $this->value . '%');
            }
            else if (self::OPERATOR_OR_LIKE == $this->operator) {
                $builder->orWhere($column, self::OPERATOR_LIKE, '%' . $this->value . '%');
            }
            else if (self::OPERATOR_IS_NULL == $this->operator) {
                $builder->whereNull($column);
            }
            else if (self::OPERATOR_OR_IS_NULL == $this->operator) {
                $builder->orWhereNull($column);
            }
            else if (in_array($this->operator, [self::OPERATOR_IS_NOT_NULL, self::OPERATOR_IS_NOT_NULL_2])) {
                $builder->whereNotNull($column);
            }
            else if (self::OPERATOR_OR_IS_NOT_NULL == $this->operator) {
                $builder->orWhereNotNull($column);
            }
            else if (in_array($this->operator, [self::OPERATOR_IS_NOT_EMPTY, self::OPERATOR_IS_NOT_EMPTY_2])) {
                $builder->whereNotNull($column)->whereNotIn($column, ['', '0', ' ']);
            }
            else if (self::OPERATOR_IS_IN == $this->operator) {
                $builder->whereIn($column, explode('||', $this->value));
            }
            else if (self::OPERATOR_OR_IS_IN == $this->operator) {
                $builder->orWhereIn($column, explode('||', $this->value));
            }
            else if (in_array($this->operator, [self::OPERATOR_IS_NOT_IN, self::OPERATOR_IS_NOT_IN_2])) {
                $builder->whereNotIn($column, explode('||', $this->value));
            }
            else if (self::OPERATOR_OR_IS_NOT_IN == $this->operator) {
                $builder->orWhereNotIn($column, explode('||', $this->value));
            }
            else if (self::OPERATOR_GREATER_OR_EQUAL == $this->operator) {
                $builder->where($column, '>=', $this->value);
            }
            else if (self::OPERATOR_LESS_OR_EQUAL == $this->operator) {
                $builder->where($column, '<=', $this->value);
            }
            else if (self::OPERATOR_BETWEEN == $this->operator) {
                $builder->whereBetween($column, explode('||', $this->value));
            }
            else {
                $builder->where($column, self::OPERATOR_DEFAULT, $this->value);
            }
        }
        else {
            $goDeeperByRelation($builder, $this);
            $addCustomFilter($builder, $this);
        }
    }

    /** работает в паре с function goDeeper (вызывается после него чтоб иметь в наличии имя таблицы и алиас)
     *  если мы фильтруем по полю модели из релейшена, например user.is_banned=1 то значит мы будем навешивать на запрос
     *  join
     *  который позволит нам написать ->where() для таблицы-релейшена
     *  данный метод позволяет навесить join без дублей == exceptions
     *
     * @param callable $join коллбек который навесит join на запрос (если надо)
     * @param Builder $builder билдер который будет проверен прежде чем навесить на него джойн
     */
    public function join(callable $join, Builder $builder) {
        $joinTable = $this->table . ' as ' . $this->alias;
        if (!is_array($builder->getQuery()->joins) ||
            !array_filter($builder->getQuery()->joins,
                function (JoinClause $join) use ($joinTable) {
                    return $join->table == $joinTable;
                }
        )) {
            $join($builder);
        }
    }

    /** если мы фильтруем по полю модели из релейшена, например user.is_banned=1 то значит мы будем из Comment перебрасывать этот фильтр в User
     *  в этом методе происходят все нужные трансформации с фильтром, но сюда нужно передать
     *  алиас
     *  через который джойним релейшен-таблицу ... пример $builder->join("user as $alias", "$alias.id", '=', 'comment.user_id');
     *
     * @param string $alias уникальный
     * @return $this|null фильтр который уходит в коллбек связанной модели
     */
    public function goDeeper(string $alias, ?string $tableName = null) : ?HttpQueryFilter {
        if (count($this->filterOriginal) > 1) {
            $filterOriginal = $this->filterOriginal;

            if ($tableName) {
                $table = $tableName;
                array_shift($filterOriginal);
            }
            else { $table = array_shift($filterOriginal); }

            $filter = new static(implode('.', $filterOriginal) . '=' . $this->value, $table);
            $filter->alias = $alias;
            return $filter;
        }
        return null;
    }



    /** @param string $filter строка из http запроса
     *  @param string $table имя таблицы */
    public function __construct(string $filter, string $table) {
        $filter = explode('=', $filter);
        $fieldParam = explode('.', $filter[0]);

        $this->table = $table;
        $this->filterOriginal = $fieldParam;
        $this->field = $fieldParam[0];
        $this->operator = isset($fieldParam[1]) && is_string($fieldParam[1]) && in_array(strtolower($fieldParam[1]), self::OPERATORS_ALLOWED) ? strtolower($fieldParam[1]) : null;
        $this->value = isset($filter[1]) ? $filter[1] : null;
    }

    // разбор OPERATOR_SINGLE_OR в конфиг который можно юзать к $builder->orWhere
    private function parseSingleOr(array $columns) : array {
        $filter = $this->filterOriginal;
        array_shift($filter); // {{SERVER}}user?filter=id.or.first_name.like.last_name.like.email=Вася
        array_shift($filter); // исключаем id or
        $parse = [];
        while (count($filter)) {
            if (!in_array($filter[0], $columns)) { // чтоб не падать
                array_shift($filter);
                continue;
            }

            $like = isset($filter[1]) && 'like' === $filter[1];
            $parse [] = [
                'field' => ($this->alias ? $this->alias . '.' : $this->table . '.') . $filter[0],
                'like' => $like,
            ];
            array_shift($filter);
            if ($like) { array_shift($filter); } // если first_name.like
        }
        return $parse;
    }

    private function isValid() {
        return $this->field &&
            (!is_null($this->value) || in_array($this->operator, self::OPERATORS_WHERE_VALUE_CAN_BE_EMPTY));
    }

    public function getFieldName() { return $this->field; }
    public function getOperator() { return $this->operator; }
    public function getValue() { return $this->value; }
    public function getAlias() { return $this->alias; }

    public function isOperatorNull() : bool {
        return $this->getOperator() === self::OPERATOR_IS_NULL;
    }
    public function isFieldNameIn(array $names) {
        return in_array( $this->getFieldName(), $names);
    }
}
