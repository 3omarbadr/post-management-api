<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->count(5)
            ->has(Post::factory()->count(3))
            ->create();

        Post::factory()->count(5)->approved()->create();
        Post::factory()->count(3)->pending()->create();
    }
}
