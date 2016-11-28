<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    /**
     * Fillable attributes
     * @var array
     */
    protected $fillable = [
        'post_id',
        'host_id',
        'name',
        'description',
        'departure_pcode',
        'departure_datetime',
        'arrival_pcode',
        'arrival_datetime',
        'num_riders',
        'cost'
    ];

    /**
     * Casting date attributes to Carbon
     * @var array
     */
    public $dates = [
        'departure_datetime',
        'arrival_datetime'
    ];

    /**
     * Returns the relationship users of the trip
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'trip_user', 'trip_id', 'user_id')
            ->withPivot('rating')->select(['id', 'first_name', 'last_name', 'avatar']);
    }

    /**
     * Returns the host relationship of this trip
     * @return mixed
     */
    public function host()
    {
        return $this->belongsTo(User::class)
            ->select(['id', 'first_name', 'last_name', 'avatar']);;
    }

    /**
     * Returns the post relationship of this trip
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Returns the message relations of this trip
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }

    /**
     * Returns the formatted cost
     * @return string
     */
    public function cost()
    {
        return '$' . number_format($this->cost, 2);
    }

    /**
     * Returns the display status of this trip
     * @return string
     */
    public function status()
    {
        if($this->departure_datetime->lt(Carbon::now())){
           return 'Awaiting Riders';
        } else if ($this->arrival_datetime == null) {
            return 'En Route';
        }
        return 'Complete';
    }

    /**
     * Determines if the rider is part of this trip.
     * @param User $user
     * @return null
     */
    public function isRider(User $user)
    {
        foreach ($this->users as $rider){
            if($rider->id == $user->id){
                return $rider;
            }
        }
        return null;
    }

}
