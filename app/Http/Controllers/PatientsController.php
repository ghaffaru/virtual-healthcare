<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Http\Requests\CreatePatientRequest;
use App\Http\Resources\Doctor as DoctorResource;
use Illuminate\Http\Request;
use App\User;
use Hash;
class PatientsController extends Controller
{
    //
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
}
