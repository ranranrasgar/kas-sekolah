@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="fw-bold mb-3">Tambah Data - COA</h4>
                </div>
                <div class="card-body">

                    <x-validations-errors />

                    <form action="{{ route('coa.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Tipe COA</label>
                                <select name="coa_type_id" class="form-select" required>
                                    <option value="">Pilih Tipe COA</option>
                                    @foreach ($coaTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ old('coa_type_id', $defaultCoaType) == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Kode COA</label>
                                <input type="text" name="code" class="form-control" value="{{ old('code') }}"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Nama COA</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                    required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Simpan COA</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const coaTypeSelect = document.querySelector('select[name="coa_type_id"]');
            const codeInput = document.querySelector('input[name="code"]');

            // Awalan kode berdasarkan tipe COA
            const coaTypePrefixes = {
                1: '10',
                2: '20',
                3: '30',
                4: '40',
                5: '50'
            };

            // Fungsi untuk mengambil kode COA dari database
            function fetchExistingCodes(coaTypeId) {
                return fetch(`/coa/codes/${coaTypeId}`)
                    .then(response => response.json())
                    .catch(error => {
                        console.error("Error fetching COA codes:", error);
                        return [];
                    });
            }

            // Fungsi untuk menghasilkan kode COA baru
            async function generateCode(coaTypeId) {
                const prefix = coaTypePrefixes[coaTypeId];
                if (!prefix) return '';

                // Ambil data dari database
                const existingCodes = await fetchExistingCodes(coaTypeId);

                // Filter kode yang sesuai dengan prefix dan urutkan secara numerik
                const filteredCodes = existingCodes
                    .filter(code => code.startsWith(prefix))
                    .map(code => parseInt(code, 10)) // Pastikan kode diubah ke angka
                    .sort((a, b) => a - b); // Urutkan secara ascending

                // Cari kode terakhir
                let lastCode = filteredCodes.length > 0 ? filteredCodes[filteredCodes.length - 1] : null;

                if (lastCode !== null) {
                    // Tambah 1 ke kode terakhir
                    return (lastCode + 1).toString();
                } else {
                    // Jika belum ada kode, mulai dari `prefix + 01`
                    return `${prefix}1`;
                }
            }
            // Event listener untuk perubahan coa_type_id
            coaTypeSelect.addEventListener('change', async function() {
                const selectedCoaTypeId = coaTypeSelect.value;

                if (selectedCoaTypeId) {
                    const newCode = await generateCode(selectedCoaTypeId);
                    codeInput.value = newCode;
                } else {
                    codeInput.value = '';
                }
            });
        });
    </script>
@endsection
