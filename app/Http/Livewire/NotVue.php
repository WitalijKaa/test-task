<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NotVue extends Component
{
    public string $buttonText = 'vue.js not exist';

    public function clickButton(): void {
        $this->buttonText = 'but we have livewire';
    }

    public function render()
    {
        return view('livewire.not-vue');
    }
}
