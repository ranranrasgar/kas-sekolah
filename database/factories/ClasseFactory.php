<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Classe;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classe>
 */
class ClasseFactory extends Factory
{
    protected $model = Classe::class;

    public function definition(): array
    {
        static $index = 0; // Untuk memastikan data yang di-generate urut
        $classes = ['Siswa Baru', 'Kelas 7', 'Kelas 8', 'Kelas 9', 'Kelas 10', 'Kelas 11', 'Kelas 12'];

        // Pastikan tidak lebih dari jumlah kelas yang diinginkan
        if ($index >= count($classes)) {
            return [];
        }

        return [
            'class_name' => $classes[$index++], // Ambil nama kelas dari array
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
