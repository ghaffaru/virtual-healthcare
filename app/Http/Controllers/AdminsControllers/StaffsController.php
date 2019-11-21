<?php

namespace App\Http\Controllers\AdminsControllers;

use App\Employee;
use App\StaffType;
use App\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StaffManagementFormRequest;
use App\Http\Resources\StaffResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Jobs\StaffRegistrationAlert;

class StaffsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['multiauth:admin','api']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();

        /* foreach($employees as $employee)
        {
            $employee['department'] = 
            $employee['staff_type'] = ;
        } */

        return StaffResource::collection($employees);
        //->header([
          //  'Access-Control-Allow-Origin', '*'
        //]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getstaffRegistrationRequirement()
    {
        $department = Department::all('id', 'department');

        $staff_type = StaffType::all('id', 'staff_type');

        return response()->json([
            
            'departments' => $department,
            
            'staff_type' => $staff_type
            
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaffManagementFormRequest $request)
    {

        $employee = Employee::create([

                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make('vhealth123'),
                'gender' => $request->gender,
                'staff_type_id' => $request->staff_type_id,
                'department_id' => $request->department_id,
                'qualification' => $request->qualification,
            
            ]);

        $this->saveStaffAvatar($employee);

        if(StaffRegistrationAlert::dispatch($employee))
        {
            return response()->json(['success' => 'Staff added'], 200);
        }

  
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $employee['staff_type'] = $employee->type->staff_type;

        $employee['department'] = $employee->staffDepartment->department; 

        return new StaffResource($employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(StaffManagementFormRequest $request, Employee $employee)
    {
        $employee->update($request->all());

        $this->saveStaffAvatar($employee);

        return response()->json(['success' => 'staff\'s details modified'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        Storage::deleteDirectory('public/images/'.$employee->id);
        
        $employee->delete();

        return response()->json(['success' => $employee->name .' deleted'], 200);
    }



    public function saveStaffAvatar(Employee $employee)
    {
        
        if(request()->hasFile('avatar'))
        {
            $fileNameToStore = request()->file('avatar')->getClientOriginalName(); 

            # image path
            $path = 'public/images/employees/'. $employee->id;

            request()->file('avatar')->storeAs($path, $fileNameToStore);

            $employee->avatar = '/storage/images/employees'.$employee->id. '/'. $fileNameToStore;

            $employee->save();

        }

    }
}
