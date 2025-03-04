<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coa;
use App\Models\CoaType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class CoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $coaTypes = Coa::whereNull('parent_id')->get();

        $coas = Coa::with('coaType')
            // ->when($request->filled('coa_type'), fn($q) => $q->where('coa_type_id', $request->coa_type))
            ->where('parent_id', $request->coa_type)
            ->orderBy('code', 'asc')
            ->get();

        return view('pages.coa.index', compact('coas', 'coaTypes'));
    }

    // Ambil prefix type coa
    public function getPrefixes(): JsonResponse
    {
        // Ambil daftar prefix berdasarkan coa_type_id
        $prefixes = CoaType::pluck('prefix', 'id');

        return response()->json($prefixes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $coaTypes = CoaType::all();
        // Ambil default coa_type dari request (misal dari filter sebelumnya)
        $defaultCoaType = $request->query('coa_type', null);
        return view('pages.coa.create', compact('coaTypes', 'defaultCoaType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'coa_type_id' => 'required|exists:coa_types,id',
            'code' => 'required|unique:coas,code|max:10',
            'name' => 'required|string|max:255',
        ]);

        // Simpan data ke dalam database
        $coa = new Coa();
        $coa->coa_type_id = $request->coa_type_id;
        $coa->code = $request->code;
        $coa->name = $request->name;
        $coa->save();

        // Redirect dengan pesan sukses
        return redirect()->route('coa.index')->with('success', 'COA berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Ambil data COA berdasarkan ID
        $coa = Coa::with('coaType')->findOrFail($id);

        // Kirim data COA ke view untuk ditampilkan
        return view('pages.coa.show', compact('coa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Ambil data COA berdasarkan ID
        $coa = Coa::findOrFail($id);

        // Ambil semua tipe COA untuk dropdown
        $coaTypes = CoaType::all();

        // Kirim data COA dan tipe COA ke view untuk ditampilkan pada form edit
        return view('pages.coa.edit', compact('coa', 'coaTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'coa_type_id' => 'required|exists:coa_types,id',
            'code' => 'required|unique:coas,code,' . $id . '|max:10', // Perhatikan pengecualian pada kode COA yang sudah ada
            'name' => 'required|string|max:255',
        ]);

        // Ambil data COA berdasarkan ID
        $coa = Coa::findOrFail($id);

        // Update data COA
        $coa->coa_type_id = $request->coa_type_id;
        $coa->code = $request->code;
        $coa->name = $request->name;
        $coa->save();

        // Redirect dengan pesan sukses
        return redirect()->route('coa.index')->with('success', 'COA berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Ambil data COA berdasarkan ID
        $coa = Coa::findOrFail($id);

        // Hapus data COA
        $coa->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('coa.index')->with('success', 'COA berhasil dihapus.');
    }
}
