<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PerawatController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\PembayaranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard Redirect Berdasarkan Role
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'dokter') {
        return redirect()->route('dokter.dashboard');
    } elseif ($user->role === 'perawat') {
        return redirect()->route('perawat.dashboard');
    } elseif ($user->role === 'pasien') {
        return redirect()->route('pasien.dashboard');
    }
    return abort(403);
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Rute Profil User
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Rute Sistem Klinik (Role-Based Access)
|--------------------------------------------------------------------------
*/

// === GRUP ADMIN ===
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // CRUD Utama (Manajemen Data)
    Route::resource('pasien', PasienController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('perawat', PerawatController::class);

    // Jadwal dan Pembayaran
    // Pastikan controller ini sudah ada, jika belum, buat dulu atau komentari baris ini
    // Route::resource('jadwal-dokter', JadwalDokterController::class);
    // Route::resource('pembayaran', PembayaranController::class);
});


// === GRUP DOKTER ===
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DokterController::class, 'dashboard'])->name('dashboard');

    // Mengisi rekam medis & resep
    Route::get('rekam-medis/create', [RekamMedisController::class, 'create'])->name('rekam-medis.create');
    Route::post('rekam-medis', [RekamMedisController::class, 'store'])->name('rekam-medis.store');
    
    // Melihat riwayat rekam medis pasien (Opsional)
    // Route::get('rekam-medis/pasien/{pasien}', [RekamMedisController::class, 'showByPasien'])->name('rekam-medis.pasien');
});


// === GRUP PERAWAT ===
Route::middleware(['auth', 'role:perawat'])->prefix('perawat')->name('perawat.')->group(function () {
    Route::get('/dashboard', [PerawatController::class, 'dashboard'])->name('dashboard');

    // Helper untuk melihat jadwal (Opsional)
    // Route::get('jadwal-dokter', [JadwalDokterController::class, 'index'])->name('jadwal-dokter.index');
});


// === GRUP PASIEN ===
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    // Menggunakan method 'dashboard' di PasienController untuk mengambil riwayat
    Route::get('/dashboard', [PasienController::class, 'dashboard'])->name('dashboard');

    // Route::get('pembayaran', [PembayaranController::class, 'showPembayaranSaya'])->name('pembayaran.saya');
});

require __DIR__.'/auth.php';