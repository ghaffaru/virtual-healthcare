<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [

            "name" => $this->name,
            "qualification" => $this->qualification,
            "staff_type" => $this->staff_type,
            "email" => $this->email,
            "gender" => $this->gender,
            "phone" => $this->phone,
            "department" => $this->department,
            "avatar" => $this->avatar
        
        ];
    }
}
