<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function actionLala(string $item) {
        return ['item' => $item];
    }
}
