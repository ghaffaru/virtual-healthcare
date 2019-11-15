<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

    protected $guarded = ['id'];
    
    
    public function type()
    {
        
        return $this->belongsTo('App\StaffType', 'staff_type_id');

    }


    public function staffDepartment()
    {
        
        return $this->belongsTo('App\Department', 'department_id');

    }

    public function staff()
    {
        
        return $this->hasOne('App\Department', 'head_of_department');

    }


}
