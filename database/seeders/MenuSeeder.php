<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Menu Utama
        $keuangan = Menu::create(['name' => 'Keuangan', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-exchange-alt']);
        $akademik = Menu::create(['name' => 'Akademik', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-book-open']);
        $inventori = Menu::create(['name' => 'Inventori', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-boxes']);
        $sarana = Menu::create(['name' => 'Sarana & Prasarana', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-tools']);
        $kepegawaian = Menu::create(['name' => 'Kepegawaian', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-users']);
        $masterdata = Menu::create(['name' => 'Master Data', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-database']);
        $pengguna = Menu::create(['name' => 'Manajemen Pengguna', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-user-cog']);

        // === Submenu Keuangan ===
        $danaBos = Menu::create(['parent_id' => $keuangan->id, 'name' => 'Keuangan Sekolah', 'route' => 'bankbook.index', 'category_id' => '1', 'icon' => 'fas fa-university']);
        Menu::create(['parent_id' => $danaBos->id, 'name' => 'Data Keuangan', 'route' => 'bankbook.index', 'category_id' => '1', 'icon' => 'fas fa-file-invoice-dollar']);
        Menu::create(['parent_id' => $danaBos->id, 'name' => 'Penerimaan Dana', 'route' => 'bankbook.index', 'category_id' => '1', 'icon' => 'fas fa-wallet']);
        Menu::create(['parent_id' => $danaBos->id, 'name' => 'Pengeluaran Dana', 'route' => 'bankbook.index', 'category_id' => '1', 'icon' => 'fas fa-money-check-alt']);
        Menu::create(['parent_id' => $danaBos->id, 'name' => 'Rekapitulasi Keuangan', 'route' => 'bankbook.index', 'category_id' => '1', 'icon' => 'fas fa-chart-line']);

        $spp = Menu::create(['parent_id' => $keuangan->id, 'name' => 'SPP & Pembayaran', 'route' => 'journals.index', 'category_id' => '6', 'icon' => 'fas fa-wallet']);
        Menu::create(['parent_id' => $spp->id, 'name' => 'Data Pembayaran SPP', 'route' => 'journals.index', 'category_id' => '6', 'icon' => 'fas fa-file-invoice-dollar']);
        Menu::create(['parent_id' => $spp->id, 'name' => 'Riwayat Pembayaran Siswa', 'route' => 'journals.index', 'category_id' => '6', 'icon' => 'fas fa-history']);
        Menu::create(['parent_id' => $spp->id, 'name' => 'Rekapitulasi SPP', 'route' => 'journals.index', 'category_id' => '6', 'icon' => 'fas fa-file-alt']);

        $gaji = Menu::create(['parent_id' => $keuangan->id, 'name' => 'Gaji Guru dan Staf', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-hand-holding-usd']);
        Menu::create(['parent_id' => $gaji->id, 'name' => 'Data Gaji Guru', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-users']);
        Menu::create(['parent_id' => $gaji->id, 'name' => 'Pembayaran Gaji', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-money-bill-wave']);
        Menu::create(['parent_id' => $gaji->id, 'name' => 'Laporan Gaji', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-file-invoice']);
        Menu::create(['parent_id' => $gaji->id, 'name' => 'Tunjangan dan Potongan', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-percentage']);
        Menu::create(['parent_id' => $gaji->id, 'name' => 'Rekapitulasi Pembayaran Gaji', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-chart-bar']);
        Menu::create(['parent_id' => $gaji->id, 'name' => 'Penggajian Bulanan', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-calendar-check']);

        $seragam = Menu::create(['parent_id' => $keuangan->id, 'name' => 'Seragam Sekolah', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-tshirt']);
        Menu::create(['parent_id' => $seragam->id, 'name' => 'Penjualan Seragam', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-shopping-cart']);
        Menu::create(['parent_id' => $seragam->id, 'name' => 'Pembayaran Seragam', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-receipt']);
        Menu::create(['parent_id' => $seragam->id, 'name' => 'Piutang Seragam', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-hand-holding-usd']);
        Menu::create(['parent_id' => $seragam->id, 'name' => 'Rekapitulasi Penjualan', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-file-alt']);

        $accounting = Menu::create(['parent_id' => $keuangan->id, 'name' => 'Accounting', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-calculator']);
        Menu::create(['parent_id' => $accounting->id, 'name' => 'Chart of Account', 'route' => 'coa.index', 'category_id' => '0', 'icon' => 'fas fa-th-list']);
        Menu::create(['parent_id' => $accounting->id, 'name' => 'Jurnal Umum', 'route' => 'journal.general', 'category_id' => '0', 'icon' => 'fas fa-book']);
        Menu::create(['parent_id' => $accounting->id, 'name' => 'Jurnal Penyesuaian', 'route' => 'journal.adjustment', 'category_id' => '0', 'icon' => 'fas fa-exchange-alt']);
        Menu::create(['parent_id' => $accounting->id, 'name' => 'Buku Besar', 'route' => 'ledger.index', 'category_id' => '0', 'icon' => 'fas fa-book-open']);
        Menu::create(['parent_id' => $accounting->id, 'name' => 'Neraca Lajur', 'route' => 'trialbalance.index', 'category_id' => '0', 'icon' => 'fas fa-columns']);
        Menu::create(['parent_id' => $accounting->id, 'name' => 'Arus Kas', 'route' => 'cashflow.index', 'category_id' => '0', 'icon' => 'fas fa-hand-holding-water']);
        Menu::create(['parent_id' => $accounting->id, 'name' => 'Laba Rugi', 'route' => 'profitloss.index', 'category_id' => '0', 'icon' => 'fas fa-chart-line']);
        Menu::create(['parent_id' => $accounting->id, 'name' => 'Neraca', 'route' => 'balance.index', 'category_id' => '0', 'icon' => 'fas fa-balance-scale']);

        // === Submenu Akademik ===
        $data_master_siswa = Menu::create(['parent_id' => $akademik->id, 'name' => 'Data Master Siswa', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-user-graduate']);
        Menu::create(['parent_id' => $data_master_siswa->id, 'name' => 'Data Siswa', 'route' => 'students.index', 'category_id' => '0', 'icon' => 'fas fa-users']);
        Menu::create(['parent_id' => $data_master_siswa->id, 'name' => 'Data Kenaikan Siswa', 'route' => 'students.promotion', 'category_id' => '0', 'icon' => 'fas fa-user-graduate']);
        Menu::create(['parent_id' => $data_master_siswa->id, 'name' => 'Data Bantuan Siswa', 'route' => 'students.assistance', 'category_id' => '0', 'icon' => 'fas fa-chalkboard']);
        Menu::create(['parent_id' => $data_master_siswa->id, 'name' => 'Data Jurusan Siswa', 'route' => 'students.majors', 'category_id' => '0', 'icon' => 'fas fa-graduation-cap']);
        Menu::create(['parent_id' => $data_master_siswa->id, 'name' => 'Data Orang Tua Siswa', 'route' => 'students.parents', 'category_id' => '0', 'icon' => 'fas fa-user-friends']);
        Menu::create(['parent_id' => $data_master_siswa->id, 'name' => 'Data Foto Siswa', 'route' => 'students.photos', 'category_id' => '0', 'icon' => 'fas fa-camera-retro']);

        $jadwal = Menu::create(['parent_id' => $akademik->id, 'name' => 'Jadwal Pelajaran', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-book-reader']);
        Menu::create(['parent_id' => $jadwal->id, 'name' => 'Jadwal Kelas', 'route' => 'schedule.class', 'category_id' => '0', 'icon' => 'fas fa-calendar']);
        Menu::create(['parent_id' => $jadwal->id, 'name' => 'Jadwal Guru', 'route' => 'schedule.teacher', 'category_id' => '0', 'icon' => 'fas fa-user-clock']);
        Menu::create(['parent_id' => $jadwal->id, 'name' => 'Jadwal Mata Pelajaran', 'route' => 'schedule.subjects', 'category_id' => '0', 'icon' => 'fas fa-book-open']);
        Menu::create(['parent_id' => $jadwal->id, 'name' => 'Pembuatan Jadwal', 'route' => 'schedule.create', 'category_id' => '0', 'icon' => 'fas fa-edit']);

        $absensi = Menu::create(['parent_id' => $akademik->id, 'name' => 'Absensi', 'route' => '#', 'category_id' => '0', 'icon' => 'far fa-address-book']);
        Menu::create(['parent_id' => $absensi->id, 'name' => 'Absensi Siswa', 'route' => 'attendance.students', 'category_id' => '0', 'icon' => 'fas fa-calendar']);
        Menu::create(['parent_id' => $absensi->id, 'name' => 'Absensi Guru', 'route' => 'attendance.teachers', 'category_id' => '0', 'icon' => 'fas fa-user-clock']);
        Menu::create(['parent_id' => $absensi->id, 'name' => 'Laporan Absensi Siswa', 'route' => 'attendance.students.report', 'category_id' => '0', 'icon' => 'fas fa-book-open']);
        Menu::create(['parent_id' => $absensi->id, 'name' => 'Laporan Absensi Guru', 'route' => 'attendance.teachers.report', 'category_id' => '0', 'icon' => 'fas fa-edit']);

        $nilai = Menu::create(['parent_id' => $akademik->id, 'name' => 'Nilai Siswa', 'route' => '#', 'category_id' => '0', 'icon' => 'far fa-address-card']);
        Menu::create(['parent_id' => $nilai->id, 'name' => 'Data Nilai Siswa', 'route' => 'grades.index', 'category_id' => '0', 'icon' => 'fas fa-file-alt']);
        Menu::create(['parent_id' => $nilai->id, 'name' => 'Rekap Nilai Siswa', 'route' => 'grades.recap', 'category_id' => '0', 'icon' => 'fas fa-list']);
        Menu::create(['parent_id' => $nilai->id, 'name' => 'Rapor Siswa', 'route' => 'grades.report', 'category_id' => '0', 'icon' => 'fas fa-award']);
        Menu::create(['parent_id' => $nilai->id, 'name' => 'Grafik Nilai Siswa', 'route' => 'grades.chart', 'category_id' => '0', 'icon' => 'fas fa-chart-line']);


        $data_master_alumni = Menu::create(['parent_id' => $akademik->id, 'name' => 'Data Master Alumni', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-graduation-cap']);
        Menu::create(['parent_id' => $data_master_alumni->id, 'name' => 'Data Alumni', 'route' => 'alumni.index', 'category_id' => '0', 'icon' => 'fas fa-users']);
        Menu::create(['parent_id' => $data_master_alumni->id, 'name' => 'Rekap Alumni', 'route' => 'alumni.recap', 'category_id' => '0', 'icon' => 'fas fa-clipboard-list']);
        Menu::create(['parent_id' => $data_master_alumni->id, 'name' => 'Statistik Alumni', 'route' => 'alumni.stats', 'category_id' => '0', 'icon' => 'fas fa-chart-pie']);
        Menu::create(['parent_id' => $data_master_alumni->id, 'name' => 'Tracer Study Alumni', 'route' => 'alumni.tracer', 'category_id' => '0', 'icon' => 'fas fa-search']);
        Menu::create(['parent_id' => $data_master_alumni->id, 'name' => 'Prestasi Alumni', 'route' => 'alumni.achievements', 'category_id' => '0', 'icon' => 'fas fa-medal']);

        // === Submenu Inventori ===
        $gudang = Menu::create(['parent_id' => $inventori->id, 'name' => 'Gudang Sekolah', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-boxes']);
        Menu::create(['parent_id' => $gudang->id, 'name' => 'Data Barang', 'route' => 'gudang.barang', 'category_id' => '0', 'icon' => 'fas fa-box-open']);
        Menu::create(['parent_id' => $gudang->id, 'name' => 'Kategori Barang', 'route' => 'gudang.kategori', 'category_id' => '0', 'icon' => 'fas fa-tags']);
        Menu::create(['parent_id' => $gudang->id, 'name' => 'Stok Barang', 'route' => 'gudang.stok', 'category_id' => '0', 'icon' => 'fas fa-chart-bar']);
        Menu::create(['parent_id' => $gudang->id, 'name' => 'Mutasi Barang', 'route' => 'gudang.mutasi', 'category_id' => '0', 'icon' => 'fas fa-exchange-alt']);
        Menu::create(['parent_id' => $gudang->id, 'name' => 'Peminjaman Barang', 'route' => 'gudang.peminjaman', 'category_id' => '0', 'icon' => 'fas fa-handshake']);
        Menu::create(['parent_id' => $gudang->id, 'name' => 'Riwayat Transaksi', 'route' => 'gudang.transaksi', 'category_id' => '0', 'icon' => 'fas fa-history']);

        // === Submenu Manajemen Pengguna ===
        $hakAkses = Menu::create(['parent_id' => $pengguna->id, 'name' => 'Hak Akses & Peran', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-user-lock']);
        Menu::create(['parent_id' => $hakAkses->id, 'name' => 'Role Administrator', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-user-cog']);
        Menu::create(['parent_id' => $hakAkses->id, 'name' => 'Role Guru', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-user-graduate']);
        Menu::create(['parent_id' => $pengguna->id, 'name' => 'Kelola Pengguna', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-user-edit']);
        Menu::create(['parent_id' => $pengguna->id, 'name' => 'Log Aktivitas', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-clipboard']);

        // Submenu untuk Sarana & Prasarana
        $ruangKelas = Menu::create(['parent_id' => $sarana->id, 'name' => 'Ruang Kelas', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-chalkboard']);
        Menu::create(['parent_id' => $ruangKelas->id, 'name' => 'Data Ruang Kelas', 'route' => 'sarana.kelas', 'category_id' => '0', 'icon' => 'fas fa-list']);
        Menu::create(['parent_id' => $ruangKelas->id, 'name' => 'Fasilitas Kelas', 'route' => 'sarana.fasilitas', 'category_id' => '0', 'icon' => 'fas fa-chair']);

        $laboratorium = Menu::create(['parent_id' => $sarana->id, 'name' => 'Laboratorium', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-flask']);
        Menu::create(['parent_id' => $laboratorium->id, 'name' => 'Lab Komputer', 'route' => 'sarana.lab.komputer', 'category_id' => '0', 'icon' => 'fas fa-desktop']);
        Menu::create(['parent_id' => $laboratorium->id, 'name' => 'Lab Sains', 'route' => 'sarana.lab.sains', 'category_id' => '0', 'icon' => 'fas fa-vial']);

        $perpustakaan = Menu::create(['parent_id' => $sarana->id, 'name' => 'Perpustakaan', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-book']);
        Menu::create(['parent_id' => $perpustakaan->id, 'name' => 'Data Buku', 'route' => 'sarana.perpus.buku', 'category_id' => '0', 'icon' => 'fas fa-book-open']);
        Menu::create(['parent_id' => $perpustakaan->id, 'name' => 'Peminjaman Buku', 'route' => 'sarana.perpus.peminjaman', 'category_id' => '0', 'icon' => 'fas fa-hand-holding']);

        // Submenu untuk Kepegawaian
        $guru = Menu::create(['parent_id' => $kepegawaian->id, 'name' => 'Guru & Staff', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-user-tie']);
        Menu::create(['parent_id' => $guru->id, 'name' => 'Data Guru', 'route' => 'kepegawaian.guru', 'category_id' => '0', 'icon' => 'fas fa-users']);
        Menu::create(['parent_id' => $guru->id, 'name' => 'Presensi Guru', 'route' => 'kepegawaian.presensi', 'category_id' => '0', 'icon' => 'fas fa-check-circle']);

        $jadwal = Menu::create(['parent_id' => $kepegawaian->id, 'name' => 'Jadwal Mengajar', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-calendar-alt']);
        Menu::create(['parent_id' => $jadwal->id, 'name' => 'Lihat Jadwal', 'route' => 'kepegawaian.jadwal', 'category_id' => '0', 'icon' => 'fas fa-eye']);
        Menu::create(['parent_id' => $jadwal->id, 'name' => 'Edit Jadwal', 'route' => 'kepegawaian.jadwal.edit', 'category_id' => '0', 'icon' => 'fas fa-edit']);

        // Submenu untuk Master Data
        $siswa = Menu::create(['parent_id' => $masterdata->id, 'name' => 'Data Siswa', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-user-graduate']);
        Menu::create(['parent_id' => $siswa->id, 'name' => 'Daftar Siswa', 'route' => 'masterdata.siswa', 'category_id' => '0', 'icon' => 'fas fa-list']);
        Menu::create(['parent_id' => $siswa->id, 'name' => 'Tambah Siswa', 'route' => 'masterdata.siswa.tambah', 'category_id' => '0', 'icon' => 'fas fa-plus']);

        $mapel = Menu::create(['parent_id' => $masterdata->id, 'name' => 'Mata Pelajaran', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-book-open']);
        Menu::create(['parent_id' => $mapel->id, 'name' => 'Daftar Mata Pelajaran', 'route' => 'masterdata.mapel', 'category_id' => '0', 'icon' => 'fas fa-list']);
        Menu::create(['parent_id' => $mapel->id, 'name' => 'Tambah Mata Pelajaran', 'route' => 'masterdata.mapel.tambah', 'category_id' => '0', 'icon' => 'fas fa-plus']);

        $ekskul = Menu::create(['parent_id' => $masterdata->id, 'name' => 'Ekstrakurikuler', 'route' => '#', 'category_id' => '0', 'icon' => 'fas fa-futbol']);
        Menu::create(['parent_id' => $ekskul->id, 'name' => 'Daftar Ekskul', 'route' => 'masterdata.ekskul', 'category_id' => '0', 'icon' => 'fas fa-list']);
        Menu::create(['parent_id' => $ekskul->id, 'name' => 'Tambah Ekskul', 'route' => 'masterdata.ekskul.tambah', 'category_id' => '0', 'icon' => 'fas fa-plus']);
    }
}
