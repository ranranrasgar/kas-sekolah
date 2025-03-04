@php
    use App\Models\JournalCategory;
    $journalCategories = JournalCategory::all();

    // Fungsi untuk mengecek apakah menu atau submenu sedang aktif
    function isActiveMenu($paths)
    {
        foreach ($paths as $path) {
            if (Request::is(trim($path, '/') . '*')) {
                return true;
            }
        }
        return false;
    }

    $menus = [
        (object) [
            'title' => 'Transaksi',
            'icon' => 'fas fa-exchange-alt',
            'submenus' => [
                (object) [
                    'title' => 'Keuangan Sekolah',
                    'icon' => 'fas fa-layer-group',
                    'submenus' => $journalCategories
                        ->map(function ($category) {
                            return (object) [
                                'title' => $category->name,
                                'path' => '/journals?category_id=' . $category->id,
                                'icon' => 'fas fa-folder', // Bisa diganti sesuai kebutuhan
                            ];
                        })
                        ->toArray(),
                ],
                (object) [
                    'title' => 'Inventaris Sekolah',
                    'icon' => 'fas fa-boxes',
                    'submenus' => [
                        (object) ['title' => 'Data Inventaris', 'path' => '/inventaris', 'icon' => 'fas fa-warehouse'],
                        (object) [
                            'title' => 'Pengadaan Barang',
                            'path' => '/inventaris/pengadaan',
                            'icon' => 'fas fa-truck-loading',
                        ],
                        (object) [
                            'title' => 'Pemeliharaan Barang',
                            'path' => '/inventaris/pemeliharaan',
                            'icon' => 'fas fa-tools',
                        ],
                    ],
                ],
            ],
        ],
        (object) [
            'title' => 'Akademik',
            'icon' => 'fas fa-graduation-cap',
            'submenus' => [
                (object) [
                    'title' => 'Data Siswa',
                    'icon' => 'fas fa-users',
                    'submenus' => [
                        (object) [
                            'title' => 'Semua Siswa',
                            'path' => '/akademik/siswa',
                            'icon' => 'fas fa-user-graduate',
                        ],
                        (object) [
                            'title' => 'Siswa Baru',
                            'path' => '/akademik/siswa-baru',
                            'icon' => 'fas fa-user-plus',
                        ],
                        (object) [
                            'title' => 'Kenaikan Kelas',
                            'path' => '/akademik/kenaikan-kelas',
                            'icon' => 'fas fa-level-up-alt',
                        ],
                        (object) [
                            'title' => 'Kelulusan',
                            'path' => '/akademik/kelulusan',
                            'icon' => 'fas fa-graduation-cap',
                        ],
                    ],
                ],
                (object) [
                    'title' => 'Jadwal Pelajaran',
                    'icon' => 'fas fa-calendar-alt',
                    'submenus' => [
                        (object) [
                            'title' => 'Lihat Jadwal',
                            'path' => '/akademik/jadwal',
                            'icon' => 'fas fa-calendar-check',
                        ],
                        (object) [
                            'title' => 'Tambah Jadwal',
                            'path' => '/akademik/jadwal/tambah',
                            'icon' => 'fas fa-plus-square',
                        ],
                    ],
                ],
                (object) [
                    'title' => 'Mata Pelajaran',
                    'icon' => 'fas fa-book-open',
                    'submenus' => [
                        (object) [
                            'title' => 'Daftar Mata Pelajaran',
                            'path' => '/akademik/mapel',
                            'icon' => 'fas fa-list',
                        ],
                        (object) [
                            'title' => 'Tambah Mata Pelajaran',
                            'path' => '/akademik/mapel/tambah',
                            'icon' => 'fas fa-plus-circle',
                        ],
                    ],
                ],
                (object) [
                    'title' => 'Penilaian Siswa',
                    'icon' => 'fas fa-file-alt',
                    'submenus' => [
                        (object) [
                            'title' => 'Input Nilai',
                            'path' => '/akademik/nilai/input',
                            'icon' => 'fas fa-pencil-alt',
                        ],
                        (object) ['title' => 'Lihat Nilai', 'path' => '/akademik/nilai', 'icon' => 'fas fa-chart-line'],
                    ],
                ],
                (object) [
                    'title' => 'Kurikulum',
                    'icon' => 'fas fa-book-reader',
                    'submenus' => [
                        (object) [
                            'title' => 'Struktur Kurikulum',
                            'path' => '/akademik/kurikulum',
                            'icon' => 'fas fa-sitemap',
                        ],
                        (object) [
                            'title' => 'Manajemen Kurikulum',
                            'path' => '/akademik/kurikulum/manajemen',
                            'icon' => 'fas fa-tasks',
                        ],
                    ],
                ],
            ],
        ],

        (object) [
            'title' => 'Sarana & Prasarana',
            'icon' => 'fas fa-building',
            'submenus' => [
                (object) [
                    'title' => 'Data Fasilitas',
                    'icon' => 'fas fa-school',
                    'submenus' => [
                        (object) ['title' => 'Semua Fasilitas', 'path' => '/sarana/fasilitas', 'icon' => 'fas fa-list'],
                        (object) [
                            'title' => 'Tambah Fasilitas',
                            'path' => '/sarana/fasilitas/tambah',
                            'icon' => 'fas fa-plus-circle',
                        ],
                        (object) [
                            'title' => 'Kategori Fasilitas',
                            'path' => '/sarana/fasilitas/kategori',
                            'icon' => 'fas fa-tags',
                        ],
                    ],
                ],
                (object) [
                    'title' => 'Peminjaman Fasilitas',
                    'icon' => 'fas fa-hand-holding',
                    'submenus' => [
                        (object) [
                            'title' => 'Daftar Peminjaman',
                            'path' => '/sarana/peminjaman',
                            'icon' => 'fas fa-clipboard-list',
                        ],
                        (object) [
                            'title' => 'Ajukan Peminjaman',
                            'path' => '/sarana/peminjaman/ajukan',
                            'icon' => 'fas fa-plus-square',
                        ],
                        (object) [
                            'title' => 'Riwayat Peminjaman',
                            'path' => '/sarana/peminjaman/riwayat',
                            'icon' => 'fas fa-history',
                        ],
                    ],
                ],
                (object) [
                    'title' => 'Perawatan Fasilitas',
                    'icon' => 'fas fa-hand-holding',
                    'submenus' => [
                        (object) [
                            'title' => 'Jadwal Perawatan',
                            'path' => '/sarana/perawatan',
                            'icon' => 'fas fa-calendar-check',
                        ],
                        (object) [
                            'title' => 'Tambah Jadwal',
                            'path' => '/sarana/perawatan/tambah',
                            'icon' => 'fas fa-plus-circle',
                        ],
                        (object) [
                            'title' => 'Riwayat Perawatan',
                            'path' => '/sarana/perawatan/riwayat',
                            'icon' => 'fas fa-history',
                        ],
                    ],
                ],
            ],
        ],

        (object) [
            'title' => 'Monitoring Alumni',
            'icon' => 'fas fa-user-friends',
            'submenus' => [
                (object) [
                    'title' => 'Data Alumni',
                    'icon' => 'fas fa-users',
                    'submenus' => [
                        (object) ['title' => 'Semua Alumni', 'path' => '/alumni/data', 'icon' => 'fas fa-list'],
                        (object) [
                            'title' => 'Tambah Alumni',
                            'path' => '/alumni/data/tambah',
                            'icon' => 'fas fa-user-plus',
                        ],
                        (object) [
                            'title' => 'Kategori Alumni',
                            'path' => '/alumni/data/kategori',
                            'icon' => 'fas fa-tags',
                        ],
                    ],
                ],
                (object) [
                    'title' => 'Tracer Study',
                    'icon' => 'fas fa-search',
                    'submenus' => [
                        (object) ['title' => 'Hasil Tracer Study', 'path' => '/alumni/tracer', 'icon' => 'fas fa-poll'],
                        (object) [
                            'title' => 'Tambah Survey',
                            'path' => '/alumni/tracer/tambah',
                            'icon' => 'fas fa-plus-square',
                        ],
                        (object) [
                            'title' => 'Riwayat Survey',
                            'path' => '/alumni/tracer/riwayat',
                            'icon' => 'fas fa-history',
                        ],
                    ],
                ],
                (object) [
                    'title' => 'Kegiatan Alumni',
                    'icon' => 'fas fa-calendar-check',
                    'submenus' => [
                        (object) [
                            'title' => 'Daftar Kegiatan',
                            'path' => '/alumni/kegiatan',
                            'icon' => 'fas fa-calendar',
                        ],
                        (object) [
                            'title' => 'Tambah Kegiatan',
                            'path' => '/alumni/kegiatan/tambah',
                            'icon' => 'fas fa-plus-circle',
                        ],
                        (object) [
                            'title' => 'Riwayat Kegiatan',
                            'path' => '/alumni/kegiatan/riwayat',
                            'icon' => 'fas fa-history',
                        ],
                    ],
                ],
            ],
        ],

        (object) [
            'title' => 'E-Learning',
            'icon' => 'fas fa-laptop',
            'submenus' => [
                (object) [
                    'title' => 'Materi Pembelajaran',
                    'icon' => 'fas fa-book',
                    'submenus' => [
                        (object) ['title' => 'Semua Materi', 'path' => '/elearning/materi', 'icon' => 'fas fa-list'],
                        (object) [
                            'title' => 'Tambah Materi',
                            'path' => '/elearning/materi/tambah',
                            'icon' => 'fas fa-plus-circle',
                        ],
                        (object) [
                            'title' => 'Kategori Materi',
                            'path' => '/elearning/materi/kategori',
                            'icon' => 'fas fa-tags',
                        ],
                    ],
                ],
                (object) [
                    'title' => 'Tugas & Ujian Online',
                    'icon' => 'fas fa-pencil-alt',
                    'submenus' => [
                        (object) ['title' => 'Daftar Tugas', 'path' => '/elearning/tugas', 'icon' => 'fas fa-tasks'],
                        (object) [
                            'title' => 'Tambah Tugas',
                            'path' => '/elearning/tugas/tambah',
                            'icon' => 'fas fa-plus-square',
                        ],
                        (object) ['title' => 'Ujian Online', 'path' => '/elearning/ujian', 'icon' => 'fas fa-file-alt'],
                        (object) [
                            'title' => 'Bank Soal',
                            'path' => '/elearning/ujian/bank-soal',
                            'icon' => 'fas fa-database',
                        ],
                    ],
                ],
                (object) [
                    'title' => 'Forum Diskusi',
                    'icon' => 'fas fa-comments',
                    'submenus' => [
                        (object) ['title' => 'Semua Forum', 'path' => '/elearning/forum', 'icon' => 'fas fa-comments'],
                        (object) [
                            'title' => 'Buat Diskusi Baru',
                            'path' => '/elearning/forum/tambah',
                            'icon' => 'fas fa-plus-circle',
                        ],
                        (object) [
                            'title' => 'Forum Kelas',
                            'path' => '/elearning/forum/kelas',
                            'icon' => 'fas fa-chalkboard-teacher',
                        ],
                    ],
                ],
            ],
        ],

        (object) [
            'title' => 'Laporan',
            'icon' => 'fas fa-chart-bar',
            'submenus' => [
                (object) [
                    'title' => 'Laporan Keuangan',
                    'icon' => 'fas fa-file-invoice-dollar',
                    'submenus' => [
                        (object) [
                            'title' => 'Pendapatan',
                            'path' => '/laporan/keuangan/pendapatan',
                            'icon' => 'fas fa-wallet',
                        ],
                        (object) [
                            'title' => 'Pengeluaran',
                            'path' => '/laporan/keuangan/pengeluaran',
                            'icon' => 'fas fa-money-bill-wave',
                        ],
                        (object) [
                            'title' => 'Laba Rugi',
                            'path' => '/laporan/keuangan/laba-rugi',
                            'icon' => 'fas fa-balance-scale',
                        ],
                    ],
                ],
                (object) [
                    'title' => 'Laporan Akademik',
                    'icon' => 'fas fa-file-signature',
                    'submenus' => [
                        (object) [
                            'title' => 'Nilai Siswa',
                            'path' => '/laporan/akademik/nilai',
                            'icon' => 'fas fa-graduation-cap',
                        ],
                        (object) [
                            'title' => 'Kehadiran',
                            'path' => '/laporan/akademik/kehadiran',
                            'icon' => 'fas fa-user-check',
                        ],
                        (object) [
                            'title' => 'Rekapitulasi',
                            'path' => '/laporan/akademik/rekap',
                            'icon' => 'fas fa-list-alt',
                        ],
                    ],
                ],
                (object) [
                    'title' => 'Laporan Inventaris',
                    'icon' => 'fas fa-clipboard-list',
                    'submenus' => [
                        (object) [
                            'title' => 'Aset Sekolah',
                            'path' => '/laporan/inventaris/aset',
                            'icon' => 'fas fa-boxes',
                        ],
                        (object) [
                            'title' => 'Barang Masuk',
                            'path' => '/laporan/inventaris/masuk',
                            'icon' => 'fas fa-truck-loading',
                        ],
                        (object) [
                            'title' => 'Barang Keluar',
                            'path' => '/laporan/inventaris/keluar',
                            'icon' => 'fas fa-dolly',
                        ],
                    ],
                ],
                (object) [
                    'title' => 'Laporan Absensi',
                    'icon' => 'fas fa-calendar-check',
                    'submenus' => [
                        (object) [
                            'title' => 'Guru & Staff',
                            'path' => '/laporan/absensi/guru',
                            'icon' => 'fas fa-chalkboard-teacher',
                        ],
                        (object) [
                            'title' => 'Siswa',
                            'path' => '/laporan/absensi/siswa',
                            'icon' => 'fas fa-user-graduate',
                        ],
                        (object) [
                            'title' => 'Rekap Bulanan',
                            'path' => '/laporan/absensi/bulanan',
                            'icon' => 'fas fa-calendar-alt',
                        ],
                    ],
                ],
            ],
        ],
        (object) [
            'title' => 'Master Data',
            'icon' => 'fas fa-cogs',
            'submenus' => [
                (object) [
                    'title' => 'Keuangan',
                    'icon' => 'fas fa-database',
                    'submenus' => [
                        // 🔥 Sub-submenu
                        (object) [
                            'title' => 'Chat Of Account',
                            'path' => '/coa',
                            'icon' => 'fas fa-user-plus',
                        ],
                        (object) [
                            'title' => 'Kota',
                            'path' => '/pengaturan/pengguna/list',
                            'icon' => 'fas fa-list',
                        ],
                    ],
                ],
                (object) [
                    'title' => 'Sekolah',
                    'icon' => 'fas fa-users',
                    'submenus' => [
                        // 🔥 Sub-submenu
                        (object) [
                            'title' => 'Judul Buku',
                            'path' => '/pengaturan/pengguna/tambah',
                            'icon' => 'fas fa-user-plus',
                        ],
                        (object) [
                            'title' => 'Peralatan Sekolah',
                            'path' => '/pengaturan/pengguna/list',
                            'icon' => 'fas fa-list',
                        ],
                    ],
                ],
                (object) [
                    'title' => 'Akademik',
                    'icon' => 'fas fa-user-shield',
                    'submenus' => [
                        // 🔥 Sub-submenu
                        (object) [
                            'title' => 'Kelola Role',
                            'path' => '/pengaturan/role/kelola',
                            'icon' => 'fas fa-tasks',
                        ],
                        (object) [
                            'title' => 'Set Hak Akses',
                            'path' => '/pengaturan/role/hak-akses',
                            'icon' => 'fas fa-lock',
                        ],
                    ],
                ],
            ],
        ],
        (object) [
            'title' => 'Pengaturan',
            'icon' => 'fas fa-cogs',
            'submenus' => [
                (object) [
                    'title' => 'Profil Sekolah',
                    'icon' => 'fas fa-school',
                    'submenus' => [
                        // 🔥 Sub-submenu
                        (object) [
                            'title' => 'SMP',
                            'path' => '/pengaturan/pengguna/tambah',
                            'icon' => 'fas fa-user-plus',
                        ],
                        (object) [
                            'title' => 'SMK',
                            'path' => '/pengaturan/pengguna/list',
                            'icon' => 'fas fa-list',
                        ],
                    ],
                ],
                (object) [
                    'title' => 'Manajemen Pengguna',
                    'icon' => 'fas fa-users',
                    'submenus' => [
                        // 🔥 Sub-submenu
                        (object) [
                            'title' => 'Tambah Pengguna',
                            'path' => '/pengaturan/pengguna/tambah',
                            'icon' => 'fas fa-user-plus',
                        ],
                        (object) [
                            'title' => 'List Pengguna',
                            'path' => '/pengaturan/pengguna/list',
                            'icon' => 'fas fa-list',
                        ],
                    ],
                ],
                (object) [
                    'title' => 'Hak Akses & Role',
                    'icon' => 'fas fa-user-shield',
                    'submenus' => [
                        // 🔥 Sub-submenu
                        (object) [
                            'title' => 'Kelola Role',
                            'path' => '/pengaturan/role/kelola',
                            'icon' => 'fas fa-tasks',
                        ],
                        (object) [
                            'title' => 'Set Hak Akses',
                            'path' => '/pengaturan/role/hak-akses',
                            'icon' => 'fas fa-lock',
                        ],
                    ],
                ],
            ],
        ],
    ];
