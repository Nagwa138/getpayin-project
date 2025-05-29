<?php

namespace Database\Seeders;

use App\Models\Platform;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::factory(3)->create();
        $posts->each(function (Post $post) {
            $post->platforms()->attach(Platform::factory(2)->create());
        });
    }
}
