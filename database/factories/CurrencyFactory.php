<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Currency;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Currency::class;
    public function definition(): array
    {
        return [
            'code' => $this->faker->randomElement(['IDR', 'USD', 'EUR', 'SGD']),
            'name' => $this->faker->randomElement(['Rupiah', 'Dollar Amerika', 'Euro', 'Dollar Singapura']),
            'symbol' => $this->faker->randomElement(['Rp', '$', '€', 'S$']),
            'exchange_rate' => $this->faker->randomFloat(2, 1000, 20000),
            'created_at' => now(),
        ];
    }
}
