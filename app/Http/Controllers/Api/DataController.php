<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class DataController extends Controller
{
    public function actionByRoute(string $dir, string $file) {
        return json_decode(file_get_contents(resource_path('data' . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $file)), 1);
    }
}
