<?php

namespace Tests\Feature\Livewire\Components;

use App\Http\Livewire\Components\NotVue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class NotVueTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(NotVue::class);

        $component->assertStatus(200);
    }
}
