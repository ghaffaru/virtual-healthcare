<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Doctor;
use App\User;
use App\Message;
use App\Employee;
use App\Department;
use App\Pharmacist;
use App\Conversation;
use App\Events\MessageReceived;
use App\Http\Requests\MessagesRequest;
use App\Http\Requests\DoctorPatientsChatRequest;
use App\Http\Requests\DepartmentsChatRequest;
use App\Http\Resources\MessagesResource;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\StaffConversationResource;
use App\Http\Resources\PharmacistsConversationResource;
use App\Http\Resources\DoctorPatientConversationResource;
use App\Http\Resources\PatientDoctorConversationResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function __constructor()
    {
        return $this->middleware(['api']);
    }
    
    /* 
        store conversation by type
    */
    public function staffChat(MessagesRequest $request, Employee $employee)
    {
        $this->store($employee, 'staffschat');
    }


    public function doctorChat(MessagesRequest $request, Doctor $doctor)
    {
        $this->store($doctor, 'doctorschat');
    }


    public function pharmacistChat(MessagesRequest $request, Pharmacist $pharmacist)
    {
        $this->store($pharmacist, 'pharmacistschat');
    }

    /* 
        You may use this for doctor patient chat
    */
    public function doctor_patient(MessagesRequest $request, Doctor $doctor) 
    {
        #from doctor
        // return 'i am here';
        $this->store($doctor, 'doctor_patientschat');

    }

    public function patient_doctor(MessagesRequest $request) 
    {
        // $appointment = Appointment::where([
        //     'user_id' => auth()->guard('api')->id(),
        //     'approved' => true,
        //     'doctor_id' => $request->id,
        //     // ['appointment_date', '>=', now()]
        // ])->get();

        // if ($appointment->count() > 0) {
            $this->store(auth()->guard('api')->user(), 'doctor_patientschat');
        // }else {
        //     return response()->json([
        //         'message' => 'Unauthorized'
        //     ], 403);
        // }


    }
    #end of storing by type


    /*
        Retreive conversations by type
    */

    public function getstaffChat(Employee $employee)
    {

       return $this->getConversations('staffschat', 'staff');
    }


    public function getdoctorChats(Doctor $doctor)
    {

        return $this->getConversations('doctorschat', 'doctor');
    }


    public function getpharmacistChat(Pharmacist $pharmacist)
    {

        return $this->getConversations('pharmacistschat', 'pharmacist');
    }

    public function getDoctorPatientChat()
    {
        // return auth()->guard('doctor')->user();

        return $this->getConversations('doctor_patientschat', 'doctor');
    }


    public function getPatientDoctorChat()
    {
        return $this->getConversations('doctor_patientschat', 'api');
    }


    public function storeDepartmentChat(DepartmentsChatRequest $request, Department $department)
    {
        if(!$conversation = $department->conversation)
        {
            $attributes = ['department_id' => $department->id];

            $conversation = $this->createConversation($attributes);
        }

        $message = [

            'sender_id' => request()->sender_id,

            'message' => nl2br(request()->message),

            'attachment' => $this->storeFile($conversation) ?? null

            
        
        ];
        
        #store message and return response
        $conversation->addMessage($message);

        return response()->json(['message' => nl2br(request()->message)], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($user, $field)
    {
        #get conversation between sender and recipent(s)
        $conversation = Conversation::where([['user1_id', $user->id], ['user2_id', request()->id], [$field, true]])

                        ->orWhere([['user1_id', request()->id], ['user2_id', $user->id], [$field, true]])->first();
        
        #check if conversation exist
        if(!$conversation)
        {   # none existing conversation 

            #conversation fields
            $attributes = [

                'user1_id' => $user->id ,
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

            'attachment' => $this->storeFile($conversation) ?? null, #if no file attachment set field to null
            
            'owner' => request()->owner
        ];
        #store message and attachment
        $message = $conversation->addMessage($message);
        event(new MessageReceived($message));

        return response()->json(['message' => $message]);
        
    }


    public function createConversation($conversation_between)
    {
        $conversation = Conversation::create($conversation_between);

        return $conversation;
    }

    
    #store file attachments
    
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

  
    public function getConversations($field, $user_guard)
    {

        $auth_id = auth()->guard($user_guard)->id();

        $conversation = Conversation::where([['user1_id', $auth_id], [$field, true]])

                        ->orWhere([['user2_id', $auth_id], [$field, true]])->get();


        /*
            return the conversation_id with last message, 
            and conversation participant name and image
        */
        if($user_guard == 'staff')
        {
            return StaffConversationResource::collection($conversation);

        }elseif($user_guard == 'pharmacist'){

            return PharmacistsConversationResource::collection($conversation);
        
        }elseif($user_guard == 'api' ){

            return DoctorPatientConversationResource::collection($conversation);
        
        }elseif ($user_guard == 'doctor' && $field == 'doctor_patientschat'){

            return PatientDoctorConversationResource::collection($conversation);
        }else

            return ConversationResource::collection($conversation);

        }  
    

    # Retreive messages for existing conversation

    public function chatWith(Conversation $conversation)
    {
 
        $message = $conversation->message;

        return MessagesResource::collection($message);

    }


    public function download(Message $message)
    {
        if(!$message->attachment)
        {
            return response()->json(['file' => 'No attachment found'], 404);
        }

        $path = $message->attachment;

         //headers
         $headers = array(
        
            'Content-Type: application/pdf',
            
        );

        return response()->download(public_path($path), 'file Attachment', $headers);
    }
}