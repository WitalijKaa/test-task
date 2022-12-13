<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::middleware('auth_xyz')->get('/adm', function () {
    return view('admin');
});
