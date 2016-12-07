<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LocalTrip extends Model
{
    /**
     * Fillable attibutes
     * @var array
     */
    protected $fillable = [
        'departure_time',
        'frequency'
    ];

    /**
     * Castable attributes
     * @var array
     */
    protected $casts = [
        'frequency' => 'array'
    ];

    /**
     * No timestamps
     * @var bool
     */
    public $timestamps = false;

    /**
     * Parent model Post
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function postable()
    {
        return $this->morphOne(Post::class, 'postable');
    }

    /**
     * Returns the appropriate frequency display message.
     * @return string
     */
    public function displayFrequency()
    {
        $display = 'Every ';

        if(count($this->frequency) == 7){
            for ($i = 0; $i < 7; $i++){
                if($this->frequency[$i] == 1){
                    $display .= $this->weekday($i) . ', ';
                }
            }
        }

        return $display . 'at ' . (new Carbon($this->departure_time))->format('g:i A') . '.';
    }

    /**
     * Helper function to conver weekday integer to string.
     * @param $day
     * @return null|string
     */
    private function weekday($day)
    {
        switch ($day){
            case 0: return 'Sunday';
            case 1: return 'Monday';
            case 2: return 'Tuesday';
            case 3: return 'Wednesday';
            case 4: return 'Thursday';
            case 5: return 'Friday';
            case 6: return 'Saturday';
        }
        return null;
    }

}
