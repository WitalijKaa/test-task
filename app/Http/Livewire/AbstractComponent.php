<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AbstractComponent extends Component
{
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Livewire\Macros\ViewMacros
     */
    public function render()
    {
        return view($this::getName());
    }
}
