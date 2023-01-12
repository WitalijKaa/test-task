<?php

namespace App\Providers;

use App\Events\NothingHappened;
use App\Listeners\NothingElseMatters;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        NothingHappened::class => [
            NothingElseMatters::class,
        ],
    ];

    public function boot()
    {
        User::observe(new UserObserver());
    }

    public function shouldDiscoverEvents()
    {
        return false;
    }
}
