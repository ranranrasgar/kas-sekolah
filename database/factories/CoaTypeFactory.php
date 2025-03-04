<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CoaType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CoaType>
 */
class CoaTypeFactory extends Factory
{
    protected $model = CoaType::class;

    // Index global untuk memilih nama secara berurutan
    protected static $index = 0;

    public function definition(): array
    {
        // Daftar nama yang tersedia
        $allNames = ['Aktiva', 'Pasiva', 'Pendapatan', 'Beban', 'Modal'];

        // Pastikan index tidak melebihi jumlah nama
        if (static::$index >= count($allNames)) {
            static::$index = 0; // Reset jika sudah habis
        }

        // Ambil nama berdasarkan index
        $name = $allNames[static::$index];
        static::$index++; // Geser ke nama berikutnya

        // Tentukan prefix sesuai ID (misalnya ID=1 → Prefix=100, ID=2 → Prefix=200)
        $id = CoaType::count() + 1; // Hitung ID secara otomatis
        $prefix = $id * 100; // Format 1 -> 100, 2 -> 200, dst.

        return [
            'name' => $name,
            'description' => $this->faker->sentence(),
            'prefix' => $prefix, // Prefix sesuai ID
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
