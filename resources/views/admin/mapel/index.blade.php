@extends('layouts.app')

@section('titlepage', 'Mata Pelajaran')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Mata Pelajaran</h1>
                    <p class="text-muted mb-0">Manajemen mata pelajaran dan kurikulum</p>
                </div>
                <div>
                    <a href="{{ route($userRole . '.mapel.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Mata Pelajaran
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm bg-gradient-start">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper bg-primary text-white me-3">
                            <i class="fas fa-book"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Mapel</h6>
                            <h3 class="mb-0 fw-bold">{{ $mapels->total() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm bg-gradient-mid">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper bg-success text-white me-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Aktif</h6>
                            <h3 class="mb-0 fw-bold">{{ $mapels->where('status', 'Aktif')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm bg-gradient-end">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper bg-warning text-white me-3">
                            <i class="fas fa-pause-circle"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Tidak Aktif</h6>
                            <h3 class="mb-0 fw-bold">{{ $mapels->where('status', 'Tidak Aktif')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm bg-gradient-end">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper bg-info text-white me-3">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Kelompok A</h6>
                            <h3 class="mb-0 fw-bold">{{ $mapels->where('kelompok', 'A')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <select class="form-select select2" name="kelompok">
                                <option value="">Semua Kelompok</option>
                                <option value="A" {{ request('kelompok') == 'A' ? 'selected' : '' }}>Kelompok A</option>
                                <option value="B" {{ request('kelompok') == 'B' ? 'selected' : '' }}>Kelompok B</option>
                                <option value="C" {{ request('kelompok') == 'C' ? 'selected' : '' }}>Kelompok C</option>
                                <option value="Muatan Lokal" {{ request('kelompok') == 'Muatan Lokal' ? 'selected' : '' }}>Muatan Lokal</option>
                                <option value="Peminatan" {{ request('kelompok') == 'Peminatan' ? 'selected' : '' }}>Peminatan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select select2" name="jenis">
                                <option value="">Semua Jenis</option>
                                <option value="Wajib" {{ request('jenis') == 'Wajib' ? 'selected' : '' }}>Wajib</option>
                                <option value="Pilihan" {{ request('jenis') == 'Pilihan' ? 'selected' : '' }}>Pilihan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select select2" name="status">
                                <option value="">Semua Status</option>
                                <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="btn-group w-100">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-2"></i>Filter
                                </button>
                                <a href="{{ route($userRole . '.mapel.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Reset
                                </a>
                            </div>
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
                                    <th>Kode</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelompok</th>
                                    <th>Jenis</th>
                                    <th>Jam/Minggu</th>
                                    <th>Status</th>
                                    <th class="text-center" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mapels as $item)
                                    <tr>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-secondary">{{ $loop->iteration + ($mapels->currentPage() - 1) * $mapels->perPage() }}</button>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $item->kode_mapel }}</div>
                                            <small class="text-muted">{{ $item->singkatan }}</small>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $item->nama_mapel }}</div>
                                            @if($item->deskripsi)
                                                <small class="text-muted">{{ Str::limit($item->deskripsi, 30) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-{{ 
                                                $item->kelompok == 'A' ? 'primary' : 
                                                ($item->kelompok == 'B' ? 'success' : 
                                                ($item->kelompok == 'C' ? 'warning' : 'info')) 
                                            }}">
                                                {{ $item->kelompok }}
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-{{ $item->jenis == 'Wajib' ? 'primary' : 'secondary' }}">
                                                {{ $item->jenis }}
                                            </button>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $item->jam_per_minggu }} jam</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                {{ $item->status }}
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route($userRole . '.mapel.show', $item->id) }}" 
                                                   class="btn btn-sm btn-info" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route($userRole . '.mapel.edit', $item->id) }}" 
                                                   class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route($userRole . '.mapel.destroy', $item->id) }}" 
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
                                                <h5>Tidak ada data mata pelajaran</h5>
                                                <p>Belum ada data mata pelajaran yang tersedia</p>
                                                <a href="{{ route($userRole . '.mapel.create') }}" 
                                                   class="btn btn-primary">
                                                    <i class="fas fa-plus me-2"></i>Tambah Mata Pelajaran
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($mapels->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                Menampilkan {{ $mapels->count() }} dari {{ $mapels->total() }} data
                            </small>
                            {{ $mapels->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-wrapper {
    width: 3rem;
    height: 3rem;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.bg-gradient-start {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-mid {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.bg-gradient-end {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transition: all 0.15s ease-in-out;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

.btn {
    border-radius: 0.5rem;
    font-weight: 500;
}

.btn-group .btn {
    border-radius: 0.375rem;
}
</style>
@endsection
