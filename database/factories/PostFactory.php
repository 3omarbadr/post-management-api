<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'user_id' => User::factory(),
            'status' => $this->faker->randomElement(PostStatus::cases()),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }

    public function approved(): PostFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => PostStatus::APPROVED,
            ];
        });
    }

    public function pending(): PostFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => PostStatus::PENDING,
            ];
        });
    }
}
