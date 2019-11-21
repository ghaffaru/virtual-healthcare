<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $guarded = ['id'];


    public function user1()
    {
        
        return $this->belongsTo('App\Employee', 'user1_id');
        
    }


    public function user2()
    {
        
        return $this->belongsTo('App\Employee', 'user2_id');
        
    }


    public function message()
    {
        return $this->hasMany('App\Message');
    }

    public function addMessage($sender, $recipient, $message, $attachment)
    {
       $message = $this->message()->create([

            'sender_id' => $sender,

            'recipient_id' => $recipient,

            'message' => $message,

            'attachment' => $attachment

        ]);

        return $message;

    }
}
