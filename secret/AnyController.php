<?php

namespace App\Http\Controllers\API;

class AnyController extends AbstractController
{
    use CacheUser;

    protected $action;
    protected $cacheListCount = false;

    const MODEL_FOLDER = [
        'RecipeCompilation' => 'Recipe',
        'RecipeStep' => 'Recipe',
    ];

    protected $massUpdate = [];

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $modelClass;

    /**
     * @var BaseCollection
     */
    protected $resourceCollection;

    /**
     * @var BaseResource
     */
    protected $resource;

    public function actionList(Request $request, $model)
    {
        $this->action = static::ACTION_LIST;
        if (!$this->init($request, $model)) {
            return $this->responseUnsupported();
        }

        return app('RequestCache')->remember($this->cacheKey($request->all()), 60, function () use ($request) {
            list ($totalCount, $models) = $this->listByHttpQuery($request);

            $collects = null;
            if ($this->resourceCollection == BaseCollection::class)
            {
                $collects = $this->resource;
            }

            return $this->listResponse(new $this->resourceCollection($models, BaseResource::ACTION_LIST, $totalCount, $collects));
        });
    }

    protected function listByHttpQuery(Request $request)
    {
        $select = $this->selectAsArray($request->input('select', ''), $this->modelClass, $this->getSelectForList());
        $select = array_merge($select, array_diff($this->getAlwaysSelect(), $select));
        $with = $this->withAsArray($request->input('with', ''));
        $filters = new FilterProvider($request, $this->modelClass);
        $sort = new Sort($request, $this->modelClass);
        $paginate = new Paginate($request);

        $builder = $this->getBuilderForList();
        $sort->apply($builder);
        $filters->apply($builder);

        if ($this->cacheListCount)
        {
            $totalCount = app('AppCache')->remember(
                $this->cacheKey($request->all()), 60 * 60 * 24,
                function () use ($builder) { return $builder->count(); }
            );
        } else {
            $totalCount = $builder->count();
        }

        $paginate->apply($builder, $totalCount);
        $models = $builder->select($select)->with($with)->get();

        return [$totalCount, $models];
    }

    public function actionShow(Request $request, string $model, int $id)
    {
        $this->action = static::ACTION_SHOW;

        if (!$this->init($request, $model)) {
            return $this->responseUnsupported();
        }

        $item = $this->modelClass::with($this->withAsArray($request->input('with', '')))
            ->select($this->selectAsArray('', $this->modelClass))
            ->findOrFail($id);

        return $this->itemResponse(new $this->resource($item));
    }

    public function actionMassUpdate(Request $request, string $model) {
        $validOrError = $this->massUpdateValidation($request, $model);
        if (true !== $validOrError) {
            return $validOrError;
        }

        $items = array_map(function ($row) { // это наш общий случай, но есть уникумы вроде recipe-compilation
            $item = ['id' => $row['id']];
            foreach ($this->massUpdate as $fieldName) {
                $item[$fieldName] = $row[$fieldName];
            }

            $this->modelClass::where('id', $row['id'])->update($item);

            return $item;
        }, request()->get('items'));

        return ['items' => $items];
    }

    protected function massUpdateValidation($request, $model) {
        if (!$this->init($request, $model) || !$this->rules(static::ACTION_UPDATE_MASS) || !$this->massUpdate) {
            return $this->responseUnsupported();
        }
        if (!$this->validationByAction(static::ACTION_UPDATE_MASS)) {
            return $this->validationErrors;
        }
        return true;
    }

    /**
     * Инициализация модели и ресурсов, с которыми будем работать
     * @param Request $request
     * @param string $modelName
     * @return bool
     */
    protected function init(Request $request, string $modelName): bool
    {
        $modelName = ucfirst(\Str::camel($modelName));
        $folder = $this->getModelFolder($modelName);

        $class = 'App\Models\\'.$folder.'\\'.$modelName;
        if (class_exists($class))
        {
            $this->modelClass = $class;
        }

        $class = 'App\Http\Resources\\'.$folder.'\\'.$modelName.'Resource';

        if (class_exists($class))
        {
            $this->resource = $class;
        }
        else { $this->resource = CommonResource::class; }

        $class = 'App\Http\Resources\\'.$folder.'\\'.$modelName.'Collection';
        if (class_exists($class))
        {
            $this->resourceCollection = $class;
        } else {
            $this->resourceCollection = BaseCollection::class;
        }

        return (bool)$this->modelClass && (bool)$this->resource;
    }

    protected function rules($action, array $data = [], $item = null) {
        return [
        ];
    }

    protected function responseUnsupported() {
        return response('Unsupported or unknown model', 400);
    }

    protected function getModelFolder(string $modelName) : string {
        if (array_key_exists($modelName, static::MODEL_FOLDER)) {
            return static::MODEL_FOLDER[$modelName];
        }
        return $modelName;
    }

    protected $validationErrors = [];
    protected function validationByAction(string $action, $item = null) : bool {
        $validator = \Validator::make(request()->all(), $this->rules($action, request()->all(), $item));
        if (!empty($validator->errors()->all())) {
            $this->validationErrors = response()->json($validator->errors()->toArray(), 400);
            return false;
        }
        return true;
    }
}
