@extends('layouts.app')
@section('titlepage', 'Data Sekolah')
@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Data Sekolah</h1>
                        <p class="text-muted mb-0">Kelola data sekolah</p>
                    </div>
                    <a href="{{ route($userRole . '.sekolah.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Sekolah
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
                                <h4 class="mb-0">{{ $sekolahs->total() }}</h4>
                                <p class="mb-0">Total Sekolah</p>
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
                                    {{ $sekolahs->where('status', 'Aktif')->count() }}
                                </h4>
                                <p class="mb-0">Sekolah Aktif</p>
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
                                    {{ $sekolahs->where('jenjang', 'SMA')->count() }}
                                </h4>
                                <p class="mb-0">SMA</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-graduation-cap fa-2x opacity-75"></i>
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
                                <h4 class="mb-0">{{ $sekolahs->count() }}</h4>
                                <p class="mb-0">Halaman Ini</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-list fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route($userRole . '.sekolah.index') }}" method="GET" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Cari Sekolah</label>
                                <input type="text" name="search" class="form-control form-control-sm"
                                    placeholder="Nama, Kode, atau NPSN..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jenjang</label>
                                <select name="jenjang" class="form-select select2">
                                    <option value="">Semua</option>
                                    <option value="SD" {{ request('jenjang') == 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="SMP" {{ request('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="SMA" {{ request('jenjang') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                    <option value="SMK" {{ request('jenjang') == 'SMK' ? 'selected' : '' }}>SMK</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select select2">
                                    <option value="">Semua</option>
                                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label><br>
                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-filter me-2"></i>Filter
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
                            <h5 class="card-title mb-0">Daftar Sekolah</h5>
                            <div class="text-muted">
                                <small>Menampilkan {{ $sekolahs->count() }} dari {{ $sekolahs->total() }} data</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">No</th>
                                        <th>Nama Sekolah</th>
                                        <th>Kode Sekolah</th>
                                        <th>NPSN</th>
                                        <th>Jenjang</th>
                                        <th>Kabupaten/Kota</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sekolahs as $item)
                                        <tr>
                                            <td class="text-center">
                                                <button
                                                    class="btn btn-sm btn-secondary">{{ $loop->iteration + ($sekolahs->currentPage() - 1) * $sekolahs->perPage() }}</button>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        <div class="avatar-title rounded-circle bg-primary text-white">
                                                            <i class="fas fa-school"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $item->nama_sekolah }}</div>
                                                        <small class="text-muted">{{ $item->kepala_sekolah }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><code>{{ $item->kode_sekolah }}</code></td>
                                            <td><code>{{ $item->npsn }}</code></td>
                                            <td>
                                                <button class="btn btn-sm btn-light text-dark">{{ $item->jenjang }}</button>
                                            </td>
                                            <td>{{ $item->kabupaten_kota }}</td>
                                            <td class="text-center">
                                                <button
                                                    class="btn btn-sm btn-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                    {{ $item->status }}
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route($userRole . '.sekolah.show', $item->kode_sekolah) }}"
                                                        class="btn btn-sm btn-info" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route($userRole . '.sekolah.edit', $item->kode_sekolah) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route($userRole . '.sekolah.destroy', $item->kode_sekolah) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger delete"
                                                            title="Hapus"
                                                            data-href="{{ route($userRole . '.sekolah.destroy', $item->kode_sekolah) }}">
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
                                                    <h5>Tidak ada data sekolah</h5>
                                                    <p>Belum ada data sekolah yang tersedia</p>
                                                    <a href="{{ route($userRole . '.sekolah.create') }}"
                                                        class="btn btn-primary">
                                                        <i class="fas fa-plus me-2"></i>Tambah Sekolah
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($sekolahs->hasPages())
                        <div class="card-footer bg-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="text-muted">
                                        <small>
                                            Menampilkan {{ $sekolahs->firstItem() }} - {{ $sekolahs->lastItem() }}
                                            dari {{ $sekolahs->total() }} data
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination pagination-sm justify-content-end mb-0">
                                            {{-- Previous Page Link --}}
                                            @if ($sekolahs->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $sekolahs->previousPageUrl() }}"
                                                        rel="prev">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </a>
                                                </li>
                                            @endif

                                            {!! $sekolahs->links('pagination::bootstrap-5') !!}

                                            {{-- Next Page Link --}}
                                            @if ($sekolahs->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $sekolahs->nextPageUrl() }}"
                                                        rel="next">
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
    </div>
@endsection
