<?php

namespace Tests\Feature;

use App\User;
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
        $this->postJson('api/patient/register',[
            'name' => 'ghaff',
            'email' => 'mudashiruagm@gmail.com',
            'password' => '12345678',
            'phone' => '0241992669',
            'region' => 'accra',
            'residence' => 'caprice',
            'date_of_birth' => '15-11-1996',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'ghaff',
            'email' => 'mudashiruagm@gmail.com',
            'phone' => '0241992669',
            'region' => 'accra',
            'residence' => 'caprice',
            'date_of_birth' => date('15-11-1996'),
        ]);
    }

    public function test_guests_cannot_book_appointments() 
    {
        $response = $this->postJson('api/book-appointment',[
            'doctor_id' => 'ghaff',
            'appointment_date' => date('11-10-2019')
        ]);

        $response->assertUnauthorized();
    }
 
    public function test_patients_can_book_appointments() 
    {
        $patient = User::all()->first();
        $response = $this->actingAs($patient,'api')->postJson('api/book-appointment',[
            'doctor_id' => '1',
            'appointment_date' => date('11-10-2019')
        ]);

        $response->assertOk();
    }

    public function test_a_patient_can_view_his_appointments()
    {
        $patient = User::all()->first();
        $response = $this->actingAs($patient,'api')->getJson('api/patient/appointments',[
            'content-type'=> 'application/json',
            'accept' => 'application/json'
        ]);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                'doctor',
                'doctor_phone',
                'appointment_date'
                ],
              ]
        ]);
    }
}
