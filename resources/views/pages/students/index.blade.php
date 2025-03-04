@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <!-- Judul -->
                        <div class="col-12 col-md-auto mb-2 mb-md-0">
                            <h4 class="card-title m-0">
                                {{ session('activeSubSubmenu') }}
                            </h4>
                        </div>
                        <div class="col-12 col-md d-flex flex-wrap flex-md-nowrap justify-content-md-end gap-2">
                            <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-plus"></i> Siswa Baru
                            </a>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                                <i class="fa fa-filter"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
                {{-- Modal Filter Data --}}
                <!-- Modal Filter -->
                <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="filterModalLabel">Filter Siswa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form action="{{ route('students.index') }}" method="GET">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="class" class="form-label">Kelas</label>
                                        <select class="form-select" name="class_id">
                                            <option value="">-- Pilih Kelas --</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="major" class="form-label">Jurusan</label>
                                        <select class="form-select" name="major_id">
                                            <option value="">-- Pilih Jurusan --</option>
                                            @foreach ($majors as $major)
                                                <option value="{{ $major->id }}">{{ $major->major_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" name="gender">
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table id="add-row" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>L/P</th>
                                    <th>Major</th>
                                    <th>Class</th>
                                    <th>Agama</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>L/P</th>
                                    <th>Major</th>
                                    <th>Class</th>
                                    <th>Agama</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td class="d-flex justify-content-between align-items-center">
                                            <span>{{ $loop->iteration }}</span>
                                            <img src="{{ $student->student_photo ? asset('storage/' . $student->student_photo) : asset('storage/students/no_image.jpg') }}"
                                                alt="Photo" class="rounded-circle zoom-img shadow-lg img-hover"
                                                width="40" height="40">
                                        </td>
                                        <td>{{ $student->nisn }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>
                                            @if ($student->gender === 'L')
                                                <i class="fa fa-user text-primary" title="Laki-laki"></i>
                                            @else
                                                <i class="fa fa-user text-danger" title="Perempuan"></i>
                                            @endif
                                        </td>
                                        <td>{{ $student->major->major_name ?? '??' }}</td>
                                        <td>{{ $student->class->class_name }}</td>
                                        <td>{{ $student->agama->name }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('students.edit', $student->id) }}"
                                                    class="btn btn-link btn-primary btn-sm me-2" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form id="deleteForm-{{ $student->id }}"
                                                    action="{{ route('students.destroy', $student->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-link btn-danger btn-sm delete-btn"
                                                        data-id="{{ $student->id }}" title="Hapus">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".zoom-img").hover(
                function() {
                    $(this).css("transform", "scale(1.5)").css("transition", "0.3s ease-in-out");
                },
                function() {
                    $(this).css("transform", "scale(1)");
                }
            );
        });
    </script>

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
                    pageLength: 5,
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
