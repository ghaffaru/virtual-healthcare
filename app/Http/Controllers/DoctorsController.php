<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment as AppointmentResource;
use App\Http\Resources\Appointment;

class DoctorsController extends Controller
{
    //List appointment
    public function list_appointment(){
        
        $appointments = Appointment::where( 
            [
                'doctor_id' => auth()->guard('doctor')->doctor()->id,
                'approved' => true
            ]
        )->get();

        if (count($appointments) > 0) {
            AppointmentResource::collection(
               $appointments
             );
        } else {
            return response()->json([
                'message' => 'No appointments'
            ]);
        }
    }

    //Approve appointment
    public function approve_appointment(Appointment $appointment){
            $appointment->update(['approved' => true]);

            return response()->json([
                'message' => 'Appointment approved.'
            ]);
    }

    //Make prescription
    public function make_prescription(Request $request){
        $prescrition = Prescription::create([
            '' => $request->name,
            'email' => $request->email,
            'region' => $request->region,
            'residence' => $request->residence,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'password' => Hash::make($request->password),
        ]);
    }
}
