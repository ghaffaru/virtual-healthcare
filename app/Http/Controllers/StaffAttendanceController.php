<?php

namespace App\Http\Controllers;

use App\StaffAttendance;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Employee;
use App\Doctor;
use App\Admin;

class StaffAttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('api');
    }

    public function requestCode($logs)
    {
        
        $path = 'images/'.now().'qrcode.png';

        #generate qrcode
        QrCode::format('png')->size(250)
                            ->generate($logs->qrcode, storage_path('app/public/'.$path));

        return response()->json([
            
            'qrcode' => '/storage/'.$path, #symbolic path for file

            'logs_id' => $logs->id
        
        ], 200); 

    }

    public function requestCodeForDoctor(Doctor $doctor)
    {
        $logs = $doctor->attendanceLogs()->create(['qrcode' => str_random(5)]);

        return $this->requestCode($logs);
    }

    public function requestCodeForAdmin(Admin $admin)
    {
        $logs = $admin->attendanceLogs()->create(['qrcode' => str_random(5)]);

        return $this->requestCode($logs);
    }


    public function requestCodeForStaff(Employee $employee)
    {
        $logs = $employee->attendanceLogs()->create(['qrcode' => str_random(5)]);

        return $this->requestCode($logs);
    }


    public function checkin(StaffAttendance $staffAttendance)
    {
        if($staffAttendance)
        {
            if(request()->qrcode === $staffAttendance->qrcode)
            {
                $staffAttendance->update(['checkin' => now()]);

                return response()->json(['success' => 'You checked in'], 200);
            
            }else{

                return response()->json(['forbidden' => 'Invalid code'], 403);
            }

        }
        
    }


    public function checkout(staffAttendance $staffAttendance)
    {
        $staffAttendance->update(['checkout' => now()]);

        return response()->json(['success' => 'You checked out'], 200);
    }

}
