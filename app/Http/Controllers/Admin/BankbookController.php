<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\{Currency, JournalCategory, Journal, Coa, JournalEntry};

class BankbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $categoryId = $request->input('category_id', 1); // Default category_id = 11

        // Ambil daftar kategori jurnal untuk dropdown filter
        $categories = JournalCategory::with('coa')->get();

        // Query jurnal dengan saldo sebelumnya & saldo rekening
        $sql = "
             WITH Saldo AS (
                 SELECT
                     j.id,
                     j.reference,
                     j.date,
                     j.description,
                     c.code,
                     c.name,
                     je.debit,
                     je.credit,
                     je.created_at,
                     je.updated_at,
                     -- Saldo Sebelumnya (Total transaksi sebelum tanggal ini)
                     (
                         SELECT SUM(je2.debit - je2.credit)
                         FROM journal_entries je2
                         JOIN journals j2 ON je2.journal_id = j2.id
                         WHERE je2.coa_id = jc.coa_id
                         AND j2.date < j.date
                     ) AS saldo_sebelumnya,
                     -- Saldo Rekening sampai dengan tanggal ini
                     (
                         SELECT SUM(je3.debit - je3.credit)
                         FROM journal_entries je3
                         JOIN journals j3 ON je3.journal_id = j3.id
                         WHERE je3.coa_id = jc.coa_id
                         AND j3.date <= j.date
                     ) AS saldo_rekening
                 FROM journals j
                 INNER JOIN journal_entries je ON je.journal_id = j.id
                 INNER JOIN journal_categories jc ON jc.coa_id = je.coa_id
                 INNER JOIN coas c ON je.coa_id = c.id
                 WHERE jc.id = ?
                 AND (j.date >= ? OR ? IS NULL) -- Filter Start Date
                 AND (j.date <= ? OR ? IS NULL) -- Filter End Date
             )
             SELECT * FROM Saldo
             ORDER BY date, reference;
         ";

        // Masukkan parameter dengan benar
        $journals = DB::select($sql, [$categoryId, $startDate, $startDate, $endDate, $endDate]);

        return view('pages.bankbook.index', compact('journals', 'startDate', 'endDate', 'categoryId', 'categories'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $category)
    {
        $currencies = Currency::all();
        $categories = JournalCategory::all();

        $coas = Coa::whereDoesntHave('children')->get();

        // $coas = Coa::all();

        // $coas = Coa::whereNotIn('code', function ($query) {
        //     $query->select('parent_code')->from('coas')->whereNotNull('parent_code');
        // })->get();

        // Ambil bulan & tahun saat ini
        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('Y');

        // Ambil transaksi terakhir untuk bulan ini
        $lastTransaction = Journal::whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->latest('reference')
            ->first();

        // Tentukan nomor urut berikutnya
        $nextNumber = optional($lastTransaction)->reference
            ? ((int)substr($lastTransaction->reference, -4) + 1)
            : 1;

        $noUrut = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // Buat nomor referensi
        $referenceNo = "TRX-{$bulan}{$tahun}-{$noUrut}";

        // Ambil kategori jurnal
        // $categoryJournals = JournalCategory::find($category);
        $categoryJournals = JournalCategory::where('id', $category)->first();
        if (!$categoryJournals) {
            return redirect()->route('bankbook.index')->with('error', 'Kategori tidak ditemukan.');
        }

        return view('pages.bankbook.create', compact('currencies', 'categories', 'coas', 'categoryJournals', 'referenceNo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Bersihkan pemisah ribuan dari input debit dan credit
        $cleanedEntries = collect($request->journal_entries)->map(function ($entry) {
            $entry['debit'] = str_replace('.', '', $entry['debit'] ?? '0');
            $entry['credit'] = str_replace('.', '', $entry['credit'] ?? '0');
            return $entry;
        })->toArray();

        // Merge kembali ke request
        $request->merge(['journal_entries' => $cleanedEntries]);
        // Validasi input
        $validated = $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|max:255',
            'category_id' => 'required|exists:journal_categories,id',
            'currency_id' => 'required|exists:currencies,id',
            'reference' => 'required|string|unique:journals,reference', // Pastikan unik
            'journal_entries' => 'required|array|min:2', // Minimal harus ada 2 entry (debit & kredit)
            'journal_entries.*.coa_id' => 'required|exists:coas,id',
            'journal_entries.*.debit' => 'nullable|numeric|min:0',
            'journal_entries.*.credit' => 'nullable|numeric|min:0',
        ], [
            'date.required' => 'Tanggal harus di isi.',
            'date.date' => 'Format tanggal tidak valid.',
            'description.required' => 'Deskripsi harus diisi.',
            'category_id.required' => 'Kategori harus dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'currency_id.required' => 'Mata uang harus dipilih.',
            'currency_id.exists' => 'Mata uang tidak valid.',
            'reference.required' => 'Nomor referensi harus diisi.',
            'reference.unique' => 'Nomor referensi sudah digunakan.',
            'journal_entries.required' => 'Minimal harus ada dua entri (debit & kredit).',
            'journal_entries.min' => 'Minimal harus ada dua entri (debit & kredit).',
            'journal_entries.*.coa_id.required' => 'COA harus dipilih.',
            'journal_entries.*.coa_id.exists' => 'COA tidak valid.',
            'journal_entries.*.debit.numeric' => 'Nilai debit harus berupa angka.',
            'journal_entries.*.credit.numeric' => 'Nilai kredit harus berupa angka.',
        ]);

        // try {
        // Simpan ke tabel Journal
        $journal = Journal::create([
            'date' => $validated['date'],
            'reference' => $validated['reference'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'currency_id' => $validated['currency_id'],
            // 'created_by' => auth()->id(),
        ]);

        // Simpan ke tabel JournalEntry
        foreach ($validated['journal_entries'] as $entry) {
            JournalEntry::create([
                'journal_id' => $journal->id,
                'coa_id' => $entry['coa_id'],
                'debit' => $entry['debit'] ?? 0,
                'credit' => $entry['credit'] ?? 0,
            ]);
        }

        // return redirect()->back()->withErrors($validated)->withInput();

        return redirect()->route('bankbook.index', [
            'category_id' => $request->input('category_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ])->with('success', 'Jurnal berhasil diperbarui.');

        // } catch (\Exception $e) {
        //     return redirect()->back()
        //         ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])
        //         ->withInput();
        // }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data jurnal berdasarkan ID beserta relasi kategori & entries
        $journal = Journal::with(['journalCategory', 'journalEntries.coa', 'journalCategory.coa'])->findOrFail($id);

        // Ambil semua data mata uang (currencies)
        $currencies = Currency::all();

        // Ambil semua kategori jurnal
        $categories = JournalCategory::all();

        // Ambil semua daftar akun COA
        $coas = Coa::all();

        return view('pages.bankbook.edit', compact('journal', 'currencies', 'categories', 'coas'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Bersihkan nilai debit dan kredit
        $cleanedEntries = collect($request->input('journal_entries', []))->map(function ($entry) {
            $entry['debit'] = str_replace('.', '', $entry['debit'] ?? '0');
            $entry['credit'] = str_replace('.', '', $entry['credit'] ?? '0');
            return $entry;
        })->toArray();

        $request->merge(['journal_entries' => $cleanedEntries]);

        // Validasi input
        $validated = $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|max:255',
            'category_id' => 'required|exists:journal_categories,id',
            'currency_id' => 'required|exists:currencies,id',
            'journal_entries' => 'required|array|min:1', // Minimal harus ada 1 entri (karena lawannya akan dibuat otomatis)
            'journal_entries.*.coa_id' => 'required|exists:coas,id',
            'journal_entries.*.debit' => 'nullable|numeric|min:0',
            'journal_entries.*.credit' => 'nullable|numeric|min:0',
        ]);

        // Cari jurnal berdasarkan ID
        $journal = Journal::findOrFail($id);

        // Ambil COA dari kategori jurnal
        $categoryCoa = $journal->journalCategory->coa ?? null;
        if (!$categoryCoa) {
            return redirect()->back()
                ->withErrors(['error' => 'Kategori jurnal tidak memiliki akun COA.'])
                ->withInput();
        }

        // Hitung total debit dan kredit dari input user
        $totalDebit = collect($cleanedEntries)->sum('debit');
        $totalCredit = collect($cleanedEntries)->sum('credit');

        // Jika jumlah debit dan kredit tidak sama, buat lawan entri untuk kategori COA
        if ($totalDebit != $totalCredit) {
            $difference = abs($totalDebit - $totalCredit);

            if ($totalDebit > $totalCredit) {
                // Tambahkan entri kredit untuk kategori COA
                $cleanedEntries[] = [
                    'coa_id' => $categoryCoa->id,
                    'debit' => 0,
                    'credit' => $difference,
                ];
            } else {
                // Tambahkan entri debit untuk kategori COA
                $cleanedEntries[] = [
                    'coa_id' => $categoryCoa->id,
                    'debit' => $difference,
                    'credit' => 0,
                ];
            }
        }

        // Simpan perubahan jurnal
        $journal->update(Arr::except($validated, ['journal_entries']));

        // Simpan ID coa_id yang baru untuk perbandingan
        $newEntryIds = [];

        // Update atau buat journal_entries
        foreach ($cleanedEntries as $entry) {
            if (!empty($entry['coa_id'])) {
                $newEntryIds[] = $entry['coa_id'];
                JournalEntry::updateOrCreate(
                    ['journal_id' => $journal->id, 'coa_id' => $entry['coa_id']],
                    ['debit' => $entry['debit'], 'credit' => $entry['credit']]
                );
            }
        }

        // Hapus entri lama yang tidak ada dalam input terbaru
        JournalEntry::where('journal_id', $journal->id)->whereNotIn('coa_id', $newEntryIds)->delete();

        return redirect()->route('bankbook.index', [
            'category_id' => $request->input('category_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ])->with('success', 'Jurnal berhasil diperbarui.');
    }

    // public function update(Request $request, string $id)
    // {
    //     $cleanedEntries = collect($request->input('journal_entries', []))->map(function ($entry) {
    //         $entry['debit'] = str_replace('.', '', $entry['debit'] ?? '0');
    //         $entry['credit'] = str_replace('.', '', $entry['credit'] ?? '0');
    //         return $entry;
    //     })->toArray();
    //     $request->merge(['journal_entries' => $cleanedEntries]);
    //     $validated = $request->validate([
    //         'date' => 'required|date',
    //         'description' => 'required|string|max:255',
    //         'category_id' => 'required|exists:journal_categories,id',
    //         'currency_id' => 'required|exists:currencies,id',
    //         'journal_entries' => 'required|array|min:2',
    //         'journal_entries.*.coa_id' => 'required|exists:coas,id',
    //         'journal_entries.*.debit' => 'nullable|numeric|min:0',
    //         'journal_entries.*.credit' => 'nullable|numeric|min:0',
    //     ], [
    //         'date.required' => 'Tanggal harus di isi.',
    //         'date.date' => 'Format tanggal tidak valid.',
    //         'description.required' => 'Deskripsi harus diisi.',
    //         'category_id.required' => 'Kategori harus dipilih.',
    //         'category_id.exists' => 'Kategori tidak valid.',
    //         'currency_id.required' => 'Mata uang harus dipilih.',
    //         'currency_id.exists' => 'Mata uang tidak valid.',
    //         'journal_entries.required' => 'Minimal harus ada dua entri (debit & kredit).',
    //         'journal_entries.min' => 'Minimal harus ada dua entri (debit & kredit).',
    //         'journal_entries.*.coa_id.required' => 'COA harus dipilih.',
    //         'journal_entries.*.coa_id.exists' => 'COA tidak valid.',
    //         'journal_entries.*.debit.numeric' => 'Nilai debit harus berupa angka.',
    //         'journal_entries.*.credit.numeric' => 'Nilai kredit harus berupa angka.',
    //     ]);
    //     $journal = Journal::findOrFail($id);
    //     $totalDebit = collect($cleanedEntries)->sum('debit');
    //     $totalCredit = collect($cleanedEntries)->sum('credit');
    //     if ($totalDebit != $totalCredit) {
    //         return redirect()->back()
    //             ->withErrors(['error' => 'Jumlah debit dan kredit harus sama.'])
    //             ->withInput();
    //     }
    //     $journal->update(Arr::except($validated, ['journal_entries']));
    //     $newEntryIds = [];
    //     foreach ($validated['journal_entries'] as $entry) {
    //         if (!empty($entry['coa_id'])) {
    //             $newEntryIds[] = $entry['coa_id'];
    //             JournalEntry::updateOrCreate(
    //                 ['journal_id' => $journal->id, 'coa_id' => $entry['coa_id']],
    //                 ['debit' => $entry['debit'], 'credit' => $entry['credit']]
    //             );
    //         }
    //     }
    //     JournalEntry::where('journal_id', $journal->id)->whereNotIn('coa_id', $newEntryIds)->delete();
    //     return redirect()->route('bankbook.index', [
    //         'category_id' => $request->input('category_id'),
    //         'start_date' => $request->input('start_date'),
    //         'end_date' => $request->input('end_date'),
    //     ])->with('success', 'Jurnal berhasil diperbarui.');
    // }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $journal = Journal::findOrFail($id);
        $categoryId = $journal->category_id;
        $journal->delete();

        return redirect()->route('bankbook.index', ['category_id' => $categoryId])
            ->with('success', 'Jurnal berhasil dihapus.');
    }
}
