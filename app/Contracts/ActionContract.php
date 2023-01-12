<?php

namespace App\Contracts;

interface ActionContract
{
    public function __invoke(mixed $param): void;
}
