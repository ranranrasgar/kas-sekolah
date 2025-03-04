<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Coa;
use App\Models\CoaType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coa>
 */
class CoaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Coa::class;
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->numerify('###'),
            'name' => $this->faker->randomElement([
                'Kas',
                'Piutang',
                'Hutang',
                'Modal',
                'Pendapatan SPP',
                'Pendapatan Donasi',
                'Pendapatan BOS',
                'Pendapatan Usaha Sekolah',
                'Beban Gaji Guru',
                'Beban Operasional'
            ]),
            'coa_type_id' => CoaType::factory(),
            'parent_id' => $this->faker->boolean(50) ? Coa::inRandomOrder()->first()?->id : null,
            'created_at' => now(),
        ];
    }
}
