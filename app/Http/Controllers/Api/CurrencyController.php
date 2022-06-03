<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    public function actionGet() {
        return [
            'usd' => rand(45, 95),
            'euro' => rand(65, 125),
        ];
    }
}
