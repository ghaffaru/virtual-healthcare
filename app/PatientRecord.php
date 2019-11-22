<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientRecord extends Model
{
    //

    protected $fillable = ['user_id','prescription_id','report_type','description'];
}
