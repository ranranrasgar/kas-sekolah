<?php

use App\Models\Coa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CoaController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\StudentController;

// Route::post('/set-active-menu', [MenuController::class, 'setActiveMenu'])->name('set.active.menu');



Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    session()->forget(['activeMenu', 'activeSubmenu', 'activeSubSubmenu']);
    return view('index');
})->middleware(['auth', 'verified'])->name('index');

Route::post('/update-active-menu', function (Request $request) {
    Session::put('activeMenu', $request->menu);
    Session::put('activeSubmenu', $request->submenu);
    Session::put('activeSubSubmenu', $request->subsubmenu);
    return response()->json(['status' => 'success']);
})->name('updateActiveMenu');

Route::middleware('auth', 'verified')->group(function () {

    Route::get('/coa/codes/{coa_type_id}', function ($coa_type_id) {
        // Ambil semua kode COA berdasarkan tipe yang dipilih
        $codes = Coa::where('coa_type_id', $coa_type_id)->pluck('code')->toArray();

        return response()->json($codes);
    });

    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/photo', [ProfileController::class, 'updateProfilePhoto'])->name('profile.update_photo');

    Route::get('/coa', [CoaController::class, 'index'])->name('coa.index');
    Route::get('/coa/create', [CoaController::class, 'create'])->name('coa.create');
    Route::post('/coa', [CoaController::class, 'store'])->name('coa.store');
    Route::delete('/coa/{id}', [CoaController::class, 'destroy'])->name('coa.destroy');
    Route::get('/coa/{id}/edit', [CoaController::class, 'edit'])->name('coa.edit');
    Route::put('/coa/{id}', [CoaController::class, 'update'])->name('coa.update');


    // Route::get('/journals/cat=1', [JournalController::class, 'index'])->name('journals.index');
    Route::get('/journals', [JournalController::class, 'index'])->name('journals.index');
    Route::get('/journals/{id}/edit', [JournalController::class, 'edit'])->name('journals.edit');
    Route::put('/journals/{id}', [JournalController::class, 'update'])->name('journals.update');
    Route::get('/journals/create/{category}', [JournalController::class, 'create'])->name('journals.create');
    Route::post('/journals', [JournalController::class, 'store'])->name('journals.store');
    Route::delete('/journals/{id}', [JournalController::class, 'destroy'])->name('journals.destroy');

    Route::get('/akademik', [JournalController::class, 'index'])->name('akademik.index');
    Route::get('/keuangan', [JournalController::class, 'index'])->name('keuangan.index');
    Route::get('/keuangan/dana-bos/data', [JournalController::class, 'dataDanaBos'])->name('keuangan.dana-bos.data');
    Route::get('/keuangan/dana-bos/penerimaan', [JournalController::class, 'penerimaanDanaBos'])->name('keuangan.dana-bos.penerimaan');

    Route::get('email/verify', [VerifyEmailController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
        ->middleware(['signed'])
        ->name('verification.verify');
});

require __DIR__ . '/auth.php';
