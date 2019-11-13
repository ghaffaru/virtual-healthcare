<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HospitalEventResource extends JsonResource
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
            
            'id' => $this->id,

            'event' => $this->event,

            'description' => $this->description,

            'start_date' => $this->start_date,
            
            'end_date' => $this->end_date
        ];

    }
}
