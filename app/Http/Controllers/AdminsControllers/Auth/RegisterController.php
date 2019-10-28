<?php

namespace App\Http\Controllers\AdminsControllers\Auth;

use App\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminsRegistrationFormRequest;

class RegisterController extends Controller
{
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(AdminsRegistrationFormRequest $request)
    {
       $admin = Admin::create([

            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
        ]);


        return response([

            'admin' => $admin,
        ]);
    }
}
