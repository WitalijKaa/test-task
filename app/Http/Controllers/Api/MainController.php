<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ImagesRegister;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class MainController extends Controller
{
    public function actionApi() {
        return ['item' => 1];
    }
}
