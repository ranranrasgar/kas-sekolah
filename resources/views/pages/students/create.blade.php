@extends('layouts.main')

@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Tambah Siswa</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home"><a href="#"><i class="icon-home"></i></a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="/admin/students">Siswa</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item">Tambah Data</li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="fw-bold mb-3">Form Tambah Siswa</h4>
                </div>
                <div class="card-body">
                    <x-validations-errors />
                    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="nisn" class="form-label">NISN</label>
                                <input type="text" name="nisn" class="form-control" value="{{ old('nisn') }}"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="phone" class="form-label">Telepon</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="address" class="form-label">Alamat</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="birth_date" class="form-control"
                                    value="{{ old('birth_date') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="major_id" class="form-label">Jurusan</label>
                                <select name="major_id" class="form-select">
                                    <option value="">Pilih Jurusan</option>
                                    @foreach ($majors as $major)
                                        <option value="{{ $major->id }}"
                                            {{ old('major_id') == $major->id ? 'selected' : '' }}>
                                            {{ $major->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="class_id" class="form-label">Kelas</label>
                                <select name="class_id" class="form-select">
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}"
                                            {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="agama_id" class="form-label">Agama</label>
                                <select name="agama_id" class="form-select">
                                    <option value="">Pilih Agama</option>
                                    @foreach ($agamas as $agama)
                                        <option value="{{ $agama->id }}"
                                            {{ old('agama_id') == $agama->id ? 'selected' : '' }}>
                                            {{ $agama->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="student_photo" class="form-label">Foto</label>
                                <input type="file" name="student_photo" class="form-control">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
