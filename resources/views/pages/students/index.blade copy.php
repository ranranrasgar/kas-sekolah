@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('students.create') }}" class="btn btn-primary">Tambah Siswa</a>
                    <form method="GET" action="{{ route('students.index') }}" class="d-flex gap-2">
                        <input type="date" name="start_date" class="form-control form-control-sm"
                            placeholder="Tanggal Mulai" value="{{ request('start_date') }}">
                        <input type="date" name="end_date" class="form-control form-control-sm"
                            placeholder="Tanggal Akhir" value="{{ request('end_date') }}">
                        <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                        <a href="{{ route('students.index') }}" class="btn btn-sm btn-secondary">Reset</a>
                    </form>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table id="student-table" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NISN</th>
                                    <th>Major</th>
                                    <th>Class</th>
                                    <th>Agama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NISN</th>
                                    <th>Major</th>
                                    <th>Class</th>
                                    <th>Agama</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->nisn }}</td>
                                        <td>{{ $student->major->major_name ?? '??' }}</td>
                                        <td>{{ $student->class->class_name }}</td>
                                        <td>{{ $student->agama->name }}</td>
                                        <td>
                                            <a href="{{ route('students.edit', $student->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
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
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#student-table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });
    </script>
@endpush
