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
            'user_id' => $request->user_id,
            'doctor_id' => $request->doctor_id,
            'case_history' => $request->case_history,
            'medication' => $request->medication,
            'medication_from_pharmacist' => $request->medication_from_pharmacist,
        ]);

        return respone()->json([
            success => true,
        ]);
    }
}
