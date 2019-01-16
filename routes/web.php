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

Route::get('/upload', function () {
    // $path = $request->file('image')->storeAs('public/postimages', $filename);

    // $file = $request->file('image')->getRealPath();
    // // $path = Storage::disk('public')->path($filename);
    // \Log::info($file);

    \Cloudinary\Uploader::upload("/Users/cameronbraverman/Development/notInstagramAPI/storage/app/public/postimages/Cam1547614504.538484.png", []);

    return 200;
});


Route::resource('posts', 'PostsController');

\Cloudinary::config(array( 
    "cloud_name" => config('app.cloud_name'),
    "api_key" => config('app.api_key'),
    "api_secret" => config('app.api_secret')
  ));