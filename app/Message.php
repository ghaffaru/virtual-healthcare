<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = ['id'];


    public function staffconversation()
    {
        return $this->belongsTo('App\ConversationType');
    }


    public function conversation()
    {
        return $this->belongsTo('App\Conversation');
    }



}
