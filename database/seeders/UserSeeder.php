<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil role admin
        $adminRole = Role::where('name', 'admin')->first();
        $guruRole = Role::where('name', 'guru')->first();
        $siswaRole = Role::where('name', 'siswa')->first();

        // Buat user admin
        User::create([
            'name' => 'Admin',
            'email' => 'ranran250880@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id
        ]);

        // Buat user guru
        User::create([
            'name' => 'Guru',
            'email' => 'ranran.rhansoft@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => $guruRole->id
        ]);

        // Buat user siswa
        User::create([
            'name' => 'Siswa',
            'email' => 'siswa@example.com',
            'password' => Hash::make('password'),
            'role_id' => $siswaRole->id
        ]);
    }
}
