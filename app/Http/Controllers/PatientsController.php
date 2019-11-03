<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Doctor;
use App\Http\Requests\BookAppointmentRequest;
use App\Http\Requests\CreatePatientRequest;
use App\Http\Resources\Appointment as AppointmentResource;
use App\Http\Resources\Doctor as DoctorResource;
use Illuminate\Http\Request;
use App\User;
use Hash;
class PatientsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api')->only(['book_appointment','appointments']);
    }

    public function store(CreatePatientRequest $request)
    {
        # code...

        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'region' => $request->region,
            'residence' => $request->residence,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'password' => Hash::make($request->password),
        ]);
        
        return response()->json([
            'success' => True,
        ]);
    }

    public function list_all_doctors() 
    {
        return DoctorResource::collection(Doctor::all()); 
    }

    public function book_appointment(BookAppointmentRequest $request) 
    {
        $data = Appointment::create([
            'user_id' => auth()->guard('api')->id(),
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date
        ]);

        return response()->json(
            $data
        );
    }

    public function appointments()
    {
        return AppointmentResource::collection(
                        Appointment::where( 
                            [
                                'user_id' => auth()->guard('api')->user()->id,
                                'approved' => true
                            ]
                        )->get()
                );
           
    }
}
