<?php

namespace App\Listeners;

use App\Events\NothingHappened;
use Illuminate\Contracts\Queue\ShouldQueue;

class NothingElseMatters implements ShouldQueue
{
    public function handle(NothingHappened $event)
    {
        $event->emptiness;
    }
}
