<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RekamMedis;
use App\Models\Pasien;
use Carbon\Carbon;

class DokterController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Pastikan user benar-benar dokter
        if (!$user->dokter) {
            return redirect()->back()->with('error', 'Akun Anda tidak terhubung dengan data Dokter.');
        }

        // 1. Ambil data Pasien yang SUDAH diperiksa HARI INI oleh dokter ini
        $sudahDiperiksa = RekamMedis::whereDate('tanggal', Carbon::today())
                            ->where('dokter_id', $user->dokter->id)
                            ->with('pasien.user') // Load data pasien & user
                            ->get();

        // Ambil ID pasien yang sudah diperiksa untuk filter
        $idPasienSudah = $sudahDiperiksa->pluck('pasien_id')->toArray();

        // 2. Ambil data Pasien yang BELUM diperiksa (Simulasi Antrian)
        // Mengambil semua pasien KECUALI yang sudah diperiksa hari ini
        $antrian = Pasien::whereNotIn('id', $idPasienSudah)
                    ->with('user')
                    ->get();

        // Hitung statistik
        $jumlahSelesai = $sudahDiperiksa->count();
        $jumlahAntrian = $antrian->count();

        return view('dokter.dashboard', compact('antrian', 'sudahDiperiksa', 'jumlahSelesai', 'jumlahAntrian'));
    }
}