@extends('layouts.app')

@section('titlepage', 'Data Jurusan')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Data Jurusan</h1>
                        <p class="text-muted mb-0">Manajemen data jurusan dan program studi</p>
                    </div>
                    <div>
                        <a href="{{ route($userRole . '.jurusan.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Jurusan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Simple Search -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <form method="GET" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Cari Jurusan</label>
                                <input type="text" name="search" class="form-control form-control-sm"
                                    placeholder="Cari nama jurusan, singkatan..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Jenis</label>
                                <select class="form-select select2" name="jenis">
                                    <option value="">Semua Jenis</option>
                                    <option value="Akademik" {{ request('jenis') == 'Akademik' ? 'selected' : '' }}>Akademik
                                    </option>
                                    <option value="Vokasional" {{ request('jenis') == 'Vokasional' ? 'selected' : '' }}>
                                        Vokasional</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select class="form-select select2" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>
                                        Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label><br>
                                <button type="submit" class="btn btn-sm btn-primary w-100">
                                    <i class="fas fa-filter me-2"></i>Filter
                                </button>
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
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">No</th>
                                        <th>Nama Jurusan</th>
                                        <th>Singkatan</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jurusans as $item)
                                        <tr>
                                            <td class="text-center">
                                                <button
                                                    class="btn btn-sm btn-secondary">{{ $loop->iteration + ($jurusans->currentPage() - 1) * $jurusans->perPage() }}</button>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $item->nama_jurusan }}</div>
                                                @if ($item->deskripsi)
                                                    <small class="text-muted">{{ Str::limit($item->deskripsi, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">
                                                    {{ $item->singkatan }}
                                                </button>
                                            </td>
                                            <td>
                                                <button
                                                    class="btn btn-sm btn-{{ $item->jenis == 'Akademik' ? 'success' : 'info' }}">
                                                    @if ($item->jenis == 'Akademik')
                                                        <i class="fas fa-university me-1"></i>
                                                    @else
                                                        <i class="fas fa-tools me-1"></i>
                                                    @endif
                                                    {{ $item->jenis }}
                                                </button>
                                            </td>
                                            <td>
                                                <button
                                                    class="btn btn-sm btn-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                    {{ $item->status }}
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ route($userRole . '.jurusan.show', $item->id) }}"
                                                        class="btn btn-sm btn-info" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route($userRole . '.jurusan.edit', $item->id) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route($userRole . '.jurusan.destroy', $item->id) }}"
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
                                            <td colspan="6" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                                    <h5>Tidak ada data jurusan</h5>
                                                    <p>Belum ada data jurusan yang tersedia</p>
                                                    <a href="{{ route($userRole . '.jurusan.create') }}"
                                                        class="btn btn-primary">
                                                        <i class="fas fa-plus me-2"></i>Tambah Jurusan
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if ($jurusans->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">
                                    Menampilkan {{ $jurusans->count() }} dari {{ $jurusans->total() }} data
                                </small>
                                {{ $jurusans->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
