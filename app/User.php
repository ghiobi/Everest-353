<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable, EntrustUserTrait;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_suspended' => 'boolean',
        'is_visible_address' => 'boolean',
        'is_visible_birth_date' => 'boolean',
        'is_visible_license_num' => 'boolean',
        'is_visible_policies' => 'boolean',
        'is_visible_external_email' => 'boolean',
        'policies' => 'array'
    ];


    /**
     * Attributes that are dates
     * @var array
     */
    public $dates = [
        'birth_date'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'password',
        'email',
        'first_name',
        'last_name',
        'avatar',
        'timezone',
        'address',
        'is_visible_address',
        'birth_date',
        'is_visible_birth_date',
        'license_num',
        'is_visible_license_num',
        'policies',
        'is_visible_policies',
        'external_email',
        'is_visible_external_email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'balance'
    ];

    /**
     * Returns all messages send to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }

    public function rides()
    {
        return $this->belongsToMany(Trip::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function balance(){
        return $this->balance;
    }

    public function avatarUrl($width, $height = null)
    {
        return url( 'images/' . (($this->avatar) ? $this->avatar . '?w=' . $width . ($height)? '&h=' . $height : ''  : 'dummy_avatar.jpg'));
    }
}
