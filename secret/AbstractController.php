<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\BaseResource;
use Illuminate\Support\Collection;
use Shared\App\Helpers\TextHelper;

abstract class AbstractController extends Controller {

    const ACTION_STORE = 'store';
    const ACTION_UPDATE = 'update';
    const ACTION_UPDATE_MASS = 'massUpdate';
    const ACTION_DELETE = 'delete';
    const ACTION_LIST = 'list';
    const ACTION_SHOW = 'show';

    protected $createRequiredAttributesActions = []; // u can use ACTION_STORE ACTION_UPDATE
    protected $serviceAttributes;

    protected function getAllRequestAttributes(string $action) {
        $attributes = request()->all();

        $this->serviceAttributes = $attributes['serviceAttributes'] ?? [];
        unset($attributes['serviceAttributes']);

        if (static::ACTION_STORE == $action && in_array($action, $this->createRequiredAttributesActions)) {
            return $this->modelClass::createRequiredAttributes($attributes);
        }

        return $attributes;
    }

    public static function parseSortToConfig(string $sort, $default) : array {
        $sort = trim($sort);
        if (!$sort || false !== strpos($sort, ' ')) { // не указана сортировка, или там есть пробел, оба случая недопустимы
            return $default;
        }
        return array_map(function (string $field) {
            $field = explode('.', $field);
            return [
                'field' => $field[0],
                'order' => (count($field) > 1 && strtolower($field[1]) == 'desc') ? 'desc' : 'asc',
            ];
        }, explode(',', $sort));
    }

    protected function withAsArray(string $with) : array {
        return array_filter(
            array_map(function ($with) {
                if (!is_string($with)) { return null; }
                $with = trim($with);
                if ($with) { return TextHelper::fromSnakeToCamel($with); }
                return null;
            },
            explode(',', $with)));
    }

    protected function selectAsArray(string $select, string $modelClass, array $defaultSelect = []) : array
    {
        $table = (new $modelClass())->getTable();
        if ($select)
        {
            return array_map(function (string $column) use ($table) { return "$table.$column"; }, explode(',', $select));
        }

        if ($defaultSelect)
        {
            return $defaultSelect;
        }

        return ["$table.*"];
    }
}
