<?php

namespace App\Http\Resources;

use App\Message;
use App\User;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientDoctorConversationResource extends JsonResource
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
        if($this->user1_id == $this->user2_id)
        {
            $patient = User::find($this->user2_id);  #use any of the ids to return the patient

        }elseif($this->user1_id == auth()->guard('doctor')->id()){

            $patient = User::find($this->user2_id);  

        }else{

            $patient = User::find($this->user1_id);
        }
            
        return [
                
            'id' => $patient['id'],
            
            'name' => $patient['name'],

            'avatar' => $patient['avatar'] ?? null
        
        ];
    
    }
}
