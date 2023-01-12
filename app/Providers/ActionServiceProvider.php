<?php

namespace App\Providers;

use App\Actions\DevNullAction;
use App\Contracts\ActionContract;
use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ActionContract::class, DevNullAction::class);
    }
}
