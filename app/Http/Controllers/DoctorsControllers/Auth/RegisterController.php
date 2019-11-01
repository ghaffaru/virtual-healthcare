<?php

namespace App\Http\Controllers\DoctorsControllers\Auth;

use App\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\DoctorsRegistrationFormRequest;

class RegisterController extends Controller
{
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(DoctorsRegistrationFormRequest $request)
    {
       $doctor = Doctor::create([

            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        //$doctors_token = $doctor->createToken('My Admin Token')->accessToken;

        return response([

            'doctor' => $doctor,

           // 'access_token' => $doctors_token,
        ], 200);
    }
}