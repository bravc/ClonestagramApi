<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    public $primaryKey = 'id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text'
    ];

    /**
     * Define relationship with a user
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Define relationship with a user
     */
    public function post() {
        return $this->belongsTo('App\User');
    }
}
