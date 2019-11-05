<?php

namespace App\Http\Resources;

use App\Doctor;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'doctor' => $doctor->name,
            'doctor_phone' => $doctor->phone,
            'appointment_date' => $this->appointment_date
        ];
    }
}
