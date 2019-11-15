<?php

namespace App\Http\Controllers\AdminsControllers;

use App\Department;
use Illuminate\Http\Request;
use App\Http\Requests\DepartmentFormRequest;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\DepartmentStaffListResource;
use App\Http\Controllers\Controller;

class DepartmentsController extends Controller
{

    public function __construct()
    {
        $this->middleware('api');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $department = Department::all();

        return DepartmentResource::collection($department);
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
    public function store(DepartmentFormRequest $request)
    {
       // $this->authorize('manage');

        //abort_if(!auth('api'), 403);

        Department::create($request->all());

        return response(['success' => 'department added'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {

        return new DepartmentResource($department);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function assignHead(Department $department, Request $request)
    {
        $request->validate([

            'staff_id' => 'required|integer'
        ]);

        $department->head_of_department = $request->staff_id;

        $department->save();

        return response(['success' => 'Department head added'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentFormRequest $request, Department $department)
    {
        $department->update($request->all());

        return response(['updated' => $department], 200);
    }

    public function staffList(Department $department)
    {
        $departmentStaffList = $department->staff;

        foreach($departmentStaffList as $departmentStaff)
        {
            $departmentStaffList['staff_type'] = $departmentStaff->type->staff_type;
        }

        if($departmentStaffList->count() > 0)
        {
            return response()->json(['departmentStaffList' => $departmentStaffList], 200);
        
        }else{

            return response()->json(['No staff added for this department'], 200);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return response()->json(['success' => 'department deleted'], 200);
    }
}
