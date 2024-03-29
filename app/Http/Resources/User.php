<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PostCollection;

class User extends JsonResource
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
            "name" => $this->name,
            "email" => $this->email,
            "profile_pic" => $this->profile_pic,
            "created_at" => $this->created_at->toArray()['formatted'],
            "followers" => $this->followers->count(),
            "following" => $this->following->count(),
            "posts" => new PostCollection($this->posts)
        ];
        
        // return parent::toArray($request);
    }
}
