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
                            <form method="GET" action="{{ route('coa.index') }}" class="d-flex flex-wrap gap-2">
                                <div>
                                    <label for="coa_type" class="form-label m-0"><small>Type COA</small></label>
                                    <select name="coa_type" id="coa_type" class="form-control form-control-sm">
                                        <option value="">-- Pilih Type COA --</option>
                                        @foreach ($coaTypes as $type)
                                            <option value="{{ $type->id }}"
                                                {{ request('coa_type') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex align-items-end gap-2">
                                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                    <a href="{{ route('coa.index') }}" class="btn btn-sm btn-secondary">Reset</a>
                                </div>
                            </form>


                            <!-- Tombol Tambah Transaksi harus sejajar -->
                            <a href="{{ route('coa.create', ['coa_type' => request('coa_type')]) }}"
                                class="btn btn-sm btn-primary align-self-end">
                                <i class="fa fa-plus"></i> Data
                            </a>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <x-validations-errors />
                    <div class="table-responsive">
                        <table id="add-row" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>

                                    <th>Kode Akun</th>
                                    <th>Nama Akun</th>
                                    <th>Jenis Akun</th>
                                    <th>Keterangan</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style="width: 5%;">No</th>

                                    <th>Kode Akun</th>
                                    <th>Nama Akun</th>
                                    <th>Jenis Akun</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>

                                @foreach ($coas as $coa)
                                    <tr class="{{ is_null($coa->parent_id) ? 'text-danger fw-bold' : '' }}">
                                        <td style="{{ is_null($coa->parent_id) ? 'color: red; font-weight: bold;' : '' }}">
                                            {{ $loop->iteration }}</td>
                                        <td style="{{ is_null($coa->parent_id) ? 'color: red; font-weight: bold;' : '' }}">
                                            {{ $coa->code }}</td>
                                        <td style="{{ is_null($coa->parent_id) ? 'color: red; font-weight: bold;' : '' }}">
                                            @if (!is_null($coa->parent_id))
                                                <i class="fas fa-sign-out-alt text-primary me-1"></i>
                                                <span style="margin-left: 15px;">{{ $coa->name }}</span>
                                            @else
                                                {{ $coa->name }}
                                            @endif
                                        </td>
                                        <td style="{{ is_null($coa->parent_id) ? 'color: red; font-weight: bold;' : '' }}">
                                            {{ $coa->coaType->name ?? 'N/A' }}</td>
                                        <td style="{{ is_null($coa->parent_id) ? 'color: red; font-weight: bold;' : '' }}">
                                            {{ $coa->coaType->description ?? '-' }}</td>

                                        <td>
                                            <!-- Tombol Edit dan Hapus dalam satu baris -->
                                            <div class="d-flex">
                                                <!-- Tombol Edit -->
                                                <a href="{{ route('coa.edit', $coa->id) }}"
                                                    class="btn btn-link btn-primary btn-sm me-2" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <!-- Tombol Hapus -->
                                                <form id="deleteForm-{{ $coa->id }}"
                                                    action="{{ route('coa.destroy', $coa->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-link btn-danger btn-sm delete-btn"
                                                        data-id="{{ $coa->id }}" title="Hapus">
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
        });
    </script>
@endsection
