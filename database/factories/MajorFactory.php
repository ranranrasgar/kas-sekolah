<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Major;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Major>
 */
class MajorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Major::class;

    public function definition(): array
    {
        static $index = 0; // Gunakan static agar tidak mengulang data
        $majors = ['Siswa Baru', 'ATPH', 'Multimedia', 'DPIB'];

        return [
            'major_name' => $majors[$index++], // Ambil satu per satu sesuai urutan
            'created_at' => now(),
        ];
    }
}
