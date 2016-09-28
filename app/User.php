<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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

    protected $guarded = [
        'is_suspended',
        'balance'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
