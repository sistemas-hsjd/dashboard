<?php

namespace Tests\Feature;

use App\Services\VisitCounter;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        config(['services.anexos.url' => 'https://example.com/anexos']);
        $this->mock(VisitCounter::class, function ($mock) {
            $mock->shouldReceive('increment')->once()->andReturn(1);
        });

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('id="topnav-admin"', false);
        $response->assertDontSee('<modal-estados-enlaces-component>', false);
    }
}
