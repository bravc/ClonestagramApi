<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Post::class, 20)->create()->each(function ($post) {
            $post->user()->save(factory(App\User::class)->make());
        });
    }
}
