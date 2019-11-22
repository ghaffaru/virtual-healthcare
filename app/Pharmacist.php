<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Pharmacist extends Authenticatable
{
    //
    use Notifiable, HasMultiAuthApiTokens;

    protected $guard = 'pharmacist';

    protected $guarded = ['id'];


    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function attendanceLogs()
    {
        return $this->hasMany('App\StaffAttendance');
    }
    
}
