<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientRequest;
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
}
