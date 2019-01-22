<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "likes" => $this->likes,
            "author" => $this->user,
            "comments" => $this->comments
        ];
    }
}
