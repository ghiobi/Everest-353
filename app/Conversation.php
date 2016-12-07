<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->select(['id', 'avatar', 'first_name', 'last_name']);
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }

    public function isUser(User $unknown)
    {
        foreach ($this->users as $user){
            if($user->id == $unknown->id){
                return $user;
            }
        }
        return null;
    }

}
