<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LongDistanceTrip extends Model
{
    /**
     * Fillable attributes
     * @var array
     */
    protected $fillable = [
        'departure_city',
        'departure_province',
        'destination_city',
        'destination_province',
        'frequency'
    ];

    /**
     * No timestamps
     * @var bool
     */
    public $timestamps = false;

    /**
     * References the parent model Post
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function postable()
    {
        return $this->morphOne(Post::class, 'postable');
    }

    /**
     * Returns the appropriate frequency display message
     * @return null|string
     */
    public function displayFrequency()
    {
        switch ($this->frequency){
            case 0: return 'Every Sunday';
            case 1: return 'Every Monday';
            case 2: return 'Every Tuesday';
            case 3: return 'Every Wednesday';
            case 4: return 'Every Thursday';
            case 5: return 'Every Friday';
            case 6: return 'Every Saturday';
            case 7: return 'Twice-Monthly';
            case 8: return 'Monthly';
        }
        return null;
    }
}
