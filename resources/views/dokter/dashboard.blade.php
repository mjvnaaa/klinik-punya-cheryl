@extends('layouts.admin') @section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Dashboard Dokter</h4>
        </div>
        <div class="card-body">
            <h3>Halo, Dr. {{ Auth::user()->name }}</h3>
            <p class="text-muted">Selamat bertugas, silakan pilih menu di bawah ini:</p>
            <hr>
            <div class="d-grid gap-2 d-md-block">
                <a href="{{ route('dokter.rekam-medis.create') }}" class="btn btn-primary btn-lg">
                    💊 Buat Rekam Medis Baru
                </a>
                <a href="#" class="btn btn-outline-success btn-lg">
                    📅 Lihat Jadwal Praktik Saya
                </a>
            </div>
        </div>
    </div>
</div>
@endsection