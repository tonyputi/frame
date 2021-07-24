<?php

namespace Tests\Unit;

use App\Models\Environment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class EnvironmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testEnvironmentCreate()
    {
        $environment = Environment::factory()->create();
        dd($environment);
        $this->assertTrue(true);
    }
}
