<?php

namespace App\Http\Resources;
use App\Department;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentStaffListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $department = Department::find($this->id);

        foreach($department->staff as $staff)
        {

            return [
                [
                'name' => $staff->name,//->name,
                'avatar' => $staff->avatar,
                'designation' => $staff->designation ?? 'member',
                'staff_type' => $staff->type->staff_type,

                ]
            ]; 

        }

    }
}
