<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Role::class;
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['admin', 'user', 'editor']),
            'description' => fake()->sentence(),
        ];
    }
}
