<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    public function actionGet() {
        return [
            'usd' => rand(45, 95),
            'eur' => rand(65, 125),
        ];
    }
}
