<?php

namespace App\Http\Controllers\AdminsControllers;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StaffManagementFormRequest;
use App\Http\Resources\StaffResource;

class StaffsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();

        foreach($employees as $employee)
        {
            $employee['department'] = $employee->staffDepartment->department; 
            
            $employee['staff_type'] = $employee->type->staff_type;
        }

        return StaffResource::collection($employees);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
                'gender' => $request->gender,
                'staff_type_id' => $request->staff_type_id,
                'department_id' => $request->department_id,
                'qualification' => $request->qualification,
            
            ]);
    
        

        if($request->hasFile('avatar'))
        {
            $fileNameToStore = $request->file('avatar')->getClientOriginalName(); 

            # image path
            $path = 'public/images/'. $employee->id;

            $request->file('avatar')->storeAs($path, $fileNameToStore);

            $employee->avatar = '/storage/images/'.$employee->id. '/'. $fileNameToStore;

            $employee->save();

        }

     

  
        return response()->json(['success' => 'Staff added'], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        
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
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
