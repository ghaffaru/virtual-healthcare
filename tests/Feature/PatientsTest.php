<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PatientsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_the_api_can_register_patients()
    {
        # code...
        $response = $this->postJson('api/patient/register',[
            'name' => 'ghaff',
            'email' => 'mudashiruagm@gmail.com',
            'phone' => '0241992669',
            'region' => 'accra',
            'residence' => 'caprice',
            'date_of_birth' => '15-11-1996',
        ]);

        $response->assertDatabaseHas('users', [
            'name' => 'ghaff',
            'email' => 'mudashiruagm@gmail.com',
            'phone' => '0241992669',
            'region' => 'accra',
            'residence' => 'caprice',
            'date_of_birth' => date('15-11-1996'),
        ]);
    }

}
