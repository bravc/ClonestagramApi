<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PostCollection;

class UsersController extends Controller
{
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
