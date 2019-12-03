<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorsAppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = User::find($this->user_id); 
        return [
            'id' => $this->id,
            'patient_name' => $user->name,
            'appointment_date' => $this->appointment_date,
            'approved' => $this->approved
        ];
    }
}
