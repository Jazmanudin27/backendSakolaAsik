@extends('layouts.app')

@section('titlepage', 'Laporan Kelas')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Laporan Kelas</h1>
                        <p class="text-muted mb-0">Laporan data kelas sekolah</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route($userRole . '.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fas fa-print me-2"></i>Cetak
                        </button>
                    </div>
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
                                <h4 class="mb-0">{{ $kelas->total() }}</h4>
                                <p class="mb-0">Total Kelas</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-school fa-2x opacity-75"></i>
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
                                <h4 class="mb-0">
                                    {{ $kelas->where('tingkat', 'X')->count() }}
                                </h4>
                                <p class="mb-0">Kelas X</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-layer-group fa-2x opacity-75"></i>
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
                                <h4 class="mb-0">
                                    {{ $kelas->where('tingkat', 'XI')->count() }}
                                </h4>
                                <p class="mb-0">Kelas XI</p>
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
                                <h4 class="mb-0">
                                    {{ $kelas->where('tingkat', 'XII')->count() }}
                                </h4>
                                <p class="mb-0">Kelas XII</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-layer-group fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route($userRole . '.laporan.kelas') }}" method="GET" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Cari Kelas</label>
                                <input type="text" name="search" class="form-control form-control-sm"
                                    placeholder="Nama atau kode kelas..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tingkat</label>
                                <select name="tingkat" class="form-select select2">
                                    <option value="">Semua Tingkat</option>
                                    <option value="X" {{ request('tingkat') == 'X' ? 'selected' : '' }}>X</option>
                                    <option value="XI" {{ request('tingkat') == 'XI' ? 'selected' : '' }}>XI</option>
                                    <option value="XII" {{ request('tingkat') == 'XII' ? 'selected' : '' }}>XII</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label><br>
                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Daftar Kelas</h5>
                            <div class="text-muted">
                                <small>Menampilkan {{ $kelas->count() }} dari {{ $kelas->total() }} data</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">No</th>
                                        <th>Kode Kelas</th>
                                        <th>Nama Kelas</th>
                                        <th>Tingkat</th>
                                        <th>Jurusan</th>
                                        <th>Kapasitas</th>
                                        <th>Jumlah Siswa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kelas as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration + ($kelas->currentPage() - 1) * $kelas->perPage() }}</td>
                                            <td><code>{{ $item->kode_kelas }}</code></td>
                                            <td>
                                                <div class="fw-semibold">{{ $item->nama_kelas }}</div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">{{ $item->tingkat }}</button>
                                            </td>
                                            <td>
                                                @if ($item->jurusan)
                                                    <button class="btn btn-sm btn-info">{{ $item->jurusan->nama_jurusan }}</button>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $item->kapasitas ?? '-' }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-success">
                                                    {{ $item->siswa()->count() }}
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                                    <h5>Tidak ada data kelas</h5>
                                                    <p>Belum ada data kelas yang tersedia</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($kelas->hasPages())
                        <div class="card-footer bg-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="text-muted">
                                        <small>
                                            Menampilkan {{ $kelas->firstItem() }} - {{ $kelas->lastItem() }}
                                            dari {{ $kelas->total() }} data
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination pagination-sm justify-content-end mb-0">
                                            @if ($kelas->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $kelas->previousPageUrl() }}" rel="prev">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            {!! $kelas->links('pagination::bootstrap-5') !!}
                                            @if ($kelas->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $kelas->nextPageUrl() }}" rel="next">
                                                        <i class="fas fa-chevron-right"></i>
                                                    </a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link"><i class="fas fa-chevron-right"></i></span>
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
    </div>
@endsection
