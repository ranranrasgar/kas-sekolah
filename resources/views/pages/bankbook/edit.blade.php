@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="fw-bold mb-3">Edit - {{ optional($journal->journalCategory->coa)->name }}</h4>
                </div>
                <div class="card-body">
                    <x-validations-errors />
                    {{-- @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}
            </div>
            @endif
            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif --}}

                    <form action="{{ route('bankbook.update', $journal->id) }}" method="POST"
                        onsubmit="removeCurrencyFormatBeforeSubmit() ">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="date" class="form-control"
                                    value="{{ old('date', $journal->date) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Kategori</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ old('category_id', $category->id) }}"
                                            {{ $category->id == $journal->category_id ? 'selected' : '' }}>
                                            {{ $category->name }} - ({{ $category->coa->code }} :
                                            {{ $category->coa->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Referensi</label>
                                <input type="text" name="reference" class="form-control"
                                    value="{{ old('reference', $journal->reference) }}" placeholder="Masukkan Referensi">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Deskripsi</label>
                                <input type="text" name="description" class="form-control"
                                    value="{{ old('description', $journal->description) }}" placeholder="Deskripsi Jurnal">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Mata Uang</label>
                                <select name="currency_id" class="form-select" required>
                                    <option value="">Pilih Mata Uang</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ old('currency_id', $currency->id) }}"
                                            {{ $currency->id == $journal->currency_id ? 'selected' : '' }}>
                                            {{ $currency->code }} - {{ $currency->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <h5 class="mt-4">Rincian Pencatatan Dana</h5>
                        <table class="table table-bordered" id="journal-entries">
                            <thead>
                                <tr>
                                    <th>Jenis Kas</th>
                                    <th>Pemasukan</th>
                                    <th>Pengeluaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($journal->journalEntries as $index => $entry) --}}
                                @foreach ($journal->journalEntries->where('coa_id', '!=', $journal->journalCategory->coa_id) as $index => $entry)
                                    <tr>
                                        <td>
                                            <select name="journal_entries[{{ $index }}][coa_id]"
                                                class="form-select">
                                                <option value="">Pilih Akun COA</option>
                                                @foreach ($coas ?? [] as $coa)
                                                    <option value="{{ $coa->id }}"
                                                        {{ old('journal_entries.' . $index . '.coa_id', $entry->coa_id) == $coa->id ? 'selected' : '' }}>
                                                        {{ $coa->code }} - {{ $coa->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </td>

                                        <td>
                                            <input type="text" name="journal_entries[{{ $index }}][credit]"
                                                class="form-control text-end currency-input"
                                                value="{{ old('journal_entries.' . $index . '.credit', number_format($entry->credit, 0, ',', '.')) }}">
                                        </td>
                                        <td>
                                            <input type="text" name="journal_entries[{{ $index }}][debit]"
                                                class="form-control text-end currency-input"
                                                value="{{ old('journal_entries.' . $index . '.debit', number_format($entry->debit, 0, ',', '.')) }}">

                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th class="text-end" id="total-credit">0</th>
                                    <th class="text-end" id="total-debit">0</th>

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
                                    <option value="{{ $coa->id }}">{{ $coa->code }} - {{ $coa->name }}</option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <input type="text" name="journal_entries[${rowCount}][credit]" class="form-control text-end currency-input" value="0">
                        </td>
                        <td>
                            <input type="text" name="journal_entries[${rowCount}][debit]" class="form-control text-end currency-input" value="0">
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
