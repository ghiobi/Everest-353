<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalTrip extends Model
{
    protected $fillable = [
        'departure_time',
        'frequency'
    ];

    protected $casts = [
      'frequency' => 'array'
    ];

    public $timestamps = false;

    public function postable()
    {
        return $this->morphOne(Post::class, 'postable');
    }
}
