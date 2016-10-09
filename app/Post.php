<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_request',
        'departure_pcode',
        'departure_date',
        'num_riders',
        'cost',
    ];

    protected $casts = [
        'is_request' => 'boolean',
        'departure_date' => 'date',
        'num_rider' => 'integer',
        'cost' => 'float'
    ];

    /**
     * This model is the parent of
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function postable()
    {
        return $this->morphTo();
    }

    /**
     * This model belongs to user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poster()
    {
        return $this->belongsTo(User::class);
    }
}
