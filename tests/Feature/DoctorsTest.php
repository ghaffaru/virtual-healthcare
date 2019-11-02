<?php

namespace Tests\Feature;

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

       $response = $this->json('POST','/api/doctor/register', [
            
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
}
