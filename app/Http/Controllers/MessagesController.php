<?php

namespace App\Http\Controllers;

use App\Message;
use App\Employee;
use App\Pharmacist;
use App\Conversation;
use App\Http\Requests\MessagesRequest;
use App\Http\Controllers\Controller;
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


    /*

    */

    public function getstaffChat(Employee $employee)
    {
        #field 
        $field = 'staffschat';

        $this->store($employee, $field);
    }


    public function getdoctorChat(Doctor $doctor)
    {
        $field = 'doctorschat';

        $this->store($doctor, $field);
    }


    public function getpharmacistChat(MessagesRequest $request, Pharmacist $pharmacist)
    {
        $field = 'pharmacistschat';

        $this->store($pharmacist, $field);
    }



    public function doctor_patient()
    {

    }

    public function storeDepartmentChat(Department $department)
    {
        if(!$conversation = $department->conversation)
        {
            $attributes = ['department_id' => $department->id];

            $conversation = $this->createConversation($attributes);
        }

        $message = [

            'sender_id' => request()->id,

            'message' => request()->message,

            'attachment' => $this->storeFile($conversation) ?? null
        
        ];
        
        #$messageAttributes
        $conversation->addMessage($message);
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

        #message to store
        $message = [

            'sender_id' => $user->id,

            'recipient_id' => request()->id,

            'message' => request()->message,

            'attachment' => $this->storeFile($conversation) ?? null #if no file attachment set field to null
        
        ];
        #store message and attachment
        $message = $conversation->addMessage($message);

        return ['message' => nl2br(request()->message)];
        
    }


    public function createConversation($conversation_between)
    {
        $conversation = Conversation::create($conversation_between);

        return $conversation;
    }


    public function storeFile(Conversation $conversation)
    {
        if(request()->hasFile('attachment'))
        {

            $fileNameToStore = request()->file('attachment')->getClientOriginalName();

            # image path
            $path = 'public/attachments/'. $conversation->id;

            request()->file('attachment')->storeAs($path, $fileNameToStore);

            $attachment = '/storage/attachments/'.$conversation->id. '/'. $fileNameToStore; #symbolic path

            return $attachment;

        }

    }

    public function chatWith(User $user)
    {

       $conversation = Conversation::where([['user1_id', auth()->id()], ['user2_id', $user->id]])

        ->orWhere([['user1_id', $user->id], ['user2_id', auth()->id()]])->first();

        return $conversation->message;

        //return MessageResource::collection($messages);
     // return view('chats.show', compact('messages', 'user'));
    }

    


}
