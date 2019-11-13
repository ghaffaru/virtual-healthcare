<?php

namespace Tests\Feature;

use App\Doctor;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DoctorsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_register_a_doctor()
    {


       $response = $this->json('POST','/api/admin/registeradoctor', [
 
            'name' => 'emmanuel wilson',

            'email' => 'hagios@yahoo.com',

            'password' => 'mypassword',

            'specialization' => '1',

            'department' => '2',
      
            'phone' => '0273298953'
          
        ]);

        $response->assertStatus(200);


        $this->assertDatabaseHas('doctors', [

          'name' => 'emmanuel wilson',

          'email' => 'hagios@yahoo.com',

          'phone' => '0273298953',

          'specialization_id' => '1',

          'department_id' => '2',

        ]);
      
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

