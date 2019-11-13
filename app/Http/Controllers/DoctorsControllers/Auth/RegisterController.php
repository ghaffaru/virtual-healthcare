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
        $this->middleware(['multiauth:admin,doctor','api']);
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

        # dicpatch job to send doctor a mail on registration

        SendDoctorRegistrationAlert::dispatch($doctor);

        //$doctors_token = $doctor->createToken('My Admin Token')->accessToken;

        return response([

            'doctor' => $doctor,

           // 'access_token' => $doctors_token,
        ], 200);
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