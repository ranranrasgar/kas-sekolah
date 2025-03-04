<?php

namespace Database\Seeders;

use App\Models\Agama;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan nama baru 'name' untuk agama
        Agama::create(['name' => 'Islam']);
        Agama::create(['name' => 'Kristen']);
        Agama::create(['name' => 'Katolik']);
        Agama::create(['name' => 'Hindu']);
        Agama::create(['name' => 'Buddha']);
        Agama::create(['name' => 'Konghucu']);

        // Atau menggunakan factory untuk data acak
        // \App\Models\Agama::factory(10)->create();
    }
}
