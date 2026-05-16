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
                    <a href="{{ route($userRole . '.mapel.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Mata Pelajaran
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">{{ $mapels->total() }}</h4>
                                <p class="mb-0">Total Mapel</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-book fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">{{ $mapels->where('status', 'Aktif')->count() }}</h4>
                                <p class="mb-0">Mapel Aktif</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-check-circle fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">{{ $mapels->where('kelompok', 'A')->count() }}</h4>
                                <p class="mb-0">Kelompok A</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-layer-group fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">{{ $mapels->where('status', 'Tidak Aktif')->count() }}</h4>
                                <p class="mb-0">Tidak Aktif</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-pause-circle fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route($userRole . '.mapel.index') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Kelompok</label>
                            <select name="kelompok" class="form-select select2">
                                <option value="">Semua Kelompok</option>
                                <option value="A" {{ request('kelompok') == 'A' ? 'selected' : '' }}>Kelompok A
                                </option>
                                <option value="B" {{ request('kelompok') == 'B' ? 'selected' : '' }}>Kelompok B
                                </option>
                                <option value="C" {{ request('kelompok') == 'C' ? 'selected' : '' }}>Kelompok C
                                </option>
                                <option value="Muatan Lokal" {{ request('kelompok') == 'Muatan Lokal' ? 'selected' : '' }}>
                                    Muatan Lokal</option>
                                <option value="Peminatan" {{ request('kelompok') == 'Peminatan' ? 'selected' : '' }}>
                                    Peminatan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jenis</label>
                            <select name="jenis" class="form-select select2">
                                <option value="">Semua Jenis</option>
                                <option value="Wajib" {{ request('jenis') == 'Wajib' ? 'selected' : '' }}>Wajib</option>
                                <option value="Pilihan" {{ request('jenis') == 'Pilihan' ? 'selected' : '' }}>Pilihan
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select select2">
                                <option value="">Semua Status</option>
                                <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>
                                    Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label><br>
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Daftar Mata Pelajaran</h5>
                        <div class="text-muted">
                            <small>Menampilkan {{ $mapels->count() }} dari {{ $mapels->total() }} data</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
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
                                            <button
                                                class="btn btn-sm btn-secondary">{{ $loop->iteration + ($mapels->currentPage() - 1) * $mapels->perPage() }}</button>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $item->kode_mapel }}</div>
                                            <small class="text-muted">{{ $item->singkatan }}</small>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $item->nama_mapel }}</div>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-light text-dark">{{ $item->kelompok }}</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-light text-dark">{{ $item->jenis }}</button>
                                        </td>
                                        <td>{{ $item->jam_per_minggu }}</td>
                                        <td>
                                            <button
                                                class="btn btn-sm btn-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                {{ $item->status }}
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
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
                </div>

                @if ($mapels->hasPages())
                    <div class="card-footer bg-white">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="text-muted">
                                    <small>
                                        Menampilkan {{ $mapels->firstItem() }} - {{ $mapels->lastItem() }}
                                        dari {{ $mapels->total() }} data
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm justify-content-end mb-0">
                                        {{-- Previous Page Link --}}
                                        @if ($mapels->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">
                                                    <i class="fas fa-chevron-left"></i>
                                                </span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $mapels->previousPageUrl() }}"
                                                    rel="prev">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                            </li>
                                        @endif

                                        {!! $mapels->links('pagination::bootstrap-5') !!}

                                        {{-- Next Page Link --}}
                                        @if ($mapels->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $mapels->nextPageUrl() }}" rel="next">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">
                                                    <i class="fas fa-chevron-right"></i>
                                                </span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
