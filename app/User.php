<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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
        'password', 'remember_token',
    ];
}
