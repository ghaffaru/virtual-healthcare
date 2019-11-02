<?php

namespace App\Policies;

use App\Admin;
use App\HospitalEvent;
use Illuminate\Auth\Access\HandlesAuthorization;

class HospitalEventPolicy
{
    use HandlesAuthorization;
    
   

    /**
     * Determine whether the user can view the hospital event.
     *
     * @param  \App\User  $user
     * @param  \App\HospitalEvent  $hospitalEvent
     * @return mixed
     */
    public function manage(Admin $admin)
    {
        if (auth('api'))
        {
            return true;
        }
    }

}
