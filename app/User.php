<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable, EntrustUserTrait;

    /**
     * The attributes that should be casted to native types.
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
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'balance'
    ];

    /**
     * Returns all messages send to the user.
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }

    /**
     * Rides the user is currently taking
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rides()
    {
        return $this->belongsToMany(Trip::class);
    }

    /**
     * User's posts
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'poster_id');
    }

    /**
     * Trips the user has posted
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function hosts()
    {
        return $this->hasMany(Trip::class, 'host_id');
    }

    /**
     * The conversations the user is part of.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class);
    }

    /**
     * Returns the display balance of the user
     * @return string
     */
    public function balance(){
        return '$' . number_format($this->balance, 2);
    }

    /**
     * Returns the correct avatar image
     * @param $width
     * @param null $height
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function avatarUrl($width, $height = null)
    {
        return url( 'images/' . (($this->avatar) ? $this->avatar . '?w=' . $width . (($height)? '&h=' . $height : '')  : 'dummy_avatar.jpg'));
    }

    /**
     * Returns the display full name
     * @return string
     */
    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Returns the rating of the user, updates every 1 minute.
     * @return mixed
     */
    public function getRating()
    {
        return Cache::remember('user.rating.'. $this->id, 1, function () {
            $sumRating = 0;
            $numberOfRating = 0;

            // Get all the ratings for all trips for all posts of that user
            $trips = $this->hosts()->with('users')->get();

            foreach($trips as $trip) {
                foreach ($trip->users as $user) {
                    $user_rating = $user->pivot->rating;
                    if ($user_rating != null) {
                        $sumRating += $user_rating;
                        $numberOfRating++;
                    }
                }
            };

            // Map the average number of stars to a letter ranking
            $letter_ranking = 'N/A';

            if($numberOfRating > 0) {
                $average_rating = $sumRating/$numberOfRating;
                if($average_rating > 9) {
                    $letter_ranking = 'A+';
                } else if($average_rating > 8) {
                    $letter_ranking = 'A';
                } else if($average_rating > 7) {
                    $letter_ranking = 'A-';
                } else if($average_rating > 6) {
                    $letter_ranking = 'B+';
                } else if($average_rating > 5) {
                    $letter_ranking = 'B';
                } else if($average_rating > 4) {
                    $letter_ranking = 'B-';
                } else if($average_rating > 3) {
                    $letter_ranking = 'C+';
                } else if($average_rating > 2) {
                    $letter_ranking = 'C';
                } else if($average_rating > 1) {
                    $letter_ranking = 'C-';
                } else if($average_rating >= 0) {
                    $letter_ranking = 'F';
                }
            }
            return $letter_ranking;
        });
    }
}
