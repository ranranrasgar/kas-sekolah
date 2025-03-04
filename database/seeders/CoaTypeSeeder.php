<?php

namespace Database\Seeders;

use App\Models\CoaType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class CoaTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua data lama (Opsional, jika ingin reset)
        CoaType::truncate();

        // Generate 5 data coa_type menggunakan factory
        CoaType::factory()->count(5)->create();
    }
}
