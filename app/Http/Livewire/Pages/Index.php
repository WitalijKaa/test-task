<?php

namespace App\Http\Livewire\Pages;

use App\Http\Livewire\AbstractComponent;

class Index extends AbstractComponent
{
    public function render()
    {
        return parent::render()
            ->layoutData(['header' => 'index Page']);
    }
}
