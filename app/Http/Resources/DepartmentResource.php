<?php

namespace App\Http\Resources;
use App\Department;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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

        return [
            'id' => $this->id,
            'department' => $this->department,
            'head_of_department' => $department->departmentHead->name ?? 'Head not assign'
        ];
    }
}
