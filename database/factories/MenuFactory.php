<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Menu::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'route' => $this->faker->randomElement(['dashboard', 'transaksi', 'inventori', 'akademik']),
            'icon' => $this->faker->randomElement(['home', 'money', 'book']),
            'ordering' => $this->faker->numberBetween(1, 10),
        ];
    }
}
