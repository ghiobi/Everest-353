<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    /**
     * Enables soft deletes in the database
     */
    use SoftDeletes;

    /**
     * Fillables attributes
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'is_request',
        'one_time',
        'departure_pcode',
        'destination_pcode',
        'departure_date',
        'num_riders',
        'cost',
    ];

    /**
     * Castable attributes
     * @var array
     */
    protected $casts = [
        'one_time' => 'boolean',
        'is_request' => 'boolean',
        'departure_date' => 'date',
        'num_rider' => 'integer',
        'cost' => 'float'
    ];

    /**
     * Cast attributes to Carbon objects
     * @var array
     */
    protected $dates = ['deleted_at', 'departure_date'];

    /**
     * Returns the child LocalTrip or LongDistanceTrip
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function postable()
    {
        return $this->morphTo();
    }

    /**
     * Returns the comments of the post
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }

    /**
     * This model belongs to user.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poster()
    {
        return $this->belongsTo(User::class)
            ->select(['id', 'first_name', 'last_name', 'avatar']);
    }

    /**
     * Returns the trip relation model
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Formats the price
     * @return string
     */
    public function cost(){
        return '$' . number_format($this->cost, 2);
    }

    /**
     * Gets the next departure date.
     * @return mixed
     */
    public function nextDeparture()
    {
        return $this->departure_date;
    }

    /**
     * Finds the next Trip.
     * @return Trip
     */
    public function getNextTrip()
    {
        $trip = $this->trips()->where('departure_datetime', '>', Carbon::now())->first();

        //Load the postable item.
        $this->load('postable');
        if($trip == null){

            $depature_date = null;

            if($this->departure_date->gte(Carbon::now())){
                if($this->postable_type == LocalTrip::class){

                } else {

                }
            }

            $trip = Trip::create([
                'host_id' => $this->poster_id,
                'post_id' => $this->id,
                'departure_datetime' => $this->departure_date->toDateString() . ' ' . $this->postable->departure_time,
                'departure_pcode' => $this->departure_pcode,
                'arrival_pcode' => $this->destination_pcode,
                'num_riders' => $this->num_riders,
                'cost' => $this->cost,
            ]);

        }


        return $trip;
    }
}
