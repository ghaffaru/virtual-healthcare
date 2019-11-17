<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;
class Pharmacist extends Authenticatable
{
    //
    use Notifiable, HasMultiAuthApiTokens;

    protected $guarded = ['id'];
}
