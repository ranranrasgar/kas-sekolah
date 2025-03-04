@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="fw-bold mb-3">Tambah Jurnal - {{ optional($categoryJournals)->name }}</h4>
                </div>
                <div class="card-body">

                    <x-validations-errors />

                    <form action="{{ route('journals.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="date" class="form-control"
                                    value="{{ old('date', today()->format('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Kategori</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', request('category_id', optional($categoryJournals)->id)) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-4">
                                <label class="form-label">No Referensi</label>
                                <input type="text" name="reference" class="form-control"
                                    value="{{ old('reference', $referenceNo) }}" readonly required>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Deskripsi</label>
                                <input type="text" name="description" class="form-control"
                                    value="{{ old('description') }}" placeholder="Deskripsi Jurnal">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Mata Uang</label>
                                <select name="currency_id" class="form-select" required>
                                    <option value="">Pilih Mata Uang</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}"
                                            {{ old('currency_id', request('currency_id', 1)) == $currency->id ? 'selected' : '' }}>
                                            {{ $currency->code }} - {{ $currency->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <h5 class="mt-4">Detail Jurnal</h5>
                        <table class="table table-bordered" id="journal-entries">
                            <thead>
                                <tr>
                                    <th>Akun COA</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $oldEntries = old('journal_entries', []);
                                @endphp

                                @if (count($oldEntries) > 0)
                                    @foreach ($oldEntries as $index => $entry)
                                        <tr>
                                            <td>
                                                <select name="journal_entries[{{ $index }}][coa_id]"
                                                    class="form-select">
                                                    <option value="">Pilih Akun COA</option>
                                                    @foreach ($coas as $coa)
                                                        <option value="{{ $coa->id }}"
                                                            {{ $coa->id == old('journal_entries.' . $index . '.coa_id') ? 'selected' : '' }}>
                                                            {{-- {{ $coa->code }} - {{ $coa->name }} --}}
                                                            {{ $coa->name }} - {{ $coa->code }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="journal_entries[{{ $index }}][debit]"
                                                    class="form-control text-end currency-input"
                                                    value="{{ old('journal_entries.' . $index . '.debit', '0') }}">
                                            </td>
                                            <td>
                                                <input type="text" name="journal_entries[{{ $index }}][credit]"
                                                    class="form-control text-end currency-input"
                                                    value="{{ old('journal_entries.' . $index . '.credit', '0') }}">
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm remove-row">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>
                                            <select name="journal_entries[0][coa_id]" class="form-select">
                                                <option value="">Pilih Akun COA</option>
                                                @foreach ($coas as $coa)
                                                    <option value="{{ $coa->id }}">{{ $coa->name }} -
                                                        {{ $coa->code }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="journal_entries[0][debit]"
                                                class="form-control text-end currency-input" value="0">
                                        </td>
                                        <td>
                                            <input type="text" name="journal_entries[0][credit]"
                                                class="form-control text-end currency-input" value="0">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th class="text-end" id="total-debit">0</th>
                                    <th class="text-end" id="total-credit">0</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>

                        <button type="button" class="btn btn-success btn-sm" id="add-entry">Tambah Baris</button>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Simpan Jurnal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk format angka ke format mata uang
            function formatCurrency(value) {
                return new Intl.NumberFormat('id-ID').format(value);
            }
            // Fungsi untuk memformat semua input yang memiliki class 'currency-input'
            function formatCurrencyOnLoad() {
                document.querySelectorAll('.currency-input').forEach(input => {
                    let numericValue = parseCurrency(input.value); // Mengonversi ke angka murni
                    input.value = formatCurrency(numericValue); // Memformat ke mata uang
                });
            }

            // Fungsi untuk menghapus pemisah ribuan dan mengonversi ke angka
            function parseCurrency(value) {
                // Menghapus titik (sebagai pemisah ribuan) dan mengganti koma (jika ada) dengan titik
                return parseFloat(value.replace(/\./g, '').replace(',', '.')) || 0;
            }

            // Fungsi untuk menghapus format mata uang sebelum submit
            function removeCurrencyFormatBeforeSubmit() {
                document.querySelectorAll('.currency-input').forEach(input => {
                    let rawValue = parseCurrency(input.value); // Ubah input ke angka murni
                    input.value = rawValue; // Simpan angka murni kembali ke dalam input
                });
            }


            // Format currency saat halaman pertama kali dimuat
            formatCurrencyOnLoad();

            // Mengirimkan form dan mengonversi input
            // document.querySelector('form').addEventListener('submit', function(event) {
            //     removeCurrencyFormatBeforeSubmit(); // Menghapus format mata uang sebelum submit
            // });

            // Fungsi untuk menghitung total debit dan kredit
            function calculateTotals() {
                let totalDebit = 0;
                let totalCredit = 0;

                // Menghitung total debit
                document.querySelectorAll('input[name^="journal_entries"][name$="[debit]"]').forEach(input => {
                    totalDebit += parseCurrency(input.value);
                });

                // Menghitung total kredit
                document.querySelectorAll('input[name^="journal_entries"][name$="[credit]"]').forEach(input => {
                    totalCredit += parseCurrency(input.value);
                });

                // Menampilkan total debit dan kredit
                let totalDebitElem = document.getElementById('total-debit');
                let totalCreditElem = document.getElementById('total-credit');

                totalDebitElem.textContent = formatCurrency(totalDebit);
                totalCreditElem.textContent = formatCurrency(totalCredit);

                // Menentukan warna jika total debit dan kredit tidak sama
                let color = (totalDebit !== totalCredit) ? 'red' : 'black';
                totalDebitElem.style.color = color;
                totalCreditElem.style.color = color;
            }

            // Fungsi untuk menambahkan event listeners ke elemen
            function addEventListeners() {
                document.querySelectorAll('.currency-input').forEach(input => {
                    input.removeEventListener('input', handleInput);
                    input.removeEventListener('blur', handleBlur);
                    input.removeEventListener('focus', handleFocus);

                    input.addEventListener('input', handleInput);
                    input.addEventListener('blur', handleBlur);
                    input.addEventListener('focus', handleFocus);
                });

                document.querySelectorAll('.remove-row').forEach(button => {
                    button.removeEventListener('click', handleRemove);
                    button.addEventListener('click', handleRemove);
                });
            }

            // Fungsi untuk menangani input pada field
            function handleInput(event) {
                let rawValue = parseCurrency(event.target.value);
                event.target.value = rawValue ? formatCurrency(rawValue) : ''; // Menampilkan format yang benar
                calculateTotals();
            }

            // Fungsi untuk menangani blur (ketika field kehilangan fokus)
            function handleBlur(event) {
                let numericValue = parseCurrency(event.target.value);
                event.target.value = formatCurrency(
                    numericValue); // Format ke dalam format yang benar (misal: 20.000)
                calculateTotals();
            }

            // Fungsi untuk menangani fokus (untuk menghapus format saat fokus)
            function handleFocus(event) {
                event.target.value = parseCurrency(event.target.value); // Menghapus format angka saat fokus
            }

            // Fungsi untuk menghapus baris tabel
            function handleRemove(event) {
                event.target.closest('tr').remove();
                calculateTotals();
            }

            // Menambahkan baris baru di tabel
            document.getElementById('add-entry').addEventListener('click', function() {
                let tableBody = document.querySelector('#journal-entries tbody');
                let rowCount = tableBody.rows.length;
                let newRow = `
                    <tr>
                        <td>
                            <select name="journal_entries[${rowCount}][coa_id]" class="form-select">
                                <option value="">Pilih Akun COA</option>
                                @foreach ($coas ?? [] as $coa)
                                    <option value="{{ $coa->id }}">{{ $coa->name }} - {{ $coa->code }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="journal_entries[${rowCount}][debit]" class="form-control text-end currency-input" value="0">
                        </td>
                        <td>
                            <input type="text" name="journal_entries[${rowCount}][credit]" class="form-control text-end currency-input" value="0">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
                        </td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', newRow);
                addEventListeners();
            });

            // Menambahkan event listener untuk input yang ada
            addEventListeners();
            calculateTotals();
        });
    </script>
@endsection
