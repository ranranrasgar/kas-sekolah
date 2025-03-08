@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                {{-- Tambah Data Journal --}}
                <div class="card-header">
                    <div class="row align-items-center">
                        <!-- Judul -->
                        <div class="col-12 col-md-auto mb-2 mb-md-0">
                            <h4 class="card-title m-0">
                                {{ session('activeSubSubmenu') }}
                            </h4>
                        </div>
                        <!-- Filter & Tombol -->
                        <div class="col-12 col-md d-flex flex-wrap flex-md-nowrap justify-content-md-end gap-2">
                            <!-- Form Filter -->
                            <form method="GET" action="{{ route('bankbook.index') }}" class="d-flex flex-wrap gap-2">
                                {{-- <input type="hidden" name="category_id" value="{{ request('category_id') }}"> --}}
                                <!-- Menyimpan category_id -->
                                <div>
                                    <label for="category_id" class="form-label m-0"><small>Bank Book</small></label>
                                    <select name="category_id" id="category_id" class="form-control form-control-sm">
                                        <option value="">-- Pilih Jenis Bankbook --</option>
                                        @foreach ($categories as $type)
                                            <option value="{{ $type->id }}"
                                                {{ request('category_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="start_date" class="form-label m-0"><small>Tanggal Mulai</small></label>
                                    <input type="date" name="start_date" id="start_date"
                                        class="form-control form-control-sm" value="{{ request('start_date') }}">


                                </div>
                                <div>
                                    <label for="end_date" class="form-label m-0"><small>Tanggal Akhir</small></label>
                                    <input type="date" name="end_date" id="end_date"
                                        class="form-control form-control-sm" value="{{ request('end_date') }}">

                                </div>
                                <div class="d-flex align-items-end gap-2">
                                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                    <a href="{{ route('bankbook.index') }}" class="btn btn-sm btn-secondary">Reset</a>
                                </div>
                            </form>
                            <!-- Tombol Tambah Transaksi harus sejajar -->
                            <a href="{{ route('bankbook.create', ['category' => request('category_id', 1)]) }}"
                                class="btn btn-sm btn-primary align-self-end">
                                <i class="fa fa-plus"></i> Transaksi
                            </a>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    {{-- <x-validations-errors /> --}}
                    {{-- <script>
                        var showNotification = @json(session('show_notification', true));
                        var notificationTitle = @json(session('notification_title', 'Selamat Datang di Aplikasi SIMDIK Al-Hawari'));
                        var notificationMessage = @json(session('notification_message', 'Hi! Selamat bekerja..'));
                    </script> --}}
                    @if (session('success'))
                        <x-notification :show="true" title="Info Database" message="Data berhasil di simpan!" />
                    @endif

                    <div class="table-responsive">
                        <table id="add-row" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>No.Reff</th>
                                    <th>Keterangan</th>
                                    <th>Debit (Rp)</th>
                                    <th>Kredit (Rp)</th>
                                    <th>Saldo (Rp)</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>No.Reff</th>
                                    <th>Keterangan</th>
                                    <th>Debit (Rp)</th>
                                    <th>Kredit (Rp)</th>
                                    <th>Saldo (Rp)</th>

                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($journals as $journal)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ \Carbon\Carbon::parse($journal->date)->format('d/m/Y') }}</td>
                                        <td>{{ $journal->reference }}</td>
                                        <td>{{ $journal->description }}</td>

                                        <td class="text-end">{{ number_format($journal->debit, 2, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($journal->credit, 2, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($journal->saldo_rekening, 2, ',', '.') }}
                                        </td>

                                        <td>
                                            <!-- Tombol Edit dan Hapus dalam satu baris -->
                                            <div class="d-flex">
                                                <!-- Tombol Edit -->
                                                <a href="{{ route('bankbook.edit', $journal->id) }}"
                                                    class="btn btn-link btn-primary btn-sm me-2" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <!-- Tombol Hapus -->

                                                <form id="deleteForm-{{ $journal->id }}"
                                                    action="{{ route('bankbook.destroy', $journal->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-link btn-danger btn-sm delete-btn"
                                                        data-id="{{ $journal->id }}" title="Hapus">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <!-- Kaiadmin JS -->
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="{{ asset('assets/js/setting-demo2.js') }}"></script>

    {{-- Alart Delete --}}
    <script>
        $(document).on("click", ".delete-btn", function(e) {
            e.preventDefault();
            let formId = $(this).data("id"); // Ambil ID form dari tombol
            let form = $("#deleteForm-" + formId);

            swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Cancel",
                        visible: true,
                        className: "btn btn-danger",
                    },
                    confirm: {
                        text: "Yes, delete it!",
                        className: "btn btn-success",
                    },
                },
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit(); // Submit form jika user konfirmasi
                } else {
                    swal.close();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            function applyMultiFilterSelect(tableId) {
                var table = $(tableId).DataTable({
                    pageLength: 10,
                    initComplete: function() {
                        var api = this.api();
                        api.columns().every(function(index) {
                            if (index === api.columns().count() - 1) {
                                return; // Lewati kolom terakhir (action)
                            }

                            var column = this;
                            var footer = $(column.footer());

                            if (!footer.length) {
                                return; // Pastikan ada elemen footer
                            }

                            // Hindari duplikasi dropdown filter
                            footer.empty();
                            var select = $(
                                    '<select class="form-select"><option value="">All</option></select>'
                                )
                                .appendTo(footer)
                                .on("change", function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this)
                                        .val());
                                    column.search(val ? "^" + val + "$" : "", true, false)
                                        .draw();
                                });

                            column.data().unique().sort().each(function(d) {
                                select.append('<option value="' + d + '">' + d +
                                    "</option>");
                            });
                        });
                    }
                });

                return table;
            }

            // Inisialisasi DataTable untuk kedua tabel
            var table1 = applyMultiFilterSelect("#multi-filter-select");
            var table2 = applyMultiFilterSelect("#add-row");

            var action =
                '<td><div class="form-button-action">' +
                '<button type="button" class="btn btn-link btn-primary btn-lg edit-btn" title="Edit"><i class="fa fa-edit"></i></button>' +
                '<button type="button" class="btn btn-link btn-danger remove-btn" title="Remove"><i class="fa fa-times"></i></button>' +
                '</div></td>';

            // Fungsi untuk menambahkan data ke tabel kedua
            $("#addRowButton").click(function() {
                var name = $("#addName").val().trim();
                var position = $("#addPosition").val().trim();
                var office = $("#addOffice").val().trim();

                if (name && position && office) {
                    // Menambahkan baris baru ke tabel dengan DataTables API
                    table2.row.add([name, position, office, action]).draw(false);

                    // Mengosongkan input setelah menambahkan baris
                    $("#addName, #addPosition, #addOffice").val("");

                    // Menutup modal setelah input
                    $("#addRowModal").modal("hide");
                } else {
                    alert("Harap isi semua bidang sebelum menambahkan!");
                }
            });

            // Menghapus baris saat tombol "Remove" diklik
            $("#add-row tbody").on("click", ".remove-btn", function() {
                table2.row($(this).closest("tr")).remove().draw(false);
            });

        });
    </script>
@endsection
