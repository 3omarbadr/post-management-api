<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Permission;

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'create posts',
                'edit posts',
                'delete posts',
                'publish posts',
                'manage users',
                'manage roles'
            ]),
            'guard_name' => 'api'
        ];
    }
}
