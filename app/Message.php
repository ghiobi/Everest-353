<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * Fillable attributes
     */
    protected $fillable = [
        'sender_id',
        'body'
    ];

    /**
     * Returns the user model of the message by doing $message->user.
     * Doing $message->user() returns the relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class)
            ->select(['id', 'first_name', 'last_name', 'avatar']);
    }

    /**
     * Polymorphic relationship makes entities messageable.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function messageable()
    {
        return $this->morphTo();
    }

}
