<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    public $dates = [
        'departure_datetime',
        'arrival_datetime'
    ];

    public function riders()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('rating')->select(['id', 'first_name', 'last_name', 'avatar']);
    }

    public function poster()
    {
        return $this->belongsTo(Post::class)->poster();
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function status()
    {
        if($this->departure_datetime->lt(Carbon::now())){
           return 'Awaiting Riders';
        } else if ($this->arrival_datetime == null) {
            return 'En Route';
        }
        return 'Complete';
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }

    //foreach($trip->users as $user){
    //  $user->pivot->rating
    //}
}
