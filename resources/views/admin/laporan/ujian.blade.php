@extends('layouts.app')

@section('titlepage', 'Laporan Ujian')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Laporan Ujian</h1>
                        <p class="text-muted mb-0">Laporan data ujian sekolah</p>
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
                                <h4 class="mb-0">{{ $ujian->total() }}</h4>
                                <p class="mb-0">Total Ujian</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-clipboard-list fa-2x opacity-75"></i>
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
                                    {{ $ujian->where('status', 'Aktif')->count() }}
                                </h4>
                                <p class="mb-0">Ujian Aktif</p>
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
                                <h4 class="mb-0">
                                    {{ $ujian->where('status', 'Draft')->count() }}
                                </h4>
                                <p class="mb-0">Draft</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-file-alt fa-2x opacity-75"></i>
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
                                    {{ $ujian->where('status', 'Selesai')->count() }}
                                </h4>
                                <p class="mb-0">Selesai</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-flag-checkered fa-2x opacity-75"></i>
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
                        <form action="{{ route($userRole . '.laporan.ujian') }}" method="GET" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Cari Ujian</label>
                                <input type="text" name="search" class="form-control form-control-sm"
                                    placeholder="Kode atau nama ujian..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select select2">
                                    <option value="">Semua Status</option>
                                    <option value="Draft" {{ request('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
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
                            <h5 class="card-title mb-0">Daftar Ujian</h5>
                            <div class="text-muted">
                                <small>Menampilkan {{ $ujian->count() }} dari {{ $ujian->total() }} data</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">No</th>
                                        <th>Kode Ujian</th>
                                        <th>Nama Ujian</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Tanggal</th>
                                        <th>Durasi</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ujian as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration + ($ujian->currentPage() - 1) * $ujian->perPage() }}</td>
                                            <td><code>{{ $item->kode_ujian }}</code></td>
                                            <td>
                                                <div class="fw-semibold">{{ $item->nama_ujian }}</div>
                                            </td>
                                            <td>
                                                @if ($item->mapel)
                                                    <button class="btn btn-sm btn-info">{{ $item->mapel->nama_mapel }}</button>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->tanggal_ujian ? $item->tanggal_ujian->format('d F Y') : '-' }}</td>
                                            <td>{{ $item->durasi }} menit</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-{{ $item->status == 'Aktif' ? 'success' : ($item->status == 'Selesai' ? 'primary' : 'secondary') }}">
                                                    {{ $item->status }}
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                                    <h5>Tidak ada data ujian</h5>
                                                    <p>Belum ada data ujian yang tersedia</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($ujian->hasPages())
                        <div class="card-footer bg-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="text-muted">
                                        <small>
                                            Menampilkan {{ $ujian->firstItem() }} - {{ $ujian->lastItem() }}
                                            dari {{ $ujian->total() }} data
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination pagination-sm justify-content-end mb-0">
                                            @if ($ujian->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $ujian->previousPageUrl() }}" rel="prev">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            {!! $ujian->links('pagination::bootstrap-5') !!}
                                            @if ($ujian->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $ujian->nextPageUrl() }}" rel="next">
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
