@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">Dashboard Admin</div>

                <div class="card-body">
                    <h3>Selamat Datang, Admin!</h3>
                    <p>Silakan pilih menu manajemen di bawah ini:</p>

                    <div class="row mt-4">
                        <!-- Manajemen Pasien -->
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 border-primary">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Manajemen Pasien</h5>
                                    <p class="card-text">Kelola data pendaftaran pasien baru dan lama.</p>
                                    <a href="{{ route('admin.pasien.index') }}" class="btn btn-primary">Buka Pasien</a>
                                </div>
                            </div>
                        </div>

                        <!-- Manajemen Dokter -->
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 border-success">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Manajemen Dokter</h5>
                                    <p class="card-text">Kelola data dokter dan spesialisasi.</p>
                                    <a href="#" class="btn btn-success">Buka Dokter</a>
                                </div>
                            </div>
                        </div>

                        <!-- Manajemen Jadwal -->
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 border-warning">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Jadwal Dokter</h5>
                                    <p class="card-text">Atur jadwal praktik dokter.</p>
                                    <a href="#" class="btn btn-warning">Atur Jadwal</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection