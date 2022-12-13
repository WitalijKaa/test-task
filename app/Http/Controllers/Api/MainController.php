<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ImagesRegister;

class MainController extends Controller
{
    public function actionLastId() {
        return ['item' => ImagesRegister::max('foreign_id') ?? 0];
    }

    public function actionLala(string $item) {
        return ['item' => $item];
    }
}
