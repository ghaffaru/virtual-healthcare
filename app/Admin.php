<?php

namespace App;

//use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Admin extends Authenticatable
{
    use Notifiable, HasMultiAuthApiTokens;

    protected $guard = 'admin';

    protected $guarded = ['id'];

    
    protected $hidden = [
        'password', 'remember_token',
    ];



    public function attendanceLogs()
    {
        return $this->hasMany('App\StaffAttendance');
    }
}
