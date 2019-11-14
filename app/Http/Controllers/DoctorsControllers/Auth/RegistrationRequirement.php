<?php

namespace App\Http\Controllers\DoctorsControllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Department;
use App\Specialization;



class RegistrationRequirement extends Controller
{
    public function getRequirement()
    {
        $department = Department::all('id', 'department');

        $specialization = Specialization::all('id', 'specialization');

        $attributes = collect(['departments' => $department, 'specializations' => $specialization]);

        return response([$attributes], 200);

    }
}
