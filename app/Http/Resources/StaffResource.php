<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Employee;

class StaffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $employee = Employee::find($this->id);
        return [

            "name" => $this->name,
            "qualification" => $this->qualification,
            "staff_type" => $employee->type->staff_type,
            "email" => $this->email,
            "gender" => $this->gender,
            "phone" => $this->phone,
            "department" => $employee->staffDepartment->department,
            "avatar" => $this->avatar
        
        ];
    }
}
