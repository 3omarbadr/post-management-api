<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        Post::all()->each(function ($post) {
            Comment::factory()
                ->count(rand(1, 5))
                ->create([
                    'post_id' => $post->id
                ]);
        });
    }
}
