<?php

namespace App\Http\Resources;

use App\Message;
use App\Pharmacist;
use Illuminate\Http\Resources\Json\JsonResource;

class PharmacistsConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $message = Message::where(['conversation_id', $this->id])->get();
        
        return [
            
            'conversation_id' => $this->id,
            'last_message' => $this->message->last(),
            'participant' => $this->forPharmacist(),
        ];
    }

    public function forPharmacist()
    {   
        if($this->user1_id === auth()->guard('pharmacist')->user()->id)
        {
            $pharmacist = Pharmacist::find($this->user2_id);  

        }else{

            $pharmacist = Pharmacist::find($this->user1_id);
        }
            return [
                
                'id' => $patient['id'],

                'name' => $pharmacist['name'],

                'avatar' => $pharmacist['avatar'] ?? null
        
        ];
    
    }
}
