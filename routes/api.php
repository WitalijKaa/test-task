<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function () {
    Route::get('/lala/{item}', 'MainController@actionLala');
    Route::get('/last-id', 'MainController@actionLastId');

    Route::post('/image/{id}/{status}', 'MainController@actionImageCreate')
        ->where('foreign_id', '[0-9]+')
        ->where('status', '1|2');
});
