<?php

namespace Tests\Feature;

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
}
