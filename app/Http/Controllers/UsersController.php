<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PostCollection;
use App\Http\Resources\User as UserResource;

class UsersController extends Controller
{

    /**
     * Get info on another user
     * 
     * @return \Illuminate\Http\Response
     */
    function get($user_id) {
        $user = \App\User::findOrFail($user_id);

        return new UserResource($user);
    }

    /**
     * Follow another user
     * 
     * @return \Illuminate\Http\Response
     */
    function follow(Request $request, $user_id) {
        $other_user = \App\User::findOrFail($user_id);

        // make sure user exists
        if (isset($other_user)) {
            \Auth::user()->following()->save($other_user);
            return response()->json('Followed user', 200);
        } 

        return response()->json('Failed to follow user', 500);
    }

    /**
     * Show followers of another user
     * 
     * @return \Illuminate\Http\Response
     */
    function followers($user_id) {
        $user = \App\User::findOrFail($user_id);

        return $user->followers;
    }

    /**
     * Show users following user
     * 
     * @return \Illuminate\Http\Response
     */
    function following($user_id) {
        $user = \App\User::findOrFail($user_id);

        return $user->following;
    }

    /**
     * Show posts of followers
     * 
     * @return \Illuminate\Http\Response
     */
    function followingPosts(Request $request) {
        $user = $request->user();
        $posts = [];

        // return $user->following->first()->posts->toArray();
        foreach ($user->following as $user) {
            array_push($posts, ...new PostCollection($user->posts));
        }
        return $posts;
    }

    /**
     * Unfollow a user
     * 
     * @return \Illuminate\Http\Response
     */
    function unfollow($user_id) {
        $user_to_unfollow = \App\User::findOrFail($user_id);

        \Auth::user()->following()->detach($user_to_unfollow);

        return response()->json('Unfollowed', 200);
    }

    /**
     * Show user's posts
     * 
     * @return \Illuminate\Http\Response
     */
    function posts($user_id) {
        $user = \App\User::findOrFail($user_id);

        return new PostCollection($user->posts);
    }
}
