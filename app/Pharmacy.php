<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pharmacy extends Model
{
    //
    protected $fillable = ['drug_name','quantity','price'];
}
