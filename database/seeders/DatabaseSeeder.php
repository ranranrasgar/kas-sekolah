<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Coa;
use App\Models\CoaType;
use App\Models\Currency;
use App\Models\JournalCategory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RoleSeeder::class, // Seeder role harus dipanggil dulu
            UserSeeder::class, // Seeder user setelah role
            MenuSeeder::class, // Seeder menu
            AgamaSeeder::class, // Seeder agama
        ]);

        $classes = \App\Models\Classe::factory(7)->create()->pluck('id')->toArray(); // Buat 6 kelas tetap

        $majors = \App\Models\Major::factory(4)->create()->pluck('id')->toArray();  // Buat 3 jurusan

        $total_students_per_major = 100; // 100 siswa per jurusan
        // input siswa 3 kelas, setiap kelas ada 3 jurusan
        // per jurusan 100 orang
        foreach ($classes as $class_id) {
            foreach ($majors as $major_id) {
                Student::factory($total_students_per_major)->create([
                    'class_id' => $class_id,
                    'major_id' => $major_id,
                ]);
            }
        }

        // Buat data CoaType dan simpan ID-nya
        $coaTypeData = [
            ['prefix' => '100', 'name' => 'Aktiva', 'description' => 'Tipe akun Aktiva'],
            ['prefix' => '200', 'name' => 'Pasiva', 'description' => 'Tipe akun Pasiva'],
            ['prefix' => '300', 'name' => 'Modal', 'description' => 'Tipe akun Modal'],
            ['prefix' => '400', 'name' => 'Pendapatan', 'description' => 'Tipe akun Pendapatan'],
            ['prefix' => '500', 'name' => 'Beban', 'description' => 'Tipe akun Beban'],
        ];

        // Simpan ID dari setiap CoaType yang dibuat
        $coaTypeIds = [];
        foreach ($coaTypeData as $type) {
            $coaType = CoaType::firstOrCreate(
                ['prefix' => $type['prefix']], // Kondisi untuk mencari data
                [
                    'name' => $type['name'],
                    'description' => $type['description'],
                    'created_at' => now(),
                    'updated_at' => now()
                ] // Data yang akan dibuat jika tidak ditemukan
            );
            $coaTypeIds[] = $coaType->id; // Simpan ID
        }

        // Buat minimal 5 akun per tipe CoA dengan indeks numerik
        $coaAccounts = [
            // 🔵 AKTIVA (Aset) -> Index 0
            ['id' => 1, 'code' => '100', 'name' => 'Aktiva', 'coa_type_id' => $coaTypeIds[0], 'parent_id' => null],
            ['id' => 2, 'code' => '101', 'name' => 'Kas di Bank', 'coa_type_id' => $coaTypeIds[0], 'parent_id' => 1],
            ['id' => 3, 'code' => '102', 'name' => 'Kas di Tangan', 'coa_type_id' => $coaTypeIds[0], 'parent_id' => 1],
            ['id' => 4, 'code' => '103', 'name' => 'Piutang SPP', 'coa_type_id' => $coaTypeIds[0], 'parent_id' => 1],
            ['id' => 5, 'code' => '104', 'name' => 'Piutang Donasi', 'coa_type_id' => $coaTypeIds[0], 'parent_id' => 1],
            ['id' => 6, 'code' => '105', 'name' => 'Inventaris Sekolah', 'coa_type_id' => $coaTypeIds[0], 'parent_id' => 1],
            ['id' => 7, 'code' => '106', 'name' => 'Tanah & Bangunan', 'coa_type_id' => $coaTypeIds[0], 'parent_id' => 1],
            ['id' => 8, 'code' => '107', 'name' => 'Kendaraan Sekolah', 'coa_type_id' => $coaTypeIds[0], 'parent_id' => 1],
            ['id' => 9, 'code' => '108', 'name' => 'Peralatan Lab', 'coa_type_id' => $coaTypeIds[0], 'parent_id' => 1],
            ['id' => 10, 'code' => '109', 'name' => 'Aset Lain-lain', 'coa_type_id' => $coaTypeIds[0], 'parent_id' => 1],

            // 🔴 PASIVA (Kewajiban) -> Index 1
            ['id' => 11, 'code' => '200', 'name' => 'Pasiva', 'coa_type_id' => $coaTypeIds[1], 'parent_id' => null],
            ['id' => 12, 'code' => '201', 'name' => 'Utang Sekolah', 'coa_type_id' => $coaTypeIds[1], 'parent_id' => 11],
            ['id' => 13, 'code' => '202', 'name' => 'Utang Operasional', 'coa_type_id' => $coaTypeIds[1], 'parent_id' => 11],
            ['id' => 14, 'code' => '203', 'name' => 'Utang Gaji Karyawan', 'coa_type_id' => $coaTypeIds[1], 'parent_id' => 11],
            ['id' => 15, 'code' => '204', 'name' => 'Utang Pajak', 'coa_type_id' => $coaTypeIds[1], 'parent_id' => 11],
            ['id' => 16, 'code' => '205', 'name' => 'Utang kepada Vendor', 'coa_type_id' => $coaTypeIds[1], 'parent_id' => 11],
            ['id' => 17, 'code' => '206', 'name' => 'Utang Bank', 'coa_type_id' => $coaTypeIds[1], 'parent_id' => 11],
            ['id' => 18, 'code' => '207', 'name' => 'Utang Pinjaman', 'coa_type_id' => $coaTypeIds[1], 'parent_id' => 11],
            ['id' => 19, 'code' => '208', 'name' => 'Utang Sewa', 'coa_type_id' => $coaTypeIds[1], 'parent_id' => 11],
            ['id' => 20, 'code' => '209', 'name' => 'Utang Jangka Panjang', 'coa_type_id' => $coaTypeIds[1], 'parent_id' => 11],

            // 🟡 MODAL (Ekuitas) -> Index 2
            ['id' => 21, 'code' => '300', 'name' => 'Modal', 'coa_type_id' => $coaTypeIds[2], 'parent_id' => null],
            ['id' => 22, 'code' => '301', 'name' => 'Modal Awal', 'coa_type_id' => $coaTypeIds[2], 'parent_id' => 21],
            ['id' => 23, 'code' => '302', 'name' => 'Dana Hibah', 'coa_type_id' => $coaTypeIds[2], 'parent_id' => 21],
            ['id' => 24, 'code' => '303', 'name' => 'Dana BOS', 'coa_type_id' => $coaTypeIds[2], 'parent_id' => 21],
            ['id' => 25, 'code' => '304', 'name' => 'Laba Ditahan', 'coa_type_id' => $coaTypeIds[2], 'parent_id' => 21],
            ['id' => 26, 'code' => '305', 'name' => 'Cadangan Modal', 'coa_type_id' => $coaTypeIds[2], 'parent_id' => 21],
            ['id' => 27, 'code' => '306', 'name' => 'Donasi Tetap', 'coa_type_id' => $coaTypeIds[2], 'parent_id' => 21],
            ['id' => 28, 'code' => '307', 'name' => 'Surplus Anggaran', 'coa_type_id' => $coaTypeIds[2], 'parent_id' => 21],
            ['id' => 29, 'code' => '308', 'name' => 'Modal Investasi', 'coa_type_id' => $coaTypeIds[2], 'parent_id' => 21],
            ['id' => 30, 'code' => '309', 'name' => 'Modal Penyertaan', 'coa_type_id' => $coaTypeIds[2], 'parent_id' => 21],

            // 🟢 PENDAPATAN -> Index 3
            ['id' => 31, 'code' => '400', 'name' => 'Pendapatan', 'coa_type_id' => $coaTypeIds[3], 'parent_id' => null],
            ['id' => 32, 'code' => '401', 'name' => 'Pendapatan SPP', 'coa_type_id' => $coaTypeIds[3], 'parent_id' => 31],
            ['id' => 33, 'code' => '402', 'name' => 'Pendapatan Donasi', 'coa_type_id' => $coaTypeIds[3], 'parent_id' => 31],
            ['id' => 34, 'code' => '403', 'name' => 'Pendapatan BOS', 'coa_type_id' => $coaTypeIds[3], 'parent_id' => 31],
            ['id' => 35, 'code' => '404', 'name' => 'Pendapatan Jasa Pendidikan', 'coa_type_id' => $coaTypeIds[3], 'parent_id' => 31],
            ['id' => 36, 'code' => '405', 'name' => 'Pendapatan Usaha Sekolah', 'coa_type_id' => $coaTypeIds[3], 'parent_id' => 31],
            ['id' => 37, 'code' => '406', 'name' => 'Pendapatan Event Sekolah', 'coa_type_id' => $coaTypeIds[3], 'parent_id' => 31],
            ['id' => 38, 'code' => '407', 'name' => 'Pendapatan Penyewaan Fasilitas', 'coa_type_id' => $coaTypeIds[3], 'parent_id' => 31],
            ['id' => 39, 'code' => '408', 'name' => 'Pendapatan Sponsor', 'coa_type_id' => $coaTypeIds[3], 'parent_id' => 31],
            ['id' => 40, 'code' => '409', 'name' => 'Pendapatan Lain-lain', 'coa_type_id' => $coaTypeIds[3], 'parent_id' => 31],

            // 🟠 BEBAN -> Index 4
            ['id' => 41, 'code' => '500', 'name' => 'Beban', 'coa_type_id' => $coaTypeIds[4], 'parent_id' => null],
            ['id' => 42, 'code' => '501', 'name' => 'Beban Gaji Guru', 'coa_type_id' => $coaTypeIds[4], 'parent_id' => 41],
            ['id' => 43, 'code' => '502', 'name' => 'Beban Gaji Karyawan', 'coa_type_id' => $coaTypeIds[4], 'parent_id' => 41],
            ['id' => 44, 'code' => '503', 'name' => 'Beban Operasional', 'coa_type_id' => $coaTypeIds[4], 'parent_id' => 41],
            ['id' => 45, 'code' => '504', 'name' => 'Beban Listrik & Air', 'coa_type_id' => $coaTypeIds[4], 'parent_id' => 41],
            ['id' => 46, 'code' => '505', 'name' => 'Beban Pemeliharaan', 'coa_type_id' => $coaTypeIds[4], 'parent_id' => 41],
            ['id' => 47, 'code' => '506', 'name' => 'Beban Kegiatan Sekolah', 'coa_type_id' => $coaTypeIds[4], 'parent_id' => 41],
            ['id' => 48, 'code' => '507', 'name' => 'Beban Bahan Ajar', 'coa_type_id' => $coaTypeIds[4], 'parent_id' => 41],
            ['id' => 49, 'code' => '508', 'name' => 'Beban Transportasi', 'coa_type_id' => $coaTypeIds[4], 'parent_id' => 41],
            ['id' => 50, 'code' => '509', 'name' => 'Beban Lain-lain', 'coa_type_id' => $coaTypeIds[4], 'parent_id' => 41]

        ];



        // Simpan akun ke database
        foreach ($coaAccounts as $coa) {
            Coa::firstOrCreate(
                ['code' => $coa['code']],
                [
                    'name' => $coa['name'],
                    'coa_type_id' => $coa['coa_type_id'],
                    'parent_id' => $coa['parent_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
        // Buat data CoaType dan simpan ID-nya
        $journalCatData = [
            // 1. Dana Pemerintah
            ['name' => 'Dana BOS (Bantuan Operasional Sekolah)'],
            ['name' => 'Dana BOSDA (Bantuan Operasional Sekolah Daerah)'],
            ['name' => 'Dana BOP (Bantuan Operasional Pendidikan)'],
            ['name' => 'Dana Hibah atau Bantuan Khusus'],
            ['name' => 'Dana DAK (Dana Alokasi Khusus)'],
            // 2. Sumber Pendanaan dari Orang Tua Siswa
            ['name' => 'SPP dan Uang Sekolah'],
            ['name' => 'Iuran Komite Sekolah'],
            ['name' => 'Sumbangan Pengembangan Institusi (SPI)'],
            // 3. Dana dari Kegiatan Sekolah
            ['name' => 'Koperasi Sekolah'],
            ['name' => 'Penyewaan Fasilitas Sekolah'],
            ['name' => 'Bazaar atau Fundraising'],
            // 4. Bantuan dari Pihak Ketiga
            ['name' => 'CSR (Corporate Social Responsibility)'],
            ['name' => 'Donasi dari Alumni'],
            ['name' => 'Bantuan dari Organisasi atau LSM'],
            ['name' => 'Beasiswa dari Yayasan atau Perusahaan'],
        ];

        // Simpan ID dari setiap CoaType yang dibuat
        $availableCoas = Coa::whereNotNull('parent_id') // Bukan COA utama (bukan root)
            ->whereDoesntHave('children') // Tidak memiliki anak (leaf node)
            ->whereNotIn('id', JournalCategory::pluck('coa_id')) // Hindari duplikasi
            ->pluck('id')
            ->toArray();
        foreach ($journalCatData as $type) {
            if (!empty($availableCoas)) {
                $coaId = array_shift($availableCoas); // Ambil COA pertama yang tersedia
            } else {
                // Jika tidak ada COA yang tersedia, pakai COA default (misalnya COA leaf pertama yang ditemukan)
                $coaId = Coa::whereNotNull('parent_id')->whereDoesntHave('children')->value('id');
            }

            JournalCategory::firstOrCreate(
                ['name' => $type['name']],
                ['coa_id' => $coaId]
            );
        }

        // Insert manual 5 jenis mata uang dengan exchange_rate
        $currencies = [
            ['code' => 'IDR', 'name' => 'Indonesian Rupiah', 'symbol' => 'Rp', 'exchange_rate' => 15500.00],
            ['code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$', 'exchange_rate' => 1.00],
            ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'exchange_rate' => 1.08],
            ['code' => 'JPY', 'name' => 'Japanese Yen', 'symbol' => '¥', 'exchange_rate' => 150.00],
            ['code' => 'GBP', 'name' => 'British Pound', 'symbol' => '£', 'exchange_rate' => 1.27],
        ];

        foreach ($currencies as $currency) {
            Currency::firstOrCreate(
                ['code' => $currency['code']], // Cek apakah sudah ada
                [
                    'name' => $currency['name'],
                    'symbol' => $currency['symbol'],
                    'exchange_rate' => $currency['exchange_rate'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // Buat data Role dan ambil ID-nya
        // $roles = \App\Models\Role::factory(3)->create()->pluck('id')->toArray();

        // Buat User dengan role_id yang valid
        // User::factory(10)->create([
        //     'role_id' => $roles[array_rand($roles)],
        // ]);

        // Buat Admin User
        // User::factory()->create([
        //     'name' => 'Administrator',
        //     'email' => 'ranran.rhansoft@gmail.com',
        //     'role_id' => 1, // Misalnya ID 1 adalah admin
        // ]);
    }
}
