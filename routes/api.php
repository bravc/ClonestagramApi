<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// get current user
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// get all users
Route::middleware('auth:api')->get('/users', function (Request $request) {
    return App\User::all();
});


/**
 * Posts and their routes
 */
Route::group(['middleware' => ['auth:api']], function() {
    Route::patch('posts/{post}/likes', 'PostsController@addLike');
    Route::patch('posts/{post}/dislikes', 'PostsController@removeLike');
    Route::resource('posts', 'PostsController');

    Route::group(['prefix' => 'users'], function() {
        Route::patch('follow/{user}', 'UsersController@follow');
        Route::get('followers/{user}', 'UsersController@followers');
        Route::get('following/{user}', 'UsersController@following');
        Route::get('{user}/posts', 'UsersController@posts');
        Route::patch('unfollow/{user}', 'UsersController@unfollow');
    });
});

/**
 * User functions
 */
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});