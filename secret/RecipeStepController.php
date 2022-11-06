<?php namespace App\Http\Controllers\API;

use App\Models\Recipe\RecipeStep;
use App\Rules\SortedAttribute;
use Illuminate\Http\Request;

class RecipeStepController extends AnyController
{
    protected $massUpdate = ['sort'];

    public function actionStore(Request $request, string $model = 'recipe-step') { return parent::actionStore($request, $model); }

    public function actionUpdateSpecial(Request $request, int $id) { return parent::actionUpdate($request, 'recipe-step', $id); }

    public function actionMassUpdate(Request $request, string $model = 'recipe-step') { return parent::actionMassUpdate($request, $model); }

    protected function rules($action, array $data = [], $item = null)
    {
        /** @var $item RecipeStep */
        if (static::ACTION_STORE == $action) {
            return [
                'sort' => [new SortedAttribute(RecipeStep::where('recipe_id', $data['recipe_id'] ?? 0)->get())],
                'recipe_id' => 'integer|filled|required|exists:recipes,id',
            ];
        }
        if (static::ACTION_UPDATE == $action) {
            return [
                'sort' => [new SortedAttribute(RecipeStep::where('recipe_id', $data['recipe_id'] ?? $item->recipe_id)->get(), $item)],
            ];
        }
        if (static::ACTION_UPDATE_MASS == $action) {
            return [
                '*' => 'allowed_attributes:items',
                'items' => 'array|filled|required|same_foreign_key:recipe_id,' . RecipeStep::class . '|sorted_array:sort',
            ];
        }
        return parent::rules($action, $data, $item);
    }
}
