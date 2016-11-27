<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

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

    protected $casts = [
        'one_time' => 'boolean',
        'is_request' => 'boolean',
        'departure_date' => 'date',
        'num_rider' => 'integer',
        'cost' => 'float'
    ];

    protected $dates = ['deleted_at', 'departure_date'];

    /**
     * This model is the parent of
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function postable()
    {
        return $this->morphTo();
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }

    public function countMessages()
    {
        return $this->messages()->count();
    }

    /**
     * This model belongs to user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poster()
    {
        return $this->belongsTo(User::class)
            ->select(['id', 'first_name', 'last_name', 'avatar']);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function cost(){
        return $this->cost;
    }

    public function nextDeparture()
    {
        return $this->departure_date;
    }

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
