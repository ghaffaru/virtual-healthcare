<?php

namespace App\Http\Resources;

use App\Message;
use App\Doctor;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorPatientConversationResource extends JsonResource
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
        if($this->user1_id == $this->user2_id) #auth->id = user1_id = user2_id
        {
            $doctor = User::find($this->user2_id);  #use any of the ids to return the patient

        }elseif($this->user1_id == auth()->guard('api')->user()->id)
        {
            $doctor = Doctor::find($this->user2_id);  

        }else{

            $doctor = Doctor::find($this->user1_id);
        }
            
        return [
                
            'id' => $doctor['id'],
            
            'name' => $doctor['name'],

            'avatar' => $doctor['avatar'] ?? null
        
        ];
    }
}
