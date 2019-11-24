<?php

namespace App\Http\Resources;

use App\Message;
use App\Doctor;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
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
            'participant' => $this->forDoctor(),
        ];
    }

    public function forDoctor()
    {   
        if($this->user1_id === auth()->guard('doctor')->user()->id)
        {
            $doctor = Doctor::find($this->user2_id);  

        }else{

            $doctor = Doctor::find($this->user1_id);
        }
            return [
                
                'id' => $patient['id'],

                'name' => $doctor['name'],

                'avatar' => $doctor['avatar'] ?? null
        
        ];
    }

}
