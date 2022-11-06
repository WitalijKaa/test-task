<?php namespace App\Http\Controllers\API;

use App\Models\Recipe\RecipeCompilation;
use App\Models\Recipe\RecipeCompilationRelation;
use Illuminate\Http\Request;

class RecipeController extends AnyController
{
    protected $createRequiredAttributesActions = [self::ACTION_STORE];

    public function actionStore(Request $request, string $model = 'recipe') { return parent::actionStore($request, $model); }

    public function actionUpdateSpecial(Request $request, int $id) { return parent::actionUpdate($request, 'recipe', $id); }

    protected function rules($action, array $data = [], $item = null)
    {
        if (static::ACTION_UPDATE == $action) {
            return [
                'author_id' => 'required|integer|exists:author,id',
            ];
        }
        return parent::rules($action, $data, $item);
    }
}
