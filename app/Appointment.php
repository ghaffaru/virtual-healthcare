<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    protected $fillable = ['user_id','doctor_id','appointment_date'];
}
