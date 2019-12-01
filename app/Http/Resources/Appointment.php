<?php

namespace App\Http\Resources;

use App\Doctor;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class Appointment extends JsonResource
{
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $doctor = Doctor::findOrFail($this->doctor_id);
        
        return [
            'id' => $this->id,
            'doctor' => $doctor->name,
            'doctor_id' => $doctor->id,
            'doctor_phone' => $doctor->phone,
            'appointment_date' => ($this->appointment_date) ,
            'approved' => $this->approved
        ];
    }
}
