<?php

namespace App\Http\Resources;

use App\Message;
use App\Employee;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffConversationResource extends JsonResource
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
            'participant' => $this->forStaff(),
        ];
    }

    public function forStaff()
    {   
        if($this->user1_id === auth()->guard('staff')->user()->id)
        {
            $staff = Employee::find($this->user2_id);  

        }else{

            $staff = Employee::find($this->user1_id);
        }
            return [
                
                'name' => $staff['name'],

                'avatar' => $staff['avatar'] ?? null
        
        ];
    }

}
