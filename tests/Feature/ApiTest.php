<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Contracts\ActionContract;
use Tests\TestCase;

class ApiTest extends TestCase
{
    public function test_action()
    {
        $action = app(ActionContract::class);

        $devNull = $action(123);

        $this->assertNull($devNull);
    }
}
