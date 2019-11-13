<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HospitalEventTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function admin_can_add_an_event()
    {
        $response = $this->json('POST', '/api/admin/event', [

            'event' => 'Test Program',

            'description' => 'Another',

            'start_date' => '2012-10-20',

            'end_date' => '2012-10-20'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('hospital_events', [

            'event' => 'Test Program',

            'description' => 'Another',

            'start_date' => '2012-10-20',

            'end_date' => '2012-10-20'
        ]);
    }
}
