<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = ['id'];
    

    public function staff()
    {
        return $this->hasMany('App\Employee', 'department_id');
    }

    
    public function departmentHead()
    {
        return $this->belongsTo('App\Employee', 'head_of_department');
    }
}
