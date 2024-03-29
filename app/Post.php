<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    public $primaryKey = 'id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 
    ];

    /**
     * Define relationship with a user
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Define relationship with a comment
     */
    public function comments() {
        return $this->hasMany('App\Comment');
    }
}
