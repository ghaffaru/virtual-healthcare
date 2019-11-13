<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffType extends Model
{
    
    public function staff()
    {
        return $this->hasMany('App\Employee', 'Staff_type_id');
    }
}
