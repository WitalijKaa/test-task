<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ActionContract;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function actionApi(ActionContract $action) {
        $action(123);
        return ['item' => 1];
    }
}
