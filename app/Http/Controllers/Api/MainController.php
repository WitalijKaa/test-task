<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ActionContract;
use App\Events\NothingHappened;
use App\Http\Controllers\Controller;
use App\Jobs\DoNothing;
use App\Models\ImagesRegister;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class MainController extends Controller
{
    public function actionLastId() {
        return ['item' => ImagesRegister::max('foreign_id') ?? 0];
    }

    public function actionImageCreate(int $foreign_id, int $status) {

        if (ImagesRegister::where(['foreign_id' => $foreign_id])->whereIn('status', ImagesRegister::STATUSES_FORBIDDEN)->exists()) {
            throw new AccessDeniedHttpException();
        }

        /** @var ImagesRegister $model */
        $model = ImagesRegister::where(['foreign_id' => $foreign_id])->firstOrNew();
        $model->foreign_id = $foreign_id;
        $model->status = $status;
        $model->url = request()->post('url');
        $model->save();

        return ['item' => $model];
    }

    public function actionImageUpdate(int $id) {

        /** @var ImagesRegister $model */
        $model = ImagesRegister::findOrFail($id);
        $model->status = ImagesRegister::STATUS_RESET;
        $model->save();

        return ['item' => $model];
    }

    public function actionApi(ActionContract $action) {
        $action(123);
        event(new NothingHappened(456));
        DoNothing::dispatch();
        return ['item' => 1];
    }
}
