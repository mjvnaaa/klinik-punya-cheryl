<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    // Menampilkan semua pasien (Admin)
    public function index()
    {
        $pasiens = Pasien::with('user')->latest()->get();
        return view('admin.pasien.index', compact('pasiens'));
    }

    // Menampilkan form tambah pasien (Admin)
    public function create()
    {
        return view('admin.pasien.create');
    }

    // Menyimpan pasien baru (Admin)
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nik' => 'required|string|size:16|unique:pasiens',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
        ]);

        // Gunakan DB Transaction
        DB::beginTransaction();
        try {
            // 1. Buat User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pasien',
            ]);

            // 2. Buat Pasien
            $user->pasien()->create([
                'nik' => $request->nik,
                'alamat' => $request->alamat,
                'tanggal_lahir' => $request->tanggal_lahir,
            ]);

            DB::commit();

            return redirect()->route('admin.pasien.index')->with('success', 'Pasien berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            // return back()->withErrors(['error' => 'Gagal menyimpan data. ' . $e->getMessage()]);
            return response()->json(['error' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    // Menampilkan detail 1 pasien (Admin)
    public function show(Pasien $pasien)
    {
        $pasien->load('user');
        // return view('admin.pasien.show', compact('pasien'));
        return response()->json($pasien);
    }

    // Menampilkan form edit pasien (Admin)
    public function edit(Pasien $pasien)
    {
        return view('admin.pasien.edit', compact('pasien'));
    }

    // Update data pasien (Admin)
    public function update(Request $request, Pasien $pasien)
    {
        // Validasi (email harus unik tapi abaikan user saat ini)
        $userId = $pasien->user_id;
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:users,email,$userId",
            'nik' => "required|string|size:16|unique:pasiens,nik,$pasien->id",
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'password' => 'nullable|string|min:8', // Password opsional
        ]);

        DB::beginTransaction();
        try {
            // 1. Update User
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $pasien->user->update($userData);

            // 2. Update Pasien
            $pasien->update([
                'nik' => $request->nik,
                'alamat' => $request->alamat,
                'tanggal_lahir' => $request->tanggal_lahir,
            ]);

            DB::commit();
            return redirect()->route('admin.pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
            //return response()->json(['message' => 'Data pasien berhasil diperbarui']);

        } catch (\Exception $e) {
            DB::rollBack();
            // return back()->withErrors(['error' => 'Gagal memperbarui data. ' . $e->getMessage()]);
            //return response()->json(['error' => 'Gagal memperbarui data: ' . $e->getMessage()], 500);
            return redirect()->route('admin.dashboar')->with('error', 'Gagal memperbarui data pasien' . $e->getMessage());
        }
    }

    // Menghapus data pasien (Admin)
    public function destroy(Pasien $pasien)
    {
        try {
            $pasien->user->delete();
            return redirect()->route('admin.pasien.index')->with('success', 'Data pasien berhasil dihapus.');

        } catch (\Exception $e) {
            // return back()->withErrors(['error' => 'Gagal menghapus data.']);
             return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }
}