<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function () {
    Route::get('/data/{dir}/{file}', 'DataController@actionByRoute');
    Route::get('/currency', 'CurrencyController@actionGet');
});
