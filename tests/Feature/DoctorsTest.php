<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DoctorsTest extends TestCase
{
    use RefreshDatabase;

    /*
     * @test
     */
    public function doctor_api_registration()
    {

      /*   $this->postJson('api/doctor/register',[
            
            'name' => 'emmanuel wilson',

            'email' => 'hagios@yahoo.com',

            'phone' => '0273298953',
            
            'residence' => 'caprice',

            'date_of_birth' => '15-11-1996',
        ]);
      */
    }

    public function test_api_can_list_all_doctors()
    {
      $response = $this->getJson('api/doctors',[
        'accept' => 'application/json',
        'content-type' => 'application/json'
      ]);

      $response->assertJsonStructure([
        'data' => [
          '*' => [
          'name',
          'email',
          'phone'
          ],
        ]
      ]);

    }
}

