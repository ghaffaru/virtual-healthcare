<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    //
    protected $fillable = ['user_id','doctor_id','case_history','medication','medication_from_pharmacist'];
}
