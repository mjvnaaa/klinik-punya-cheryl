<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController; // PENTING: Import ProfileController
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PerawatController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\PembayaranController;


/*
|--------------------------------------------------------------------------
| Autentikasi Bawaan Laravel (Login, Register, Logout)
|--------------------------------------------------------------------------
| Baris ini memuat semua rute otentikasi dari Laravel Breeze/Jetstream.
*/
require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| Dashboard Redirect Berdasarkan Role
|--------------------------------------------------------------------------
| Route ini memastikan user yang sudah login diarahkan ke dashboard sesuai role-nya.
*/
Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role == 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role == 'dokter') {
        return redirect()->route('dokter.dashboard');
    } elseif ($role == 'perawat') {
        return redirect()->route('perawat.dashboard');
    } elseif ($role == 'pasien') {
        return redirect()->route('pasien.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Rute Profil User (PENTING: Diperlukan oleh navigation bar Breeze)
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
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    
    // CRUD Utama
    Route::resource('pasien', PasienController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('perawat', PerawatController::class);

    // Jadwal dan Pembayaran
    Route::resource('jadwal-dokter', JadwalDokterController::class);
    Route::resource('pembayaran', PembayaranController::class);
});


// === GRUP DOKTER ===
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', fn() => view('dokter.dashboard'))->name('dashboard');

    // Melihat jadwal (Asumsi method showJadwalSaya sudah ada)
    Route::get('jadwal', [JadwalDokterController::class, 'showJadwalSaya'])->name('jadwal.saya');
    
    // Mengisi rekam medis & resep (Menggunakan RekamMedisController yang sudah kita buat)
    Route::get('rekam-medis/create', [RekamMedisController::class, 'create'])->name('rekam-medis.create');
    Route::post('rekam-medis', [RekamMedisController::class, 'store'])->name('rekam-medis.store');
    
    // Melihat riwayat rekam medis pasien (Untuk Dokter)
    Route::get('rekam-medis/pasien/{pasien}', [RekamMedisController::class, 'showByPasien'])->name('rekam-medis.pasien');
});


// === GRUP PERAWAT ===
Route::middleware(['auth', 'role:perawat'])->prefix('perawat')->name('perawat.')->group(function () {
    Route::get('/dashboard', fn() => view('perawat.dashboard'))->name('dashboard');

    // Melihat jadwal dokter
    Route::get('jadwal-dokter', [JadwalDokterController::class, 'index'])->name('jadwal-dokter.index');

    // Membantu mengisi rekam medis (Mengupdate Tindakan)
    Route::get('rekam-medis/{rekamMedis}/edit', [RekamMedisController::class, 'editTindakan'])->name('rekam-medis.editTindakan');
    Route::put('rekam-medis/{rekamMedis}', [RekamMedisController::class, 'updateTindakan'])->name('rekam-medis.updateTindakan');

    // Melihat riwayat rekam medis pasien (Untuk Perawat)
    Route::get('rekam-medis/pasien/{pasien}', [RekamMedisController::class, 'showByPasien'])->name('rekam-medis.pasien');
});


// === GRUP PASIEN ===
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', fn() => view('pasien.dashboard'))->name('dashboard');

    // Melihat jadwal dokter
    Route::get('jadwal-dokter', [JadwalDokterController::class, 'index'])->name('jadwal-dokter.index');

    // Melihat rekam medisnya sendiri
    Route::get('rekam-medis', [RekamMedisController::class, 'showRekamMedisSaya'])->name('rekam-medis.saya');
    
    // Melihat pembayaran
    Route::get('pembayaran', [PembayaranController::class, 'showPembayaranSaya'])->name('pembayaran.saya');
});

// Route utama, ganti dengan halaman landing yang sesuai
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dokter/dashboard', [DokterController::class, 'dashboard'])->name('dokter.dashboard');

Route::middleware(['auth', 'role:perawat'])->group(function () {
    // Ganti yang lama dengan ini:
    Route::get('/perawat/dashboard', [PerawatController::class, 'dashboard'])->name('perawat.dashboard');
});