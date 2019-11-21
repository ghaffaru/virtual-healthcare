<?php

namespace App\Http\Controllers;

use App\Message;
use App\Conversation;
use App\Employee;
use App\ConversationType;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function __constructor()
    {
        return $this->middleware('api');
    }
    
 
    public function staffChat(MessagesRequest $request, Employee $employee)
    {
        #field 
        $field = 'staffschat';

        $this->store($employee, $field);
    }


    public function doctorChat(MessagesRequest $request, Doctor $doctor)
    {
        $field = 'doctorschat';

        $this->store($doctor, $field);
    }


    public function pharmacistChat(MessagesRequest $request, Pharmacist $pharmacist)
    {
        $field = 'pharmacistschat';

        $this->store($pharmacist, $field);
    }


    public function doctor_patient()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($user, $field)
    {
        #check if conversation exist
        $conversation = Conversation::where([['user1_id', $user->id], ['user2_id', request()->id], [$field, true]])

                        ->orWhere([['user1_id', request()->id], ['user2_id', $user->id], [$field, true]])->first();

        if(!$conversation)
        {   
            #conversation fields
            $attributes = [

                'user1_id' => $user->id,
                'user2_id' => request()->id,
                $field => true
            ];

            #create and return conversation instance
            $conversation = $this->createConversation($attributes);  
        }

         #check for file attachment
         if(request()->hasFile('attachment'))
         {
             #save file
            $attachment = $this->storeFile($conversation);
         
        } else {

            $attachment = null;
        } 

        #store message and attachment
        $message = $conversation->addMessage($user->id, request()->id, nl2br(request()->message), $attachment);

        return ['message' => nl2br(request()->message)];
        
    }


    public function createConversation($conversation_between)
    {
        $conversation = Conversation::create($conversation_between);

        return $conversation;
    }


    public function storeFile(Conversation $conversation)
    {
        $fileNameToStore = request()->file('attachment')->getClientOriginalName();

          # image path
          $path = 'public/attachments/'. $conversation->id;

          request()->file('attachment')->storeAs($path, $fileNameToStore);

          $attachment = '/storage/attachments/'.$conversation->id. '/'. $fileNameToStore; #symbolic path

          return $attachment;

    }
    


}
