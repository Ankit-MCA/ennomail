<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use Faker\Factory as Faker;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $users = User::all();

        foreach ($users as $user) {
            Post::factory(10)->create([
                'user_id' => $user->id,
                'content' => $faker->paragraph,
            ]);
        }
        Post::factory(100)->create();


        Post::factory(100)->create()->each(function ($post) {
            Comment::factory(10)->create(['post_id' => $post->id, 'user_id' => $post->user_id]);
        });
    }
}
