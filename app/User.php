<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email_verified_at', 'updated_at'
    ];

    /**
     * Users post
     */
    public function posts() {
        return $this->hasMany('App\Post');
    }

    /**
     * Define relationship with a comments
     */
    public function comments() {
        return $this->hasMany('App\Comment');
    }

    /**
     * The followers of a user
     */
    public function followers()
    {
        return $this->belongsToMany('App\User', 'user_followers', 'user_id', 'follower_id');
    }

    /**
     * Define relationship with another user
     */
    public function following()
    {
        return $this->belongsToMany('App\User', 'user_followers', 'follower_id', 'user_id');
    }
}
