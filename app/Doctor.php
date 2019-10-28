<?php

namespace App;

//use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Doctor extends Authenticatable
{
    use Notifiable, HasMultiAuthApiTokens;

    protected $guarded = ['id'];

    
    protected $hidden = [
        'password', 'remember_token',
    ];
}