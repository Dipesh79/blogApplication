<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = \App\Models\Post::all();
        foreach ($posts as $post) {
            $post->comments()->createMany(\App\Models\Comment::factory()->count(5)->make()->toArray());
        }
    }
}
