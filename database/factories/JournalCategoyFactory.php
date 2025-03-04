<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\JournalCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JournalCategoy>
 */
class JournalCategoyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = JournalCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Dana BOS (Bantuan Operasional Sekolah)',
                'Dana BOSDA (Bantuan Operasional Sekolah Daerah)',
                'Dana BOP (Bantuan Operasional Pendidikan)',
                'Dana Hibah atau Bantuan Khusus',
                'Dana DAK (Dana Alokasi Khusus)',
                'SPP dan Uang Sekolah',
                'Iuran Komite Sekolah',
                'Sumbangan Pengembangan Institusi (SPI)',
                'Koperasi Sekolah',
                'Penyewaan Fasilitas Sekolah',
                'Bazaar atau Fundraising',
                'CSR (Corporate Social Responsibility)',
                'Donasi dari Alumni',
                'Bantuan dari Organisasi atau LSM',
                'Beasiswa dari Yayasan atau Perusahaan'
            ]),
            'created_at' => now(),
        ];
    }
}
