<?php

namespace Tests\Feature;

use App\Doctor;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DoctorsTest extends TestCase
{
    use RefreshDatabase;

    /*
     * 
     */
    public function test_api_to_register_a_doctor()
    {

       $response = $this->json('POST','/api/doctor/register', [
            
            'name' => 'emmanuel wilson',

            'email' => 'hagios@yahoo.com',

            'password' => 'mypassword',

      
            'phone' => '0273298953',
            
        ]);

        $response->assertStatus(200);


        $this->assertDatabaseHas('doctors', [

          'name' => 'emmanuel wilson',

          'email' => 'hagios@yahoo.com',

          'phone' => '0273298953',

        ]);
      
    }

    public function test_the_api_can_list_all_doctors()
    {
      $response = $this->getJson('/api/doctors');

      $response->assertJson(Doctor::all());
    }
}
