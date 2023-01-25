<?php

namespace App\Providers;

use App\View\Composers\QwerComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
//        View::composer(['index'], function ($view) {
//            $view->with('qwer', 'hello!');
//        });

//        View::composer(['index'], QwerComposer::class);
    }
}