@endphp

<div class="sidebar" data-background-color="dark">
    <x-components.layouts.logo />
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item">
                    <a href="/">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                        <span class="badge badge-secondary">1</span>
                    </a>
                </li>

                @foreach ($menus as $menu)
                    @php
                        $menuActive =
                            isset($menu->submenus) &&
                            isActiveMenu(array_map(fn($sub) => $sub->path ?? '', $menu->submenus));
                    @endphp
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">{{ $menu->title }}</h4>
                    </li>

                    @if (isset($menu->submenus))
                        @foreach ($menu->submenus as $submenu)
                            @php
                                $submenuActive =
                                    isset($submenu->submenus) &&
                                    isActiveMenu(array_map(fn($subsub) => $subsub->path ?? '', $submenu->submenus));
                            @endphp
                            <li class="nav-item {{ $submenuActive ? 'active' : '' }}">
                                <a data-bs-toggle="collapse" href="#{{ Str::slug($submenu->title) }}"
                                    class="{{ $submenuActive ? '' : 'collapsed' }}"
                                    aria-expanded="{{ $submenuActive ? 'true' : 'false' }}">
                                    <i class="{{ $submenu->icon }}"></i>
                                    <p>{{ $submenu->title }}</p>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse {{ $submenuActive ? 'show' : '' }}"
                                    id="{{ Str::slug($submenu->title) }}">
                                    <ul class="nav nav-collapse">
                                        @if (isset($submenu->submenus))
                                            @foreach ($submenu->submenus as $subsubmenu)
                                                <li
                                                    class="{{ Request::is(trim($subsubmenu->path, '/') . '*') ? 'active' : '' }}">
                                                    <a href="{{ url($subsubmenu->path) }}">
                                                        <i class="{{ $subsubmenu->icon }}"></i>
                                                        <span class="sub-item">{{ $subsubmenu->title }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        @endforeach
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
