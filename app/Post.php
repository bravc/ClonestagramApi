<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    public $primaryKey = 'id';
    public $timestamps = true;

    /**
     * Define relationship with a user
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "description" => "Cool pic",
            "image_url" => $this->image_url,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "likes" => $this->likes,
            "author" => $this->author
        ];
    }
}
