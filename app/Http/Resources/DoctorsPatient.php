<?php

namespace App\Http\Resources;

use App\Chat;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorsPatient extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $lastChat = Chat::where([
        //     'user_id' => $this->id
        // ])->get()->last();
        return [
            'name' => $this->name,
            // 'message' => $lastChat

        ];
    }
}
