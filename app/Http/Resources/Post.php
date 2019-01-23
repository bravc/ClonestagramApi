<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CommentCollection;

class Post extends JsonResource
{
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
            "description" => $this->description,
            "image_url" => $this->image_url,
            "created_at" => $this->created_at->toArray()['formatted'],
            "likes" => $this->likes,
            "user" => $this->user,
            "comments" => new CommentCollection($this->comments)
        ];
    }
}
