@extends('layouts.app')

@section('titlepage', 'Data Guru')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Data Guru</h1>
                        <p class="text-muted mb-0">Manajemen data guru dan tenaga pendidik</p>
                    </div>
                    <div>
                        <a href="{{ route($userRole . '.guru.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Guru
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-2">
            <div class="col-xl-3 col-md-6 mb-2">
                <div class="card border-0 shadow-sm bg-primary">
                    <div class="card-body text-white">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-chalkboard-teacher fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Total Guru</h6>
                                <h3 class="mb-0 fw-bold">{{ $gurus->total() }}</h3>
                                <small class="opacity-75">
                                    <i class="fas fa-users me-1"></i>
                                    {{ $gurus->where('status', 'Aktif')->count() }} aktif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-2">
                <div class="card border-0 shadow-sm bg-success">
                    <div class="card-body text-white">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-user-tie fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Kepala Sekolah</h6>
                                <h3 class="mb-0 fw-bold">{{ $gurus->where('jabatan', 'Kepala Sekolah')->count() }}</h3>
                                <small class="opacity-75">
                                    <i class="fas fa-building me-1"></i>
                                    Terdaftar
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-2">
                <div class="card border-0 shadow-sm bg-info">
                    <div class="card-body text-white">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-venus fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Guru Perempuan</h6>
                                <h3 class="mb-0 fw-bold">{{ $gurus->where('jk', 'Perempuan')->count() }}</h3>
                                <small class="opacity-75">
                                    <i class="fas fa-percentage me-1"></i>
                                    {{ $gurus->count() > 0 ? round(($gurus->where('jk', 'Perempuan')->count() / $gurus->count()) * 100, 1) : 0 }}%
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-2">
                <div class="card border-0 shadow-sm bg-warning">
                    <div class="card-body text-white">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-mars fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Guru Laki-laki</h6>
                                <h3 class="mb-0 fw-bold">{{ $gurus->where('jk', 'Laki-laki')->count() }}</h3>
                                <small class="opacity-75">
                                    <i class="fas fa-percentage me-1"></i>
                                    {{ $gurus->count() > 0 ? round(($gurus->where('jk', 'Laki-laki')->count() / $gurus->count()) * 100, 1) : 0 }}%
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Simple Search -->
        <div class="row mb-2">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <form method="GET" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Cari Guru</label>
                                <input type="text" name="search" class="form-control form-control-sm"
                                    placeholder="Cari nama guru..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select class="form-select select2" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>
                                        Tidak Aktif</option>
                                    <option value="Cuti" {{ request('status') == 'Cuti' ? 'selected' : '' }}>Cuti
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-select select2" name="jk">
                                    <option value="">Semua Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ request('jk') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan" {{ request('jk') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">No</th>
                                        <th style="width: 80px;">Foto</th>
                                        <th>Nama Guru</th>
                                        <th>JK</th>
                                        <th>Jabatan</th>
                                        <th>Sekolah</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($gurus as $guru)
                                        <tr>
                                            <td class="text-center">
                                                <button
                                                    class="btn btn-sm btn-secondary">{{ $loop->iteration + ($gurus->currentPage() - 1) * $gurus->perPage() }}</button>
                                            </td>
                                            <td>
                                                <div class="avatar-wrapper">
                                                    @if ($guru->foto)
                                                        <img src="{{ asset('storage/guru/' . $guru->foto) }}"
                                                            alt="Foto {{ $guru->nama_guru }}"
                                                            class="rounded-circle border-2 border-white shadow me-4"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <div class="avatar-title rounded-circle bg-primary text-white border-2 border-white shadow me-4"
                                                            style="width: 50px; height: 50px; font-size: 1.2rem; font-weight: bold; display: flex; align-items: center; justify-content: center;">
                                                            {{ strtoupper(substr($guru->nama_guru, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $guru->nama_guru }}</div>
                                                <small class="text-muted">{{ $guru->email }}</small>
                                                <br>
                                                <small class="text-muted">{{ $guru->no_hp }}</small>
                                            </td>
                                            <td class="text-center">
                                                <button
                                                    class="btn btn-sm btn-{{ $guru->jk == 'Laki-laki' ? 'info' : 'danger' }}">
                                                    {{ $guru->jk == 'Laki-laki' ? 'L' : 'P' }}
                                                </button>
                                            </td>
                                            <td>
                                                <button
                                                    class="btn btn-sm btn-{{ $guru->jabatan == 'Kepala Sekolah' ? 'success' : ($guru->jabatan == 'Wakil Kepala Sekolah' ? 'warning' : 'primary') }}">
                                                    {{ $guru->jabatan }}
                                                </button>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $guru->sekolah->nama_sekolah ?? '-' }}</div>
                                                <small class="text-muted">{{ $guru->jurusan }}</small>
                                            </td>
                                            <td>
                                                <button
                                                    class="btn btn-sm btn-{{ $guru->status == 'Aktif' ? 'success' : ($guru->status == 'Cuti' ? 'warning' : 'secondary') }}">
                                                    {{ $guru->status }}
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ route($userRole . '.guru.show', $guru->id) }}"
                                                        class="btn btn-sm btn-info" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route($userRole . '.guru.edit', $guru->id) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route($userRole . '.guru.destroy', $guru->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger delete"
                                                            title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                                    <h5>Tidak ada data guru</h5>
                                                    <p>Belum ada data guru yang tersedia</p>
                                                    <a href="{{ route($userRole . '.guru.create') }}"
                                                        class="btn btn-primary">
                                                        <i class="fas fa-plus me-2"></i>Tambah Guru
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if ($gurus->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">
                                    Menampilkan {{ $gurus->count() }} dari {{ $gurus->total() }} data
                                </small>
                                {{ $gurus->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
