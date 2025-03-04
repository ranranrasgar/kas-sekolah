@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="fw-bold mb-3">Form Edit Siswa</h4>
                </div>
                <div class="card-body">
                    <x-validations-errors />
                    <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="nisn" class="form-label">NISN</label>
                                <input type="text" name="nisn" class="form-control"
                                    value="{{ old('nisn', $student->nisn) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $student->name) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $student->email) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="phone" class="form-label">Telepon</label>
                                <input type="text" name="phone" class="form-control"
                                    value="{{ old('phone', $student->phone) }}">
                            </div>
                            <div class="col-md-4">
                                <label for="address" class="form-label">Alamat</label>
                                <input type="text" name="address" class="form-control"
                                    value="{{ old('address', $student->address) }}">
                            </div>
                            <div class="col-md-4">
                                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="birth_date" class="form-control"
                                    value="{{ old('birth_date', $student->birth_date) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="major_id" class="form-label">Jurusan</label>
                                <select name="major_id" class="form-select">
                                    <option value="">Pilih Jurusan</option>
                                    @foreach ($majors as $major)
                                        <option value="{{ $major->id }}"
                                            {{ old('major_id', $student->major_id) == $major->id ? 'selected' : '' }}>
                                            {{ $major->major_name }}
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
                                            {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                            {{ $class->class_name }}
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
                                            {{ old('agama_id', $student->agama_id) == $agama->id ? 'selected' : '' }}>
                                            {{ $agama->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="student_photo" class="form-label">Foto</label>
                                <div class="mb-2">
                                    <img id="previewImage"
                                        src="{{ $student->student_photo ? asset('storage/' . $student->student_photo) : asset('storage/students/no_image.jpg') }}"
                                        alt="Foto Siswa" class="img-thumbnail" width="150">
                                </div>
                                <input type="file" name="student_photo" class="form-control" id="student_photo"
                                    onchange="previewFile()">
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewFile() {
            var preview = document.getElementById('previewImage');
            var file = document.getElementById('student_photo').files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file); // Membaca file dan menampilkan preview
            } else {
                preview.src = "https://via.placeholder.com/150"; // Jika tidak ada gambar, gunakan placeholder
            }
        }
    </script>
@endsection
