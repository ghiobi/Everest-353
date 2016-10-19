<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LongDistanceTrip extends Model
{
    /**
     * Fillable attributes
     *
     * @var array
     */
    protected $fillable = [
        'departure_city',
        'departure_province',
        'destination_city',
        'destination_province',
        'frequency'
    ];

    public function postable()
    {
        return $this->morphOne(Post::class, 'postable');
    }
}
