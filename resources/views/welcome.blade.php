@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <!-- Hero / Banner -->
    <div class="card shadow-sm mb-4 bg-primary text-white">
        <div class="card-body text-center py-5">
            <h1 class="fw-bold">Selamat Datang di Klinik Sehat Bersama</h1>
            <p class="mb-3">Pelayanan kesehatan profesional untuk Anda dan keluarga</p>
            <a href="#services" class="btn btn-light btn-lg">Lihat Layanan</a>
        </div>
    </div>

    <!-- Tentang Klinik -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3"><i class="fas fa-hospital me-2 text-primary"></i>Tentang Klinik Kami</h4>
                    <p>Klinik Sehat Bersama berdiri untuk memberikan pelayanan kesehatan terbaik. Dilengkapi fasilitas modern dan tenaga medis berpengalaman, kami siap membantu Anda menjaga kesehatan keluarga dengan ramah dan profesional.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Layanan / Services -->
    <div id="services" class="row mb-4">
        <div class="col-md-12">
            <h4 class="mb-3"><i class="fas fa-stethoscope me-2 text-primary"></i>Layanan Kami</h4>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm mb-3 text-center h-100">
                <div class="card-body">
                    <i class="fas fa-user-md fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Konsultasi Dokter Umum</h5>
                    <p class="card-text">Konsultasi keluhan umum dengan dokter berpengalaman.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm mb-3 text-center h-100">
                <div class="card-body">
                    <i class="fas fa-vials fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Pemeriksaan Laboratorium</h5>
                    <p class="card-text">Tes laboratorium lengkap untuk diagnosis cepat dan akurat.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm mb-3 text-center h-100">
                <div class="card-body">
                    <i class="fas fa-ambulance fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Layanan Gawat Darurat</h5>
                    <p class="card-text">Penanganan medis 24 jam untuk kondisi darurat.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Kontak / Buat Janji -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3"><i class="fas fa-calendar-check me-2 text-primary"></i>Buat Janji</h4>
                    <form class="row g-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="col-md-6">
                            <input type="tel" class="form-control" placeholder="No. Telepon" required>
                        </div>
                        <div class="col-md-6">
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <textarea class="form-control" rows="3" placeholder="Keluhan / Catatan"></textarea>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Kirim Janji</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer / Info Tambahan -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="alert alert-secondary shadow-sm d-flex align-items-center">
                <i class="fas fa-info-circle fa-2x me-3"></i>
                <div>
                    <strong>Alamat & Kontak:</strong> Jl. Contoh No.123, Kota Sehat, Indonesia | Telp: (021) 123-4567
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
