@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Manajemen Pasien</h1>
        <a href="{{ route('admin.pasien.create') }}" class="btn btn-primary">Tambah Pasien</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIK</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pasiens as $index => $pasien)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pasien->user->name }}</td>
                            <td>{{ $pasien->user->email }}</td>
                            <td>{{ $pasien->nik }}</td>
                            <td>{{ $pasien->alamat }}</td>
                            <td>
                                <a href="{{ route('admin.pasien.edit', $pasien->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.pasien.destroy', $pasien->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Data pasien tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection