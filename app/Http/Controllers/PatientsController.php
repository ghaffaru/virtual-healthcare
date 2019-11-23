<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Doctor;
use App\Http\Requests\BookAppointmentRequest;
use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\RequestAmbulanceRequest;
use App\Http\Resources\Appointment as AppointmentResource;
use App\Http\Resources\Doctor as DoctorResource;
use Illuminate\Http\Request;
use App\User;
use App\Ambulance;
use App\Http\Resources\PrescriptionResource;
use App\Prescription;
use Hash;
use Illuminate\Support\Carbon;


class PatientsController extends Controller
{
    
    //
    public function __construct()
    {
        $this->middleware('auth:api')
             ->only(['book_appointment','appointments','cancel_appointment','prescriptions','submitPrescription']);
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
        ],200,[
            'Access-Control-Allow-Origin', '*'
        ]);
    }

    public function list_all_doctors() 
    {
        return DoctorResource::collection(Doctor::all()); 
    }

    public function book_appointment(BookAppointmentRequest $request) 
    {
        $check = Appointment::where([
            'doctor_id' => $request->doctor_id,
            ['appointment_date', '>', now()]
        ])->get();

        if ($check->count() > 0) {
            return response()->json([
                'message' => 'appointment already booked',
                'res' => 'booked'
            ]);
        }
        $data = Appointment::create([
            'user_id' => auth()->guard('api')->id(),
            'doctor_id' => $request->doctor_id,
            'appointment_date' => Carbon::create($request->appointment_date)
        ]);

        return response()->json(
            $data
        );
    }


    public function appointments()
    {
        $appointments = Appointment::where( 
            [
                'user_id' => auth()->guard('api')->user()->id,
                ['appointment_date', '>' ,now()]
            ]
        )->get();

        if (count($appointments) > 0) {
            return AppointmentResource::collection(
               $appointments
             );
        } else {
            return response()->json([
                'message' => 'No appointments'
            ]);
        }
       
    }

    public function cancel_appointment(Appointment $appointment)
    {

        if ($appointment->user_id != auth()->guard('api')->id()) {
            return response()->json([
                'message' => 'unauthorized'
            ],403);
        }

        $data = $appointment->delete();

        return response()->json([
            'message' => 'appointment cancelled'
        ]);
    }

    public function request_ambulance(RequestAmbulanceRequest $request) 
    {
        Ambulance::create($request->all());

        return response()->json([
            'success' => 'request underway'
        ]);
    }

    // pharmacy stuff
    public function prescriptions()
    {
        $prescriptions = Prescription::where([
            'user_id' => auth()->guard('api')->id(),
        ])->get();
        
        return PrescriptionResource::collection($prescriptions);
        
    }

    public function prescription(Prescription $prescription)
    {
        return new PrescriptionResource($prescription);
    }
    public function submitPrescription(Prescription $prescription)
    {
        $this->validate(request(), [
            'submitted' => 'required'
        ]);
        
        $prescription->submitted = request()->submitted;
        $prescription->save();

        return new PrescriptionResource($prescription);
    }

}
