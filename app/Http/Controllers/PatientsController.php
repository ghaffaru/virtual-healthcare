<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientRequest;
use Illuminate\Http\Request;
use App\User;

class PatientsController extends Controller
{
    //
    public function store(CreatePatientRequest $request)
    {
        # code...
        $user = User::create($request->all());

        $user->patient_id = 1;

        $user->save();
        
        return response()->json([
            'success' => True,
            'patient_id' => 1,
        ]);
    }
}
