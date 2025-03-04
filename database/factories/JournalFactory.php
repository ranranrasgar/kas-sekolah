<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Journal;
use App\Models\Currency;
use App\Models\JournalCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Journal>
 */
class JournalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Journal::class;

    public function definition(): array
    {
        // Format tanggal dengan ddmmyy
        $date = now()->format('mY'); // Menghasilkan ddmmyy seperti 311225 untuk 31 Desember 2025

        // Ambil nomor urut yang berformat 0001, 0002, dst. (untuk nomor urut)
        $sequenceNumber = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT); // Nomor urut dengan 4 digit

        return [
            'date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'reference' => 'TRX-' . $date . '-' . $sequenceNumber, // Format TRX-ddmmyy-0001
            'description' => $this->faker->randomElement([
                'Pembayaran gaji guru',
                'Penerimaan SPP siswa',
                'Pembelian alat tulis kantor',
                'Pembayaran listrik sekolah',
                'Pendapatan dari kantin sekolah'
            ]),
            'currency_id' => Currency::inRandomOrder()->first()->id ?? 1, // Ambil mata uang secara acak
            'category_id' => JournalCategory::inRandomOrder()->first()->id ?? 1, // Ambil kategori secara acak

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
