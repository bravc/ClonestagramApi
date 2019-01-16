<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('posts/all', 'PostsController@getAll');
Route::resource('posts', 'PostsController');

// set up cloudinary
\Cloudinary::config(array( 
    "cloud_name" => config('app.cloud_name'),
    "api_key" => config('app.api_key'),
    "api_secret" => config('app.api_secret')
  ));

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
