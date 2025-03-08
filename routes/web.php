<?php

use App\Models\Coa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CoaController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\BankbookController;
use App\Http\Controllers\Auth\VerifyEmailController;

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

    // Siswa
    Route::resource('students', StudentController::class);
    // Profile
    Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
        Route::post('/photo', 'updateProfilePhoto')->name('update_photo');
    });
    // Coa
    Route::resource('coa', CoaController::class);
    Route::get('/coa/codes/{coa_type_id}', function ($coa_type_id) {
        // Ambil semua kode COA berdasarkan tipe yang dipilih
        $codes = Coa::where('coa_type_id', $coa_type_id)->pluck('code')->toArray();
        return response()->json($codes);
    });
    // Get Prefixses
    Route::get('/api/coa-prefixes', [CoaController::class, 'getPrefixes']);
    // Journal Umum
    Route::resource('journals', JournalController::class);
    // bankbook
    Route::resource('bankbook', BankbookController::class);

    Route::prefix('bankbook')->name('bankbook.')->controller(BankbookController::class)->group(function () {
        Route::get('/create/{category?}', 'create')->name('create');
    });

    Route::get('email/verify', [VerifyEmailController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
        ->middleware(['signed'])
        ->name('verification.verify');
});

require __DIR__ . '/auth.php';
