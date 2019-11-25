<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffAttendance extends Model
{
    protected $guarded = ['id'];

    public function staff()
    {
        return $this->belongsTo('App\Employee');
    }

    public function admin()
    {
        return $this->belongsTo('App\Admin');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
    }
}
