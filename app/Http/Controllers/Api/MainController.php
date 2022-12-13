<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ImagesRegister;

class MainController extends Controller
{
    public function actionNextPicture() {
        return ['item' => ImagesRegister::findOrFail(1)];
    }

    public function actionLala(string $item) {
        return ['item' => $item];
    }
}
