<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            "username" => $this->name,
            "email" => $this->email,
            "profile_pic" => $this->profile_pic,
            "followers" => $this->followers->count(),
            "following" => $this->following->count(),
            "posts" => $this->posts
        ];
        
        // return parent::toArray($request);
    }
}
