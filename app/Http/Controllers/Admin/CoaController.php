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
        // $coaTypes = Coa::whereNull('parent_id')->get();
        $coaTypes = CoaType::all();
        $coas = Coa::query()
            ->with('coaType')
            ->when(
                $request->filled('coa_type'),
                fn($q) => $q->where('coa_type_id', intval($request->coa_type))
            )
            ->orderBy('code', 'asc')
            ->get();
        // $coas = Coa::whereColumn('id', 'parent_id') // Ambil hanya root node
        //     ->with('children')
        //     ->get();
        // Bangun struktur tree
        // $coaTree = $this->buildTree($coas);
        return view('pages.coa.index', compact('coas', 'coaTypes'));
    }



    // private function buildTree($coas, $parentId = null, $level = 0)
    // {
    //     $tree = [];
    //     foreach ($coas as $coa) {
    //         if ($coa->parent_id == $parentId) {
    //             $coa->level = $level; // Tambahkan level untuk indentasi di Blade
    //             $coa->children = $this->buildTree($coas, $coa->id, $level + 1); // Rekursi
    //             $tree[] = $coa;
    //         }
    //     }
    //     return $tree;
    // }

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
        $coas = Coa::all();
        return view('pages.coa.create', compact('coaTypes', 'defaultCoaType', 'coas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'coa_type_id' => 'required|exists:coa_types,id',
            'parent_id' => 'nullable|exists:coas,id', // Pastikan parent_id valid jika diisi
            'code' => 'required|unique:coas,code|max:10',
            'name' => 'required|string|max:255',
        ]);

        // Simpan data ke dalam database dengan cara lebih efisien
        Coa::create([
            'coa_type_id' => $request->coa_type_id,
            'parent_id' => $request->parent_id ?? null, // Pastikan jika kosong tetap null
            'code' => $request->code,
            'name' => $request->name,
        ]);

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
        $coa = Coa::findOrFail($id);

        // aktiva, pasiva dan teman temanya
        $coaTypes = CoaType::all();

        // Ambil semua COA sebagai parent
        $coas = Coa::all();

        // Kirim data COA dan tipe COA ke view untuk ditampilkan pada form edit
        return view('pages.coa.edit', compact('coa', 'coaTypes', 'coas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'coa_type_id' => 'required|exists:coa_types,id',
            'parent_id' => 'nullable|exists:coas,id', // Tambahkan validasi parent_id
            'code' => 'required|unique:coas,code,' . $id . '|max:10',
            'name' => 'required|string|max:255',
        ]);

        // Ambil data COA berdasarkan ID
        $coa = Coa::findOrFail($id);

        $coa->update([
            'coa_type_id' => $request->coa_type_id,
            'parent_id' => $request->parent_id ?? null, // Pastikan jika kosong tetap null
            'code' => $request->code,
            'name' => $request->name,
        ]);


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
