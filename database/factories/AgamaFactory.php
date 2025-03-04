<?php

namespace Database\Factories;

use App\Models\Agama;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agama>
 */
class AgamaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Agama::class;

    public function definition()
    {
        // return [
        //     'name' => $this->faker->word, // Menggunakan kata acak untuk agama
        // ];
    }
}
