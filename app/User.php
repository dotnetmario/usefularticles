<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Relations
     * 
     * 
     */

    /**
     * Get the comments for the user.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Get the replies for the user.
     */
    public function replies()
    {
        return $this->hasMany('App\Reply');
    }

    /**
     * Get the ratings for the user.
     */
    public function ratings()
    {
        return $this->hasMany('App\Rating');
    }
}
