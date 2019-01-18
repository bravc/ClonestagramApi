<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'description' => $faker->realText($maxNbChars = 100, $indexSize = 2),
        'image_url' => $faker->imageUrl($width = 640, $height = 480),
        'likes' => $faker->randomDigit()
    ];
});
