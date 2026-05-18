@extends('layouts.app')
@section('titlepage', 'Data Absensi')
@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Data Absensi</h1>
                        <p class="text-muted mb-0">Kelola data absensi siswa</p>
                    </div>
                    <a href="{{ route($userRole . '.absensi.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Absensi
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
                                <h4 class="mb-0">{{ $absensi->total() }}</h4>
                                <p class="mb-0">Total Absensi</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-calendar-check fa-2x opacity-75"></i>
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
                                    {{ $absensi->where('status', 'Hadir')->count() }}
                                </h4>
                                <p class="mb-0">Hadir</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-user-check fa-2x opacity-75"></i>
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
                                    {{ $absensi->whereIn('status', ['Sakit', 'Izin'])->count() }}
                                </h4>
                                <p class="mb-0">Sakit/Izin</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-user-clock fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">
                                    {{ $absensi->where('status', 'Alpha')->count() }}
                                </h4>
                                <p class="mb-0">Alpha</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-user-times fa-2x opacity-75"></i>
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
                        <form action="{{ route($userRole . '.absensi.index') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Cari Siswa</label>
                                <input type="text" name="search" class="form-control form-control-sm"
                                    placeholder="Nama, NISN, atau NIS..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control form-control-sm"
                                    value="{{ request('tanggal') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select select2">
                                    <option value="">Semua</option>
                                    <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>
                                        Hadir</option>
                                    <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>
                                        Sakit</option>
                                    <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>
                                        Izin</option>
                                    <option value="Alpha" {{ request('status') == 'Alpha' ? 'selected' : '' }}>
                                        Alpha</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label><br>
                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-filter me-2"></i>Filter
                                </button>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label><br>
                                <a href="{{ route($userRole . '.absensi.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                                    <i class="fas fa-redo me-2"></i>Reset
                                </a>
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
                            <h5 class="card-title mb-0">Daftar Absensi</h5>
                            <div class="text-muted">
                                <small>Menampilkan {{ $absensi->count() }} dari {{ $absensi->total() }} data</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Siswa</th>
                                        <th>NISN</th>
                                        <th>Kelas</th>
                                        <th class="text-center">Status</th>
                                        <th>Keterangan</th>
                                        <th class="text-center" style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($absensi as $item)
                                        <tr>
                                            <td class="text-center">
                                                <button
                                                    class="btn btn-sm btn-secondary">{{ $loop->iteration + ($absensi->currentPage() - 1) * $absensi->perPage() }}</button>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ \Carbon\Carbon::parse($item->tanggal_absensi)->format('d/m/Y') }}</div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-semibold">{{ $item->siswa->nama_siswa ?? '-' }}</div>
                                                        <small class="text-muted">{{ $item->siswa->username ?? '-' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><code>{{ $item->siswa->nisn ?? '-' }}</code></td>
                                            <td>
                                                <button
                                                    class="btn btn-sm btn-light text-dark">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</button>
                                            </td>
                                            <td class="text-center">
                                                @if($item->status == 'Hadir')
                                                    <button class="btn btn-sm btn-success">Hadir</button>
                                                @elseif($item->status == 'Sakit')
                                                    <button class="btn btn-sm btn-warning">Sakit</button>
                                                @elseif($item->status == 'Izin')
                                                    <button class="btn btn-sm btn-info">Izin</button>
                                                @else
                                                    <button class="btn btn-sm btn-danger">Alpha</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->keterangan)
                                                    {{ Str::limit($item->keterangan, 50) }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route($userRole . '.absensi.show', $item->id) }}"
                                                        class="btn btn-sm btn-info" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route($userRole . '.absensi.edit', $item->id) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route($userRole . '.absensi.destroy', $item->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger delete"
                                                            title="Hapus"
                                                            data-href="{{ route($userRole . '.absensi.destroy', $item->id) }}">
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
                                                    <h5>Tidak ada data absensi</h5>
                                                    <p>Belum ada data absensi yang tersedia</p>
                                                    <a href="{{ route($userRole . '.absensi.create') }}"
                                                        class="btn btn-primary">
                                                        <i class="fas fa-plus me-2"></i>Tambah Absensi
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($absensi->hasPages())
                        <div class="card-footer bg-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="text-muted">
                                        <small>
                                            Menampilkan {{ $absensi->firstItem() }} - {{ $absensi->lastItem() }}
                                            dari {{ $absensi->total() }} data
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination pagination-sm justify-content-end mb-0">
                                            {{-- Previous Page Link --}}
                                            @if ($absensi->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $absensi->previousPageUrl() }}"
                                                        rel="prev">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </a>
                                                </li>
                                            @endif

                                            {!! $absensi->links('pagination::bootstrap-5') !!}

                                            {{-- Next Page Link --}}
                                            @if ($absensi->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $absensi->nextPageUrl() }}"
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
