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

// get currenr user
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// get all users
Route::middleware('auth:api')->get('/users', function (Request $request) {
    return App\User::all();
});


Route::group(['middleware' => ['auth:api']], function() {
    Route::patch('like', 'PostsController@addLike');
    Route::resource('posts', 'PostsController');
});

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