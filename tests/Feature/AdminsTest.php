<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminsTest extends TestCase
{   
    use RefreshDatabase;


    /**
     * @test
     */
    public function can_to_register_admin()
    {
        $response = $this->json('POST', '/api/admin/register', [

            'name' => 'emmanuel wilson',

            'email' => 'hagios@yahoo.com',

            'password' => 'mypassword',

        ]);

        $response->assertStatus(200);


        $this->assertDatabaseHas('admins', [

            'name' => 'emmanuel wilson',

            'email' => 'hagios@yahoo.com',

        ]);
    }
}
