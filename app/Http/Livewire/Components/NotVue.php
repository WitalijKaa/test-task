<?php

namespace App\Http\Livewire\Components;

use App\Http\Livewire\AbstractComponent;

class NotVue extends AbstractComponent
{
    public string $buttonText = 'vue.js not exist';

    public function clickButton(): void {
        $this->buttonText = 'old method';
    }
}
