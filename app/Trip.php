<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('rating');
    }

    public function owner()
    {
        return $this->belongsTo(Post::class)->poster();
    }

    //foreach($trip->users as $user){
    //  $user->pivot->rating
    //}
}
