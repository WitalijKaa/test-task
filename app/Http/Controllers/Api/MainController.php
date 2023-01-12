<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ActionContract;
use App\Events\NothingHappened;
use App\Http\Controllers\Controller;
use App\Jobs\DoNothing;

class MainController extends Controller
{
    public function actionApi(ActionContract $action) {
        $action(123);
        event(new NothingHappened(456));
        DoNothing::dispatch();
        return ['item' => 1];
    }
}
