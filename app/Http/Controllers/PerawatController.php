<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Carbon\Carbon;

class PerawatController extends Controller
{
    public function dashboard()
    {
        // 1. Ambil semua pasien (Disini kita asumsikan semua pasien yg terdaftar berpotensi berobat)
        // Dalam sistem nyata, biasanya ada tabel 'pendaftaran_harian', tapi kita pakai logika simpel:
        // Pasien yg belum ada rekam medis hari ini = Menunggu.
        
        // Ambil ID pasien yang SUDAH diperiksa hari ini (di tabel rekam_medis)
        $idPasienSudahDiperiksa = RekamMedis::whereDate('tanggal', Carbon::today())
                                    ->pluck('pasien_id')
                                    ->toArray();

        // A. DATA ANTRIAN (Pasien yang BELUM diperiksa hari ini)
        // Kita ambil contoh 10 pasien terakhir atau bisa difilter berdasarkan 'created_at' jika ada pendaftaran harian
        $antrian = Pasien::whereNotIn('id', $idPasienSudahDiperiksa)
                    ->with('user')
                    ->orderBy('updated_at', 'desc') // Yang baru daftar/update muncul diatas
                    ->get();

        // B. DATA SELESAI (Pasien yang SUDAH diperiksa hari ini)
        $selesai = RekamMedis::whereDate('tanggal', Carbon::today())
                    ->with('pasien.user', 'dokter.user')
                    ->get();

        // Statistik
        $totalAntrian = $antrian->count();
        $totalSelesai = $selesai->count();
        $dokterPraktek = 1; // Contoh statis, atau hitung dari tabel jadwal dokter

        return view('perawat.dashboard', compact('antrian', 'selesai', 'totalAntrian', 'totalSelesai', 'dokterPraktek'));
    }
}