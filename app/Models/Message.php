<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Message extends Model
{
    protected $fillable = ['sender_id' , 'receiver_id' , 'content'] ;


    public function sender(): BelongsToMany     
    {
        return $this -> belongsToMany(User::class , 'sender_id') ; 
    }

    public function receiver()
    {
        return $this -> belongsToMany(User::class , 'receiver_id') ; 
    }



}
