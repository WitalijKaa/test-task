<?php

namespace App\Actions;

use App\Contracts\ActionContract;

class DevNullAction implements ActionContract
{
    public function __invoke(mixed $param): void
    {

    }
}
