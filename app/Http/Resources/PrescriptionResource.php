<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrescriptionResource extends JsonResource
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
            'case_history' => $this->case_history,
            'medication' => $this->medication,
            'submitted' => $this->submitted,
            'drug_issued' => $this->drug_issued
        ];
    }
}
