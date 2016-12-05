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

        // If the trip is not found
        if($trip == null) {

            // If there is a departure date (one time trip) and
            // departure date is in the future, create a trip
            if($this->departure_date != null && $this->departure_date->gt(Carbon::now())){

                $departure_time = '12:00:00';
                if($this->postable_type == LocalTrip::class) {
                    $departure_time = $this->postable->departure_time;
                }

                $trip = Trip::create([
                    'post_id' => $this->id,
                    'host_id' => $this->poster_id,
                    'name' => $this->name,
                    'description' => $this->description,
                    'departure_datetime' => $this->departure_date->toDateString() . ' ' . $departure_time,
                    'departure_pcode' => $this->departure_pcode,
                    'arrival_pcode' => $this->destination_pcode,
                    'num_riders' => $this->num_riders,
                    'cost' => $this->cost,
                ]);
            }

            // Otherwise, if it is a repeated post, create a trip for the next date
            elseif(! $this->one_time) {

                // Finding the next date
                $futureDate = null;
                if($this->postable_type == LocalTrip::class) {

                    // For local trip:
                    $frequencies = $this->postable->frequency;
                    $potentialNexts = array();
                    foreach($frequencies as $i => $frequency) {
                        if($frequency == 1) {
                            $potentialNexts[] = Carbon::now()->next($i)->toDateString();
                        }
                    }

                    // Minimum of all potential next trips
                    // After the sorting, the index are not orderd, cannot take index at 0 for the first
                    // Loop once
                    asort($potentialNexts);
                    $count_max_one = 0;
                    foreach($potentialNexts as $date) {
                        $futureDate = $date;
                        if(++$count_max_one > 0) {
                            break;
                        }
                    }

                } else {

                    // For long distance frequent trip

                    // Weekly (every x day of the week)
                    $frequency = $this->postable->frequency;
                    if($frequency >= 0 && $frequency <= 6) {
                        $futureDate = Carbon::now()->next($frequency)->toDateString();
                    }

                    // Bi-weekly or monthly
                    elseif($frequency == 7 || $frequency == 8) {
                        // Try obtaining the date of the last trip from the database, and add two weeks to it
                        $last_trip = $this->trips()->orderBy('departure_datetime', 'asc')->first();

                        // Use dummy future date to determine the real date based on either
                        // current date or the date of the last trip
                        $dummy_futureDate = Carbon::now();
                        if($last_trip != null) {
                            $dummy_futureDate = new Carbon($last_trip->departure_datetime->toDateTimeString());
                        }
                        if($frequency == 7 ) {
                            while($dummy_futureDate->lt(Carbon::now())) {
                                $dummy_futureDate = $dummy_futureDate->addWeek(2);
                            }
                        } else {
                            while($dummy_futureDate->lt(Carbon::now())) {
                                $dummy_futureDate = $dummy_futureDate->addMonth(1);
                            }
                        }

                        $futureDate = $dummy_futureDate->toDateString();

                    }
                }

                // Append the time
                if($this->postable_type == LocalTrip::class) {
                    $futureDate .= ' ' . $this->postable->departure_time;
                } else {
                    $futureDate .= ' 12:00:00';
                }

                // Create the trip
                $trip = Trip::create([
                    'post_id' => $this->id,
                    'host_id' => $this->poster_id,
                    'name' => $this->name,
                    'description' => $this->description,
                    'departure_datetime' => $futureDate,
                    'departure_pcode' => $this->departure_pcode,
                    'arrival_pcode' => $this->destination_pcode,
                    'num_riders' => $this->num_riders,
                    'cost' => $this->cost,
                ]);
            }
        }

        return $trip;
    }
}
