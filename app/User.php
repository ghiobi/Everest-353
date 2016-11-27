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
        return $this->hasMany(Post::class, 'poster_id');
    }

    public function balance(){
        return $this->balance;
    }

    public function avatarUrl($width, $height = null)
    {
        return url( 'images/' . (($this->avatar) ? $this->avatar . '?w=' . $width . ($height)? '&h=' . $height : ''  : 'dummy_avatar.jpg'));
    }

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function postedTrips()
    {
        return $this->hasManyThrough(Trip::class, Post::class, 'poster_id');
    }

    public function getRating()
    {
        return Cache::remember('user.rating.'. $this->id, 1, function () {
            $sumRating = 0;
            $numberOfRating = 0;

            // Get all the ratings for all trips for all posts of that user
            $posts = $this->posts()->with('trips.users')->get();
            foreach($posts as $post) {
                foreach ($post->trips as $trip) {
                    foreach ($trip->users as $user) {
                        $user_rating = $user->pivot->rating;
                        if ($user_rating != null) {
                            $sumRating += $user_rating;
                            $numberOfRating++;
                        }
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
