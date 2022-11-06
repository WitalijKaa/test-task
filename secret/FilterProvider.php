<?php

namespace App\Components\Http\Filter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class FilterProvider
{
    private $modelClass;
    /** @var \Illuminate\Support\Collection|HttpQueryFilter[] */
    private $filtersCollection;

    public function apply(Builder $builder) {
        foreach ($this->filtersCollection as $filter) {
            $filter->apply($builder, $this->modelClass::getTableColumns(), $this->modelClass::filterSpecialCaseCallback(), $this->modelClass::filterGoDeeperRelationCallback());
        }
    }

    private function createFilters(string $filter) : void {
        $this->filtersCollection = collect();
        $filter = trim($filter);
        if (!$filter) { return; }

        $table = $this->getTable();

        $this->filtersCollection = collect(array_map(function (string $field) use ($table) {
            return new HttpQueryFilter($field, $table);
        }, explode(',', $filter)));
    }

    private function getTable() {
        return (new $this->modelClass())->getTable();
    }

    public function __construct(Request $request, $modelClass) {
        $this->modelClass = $modelClass;
        $this->createFilters($request->input('filter', ''));
    }

    // если в указании порядка где-либо встречается -- some_table_alias.id ASC -- или даже -- some_table_alias.whatever_id ASC
    public static function detectRawOrderIdAscOfBuilder(Builder $builder) : bool {
        foreach ($builder->getQuery()->orders as $order) {
            if (is_array($order) &&
                isset($order['type']) &&
                isset($order['sql']) &&
                'Raw' === $order['type'] &&
                is_string($order['sql']) &&
                false !== stripos($order['sql'], 'id ASC')) {
                return true;
            }
        }
        return false;
    }

    public function findFilterValue($filterName) {
        $return = null;
        $this->filtersCollection->map(function (HttpQueryFilter $filter) use ($filterName, &$return)
        {
            if ($filter->getFieldName() == $filterName) {
                $return = $filter->getValue();
            }
        });
        return $return;
    }
}
