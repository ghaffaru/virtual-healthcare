<?php

namespace App\Http\Controllers\DoctorsControllers\Auth;

use App\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendDoctorRegistrationAlert;
use App\Http\Requests\DoctorsRegistrationFormRequest;

class RegisterController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['multiauth:admin,doctor','api']);
    }

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
            'password' => Hash::make('vhealth123'), #default vhealt12345
            'specialization_id' => $request->specialization,
            'department_id' => $request->department,
            'phone' => $request->phone

        ]);

        # dispatch job to send doctor a mail on registration

        if (SendDoctorRegistrationAlert::dispatch($doctor)) {
            return response([

                'doctor' => $doctor,
    
               // 'access_token' => $doctors_token,
            ], 200,[
                'Access-Control-Allow-Origin', '*'
            ]);
        }

        //$doctors_token = $doctor->createToken('My Admin Token')->accessToken;

       
    }

    public function resetDefaultPassword(Doctor $doctor, Request $request)
    {
        $doctor->password =  Hash::make($request->password);

        $doctor->save();

        return response([

            'success' => 'Password Changed',

        ], 200);
    }
}