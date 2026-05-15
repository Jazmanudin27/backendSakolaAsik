@extends('layouts.app')

@section('titlepage', 'Laporan Siswa')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Laporan Siswa</h1>
                        <p class="text-muted mb-0">Laporan data siswa sekolah</p>
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
                                <h4 class="mb-0">{{ $siswa->total() }}</h4>
                                <p class="mb-0">Total Siswa</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-users fa-2x opacity-75"></i>
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
                                    {{ $siswa->where('status', 'Aktif')->count() }}
                                </h4>
                                <p class="mb-0">Siswa Aktif</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-user-check fa-2x opacity-75"></i>
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
                                    {{ $siswa->where('jk', 'Laki-laki')->count() }}
                                </h4>
                                <p class="mb-0">Laki-laki</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-mars fa-2x opacity-75"></i>
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
                                    {{ $siswa->where('jk', 'Perempuan')->count() }}
                                </h4>
                                <p class="mb-0">Perempuan</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-venus fa-2x opacity-75"></i>
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
                        <form action="{{ route($userRole . '.laporan.siswa') }}" method="GET" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Cari Siswa</label>
                                <input type="text" name="search" class="form-control form-control-sm"
                                    placeholder="Nama, NISN, atau NIS..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Kelas</label>
                                <select name="kelas" class="form-select select2">
                                    <option value="">Semua Kelas</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->kode_kelas }}" {{ request('kelas') == $k->kode_kelas ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jk" class="form-select select2">
                                    <option value="">Semua</option>
                                    <option value="Laki-laki" {{ request('jk') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan" {{ request('jk') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select select2">
                                    <option value="">Semua</option>
                                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="Keluar/Pindah"
                                    {{ request('status') == 'Keluar/Pindah' ? 'selected' : '' }}>
                                        Keluar/Pindah</option>
                                    <option value="Lulus" {{ request('status') == 'Lulus' ? 'selected' : '' }}>
                                        Lulus</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">&nbsp;</label><br>
                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-filter"></i>
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
                            <h5 class="card-title mb-0">Daftar Siswa</h5>
                            <div class="text-muted">
                                <small>Menampilkan {{ $siswa->count() }} dari {{ $siswa->total() }} data</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">No</th>
                                        <th>Foto</th>
                                        <th>Nama Siswa</th>
                                        <th>NISN</th>
                                        <th>NIS</th>
                                        <th class="text-center">JK</th>
                                        <th>Kelas</th>
                                        <th>Email</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($siswa as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration + ($siswa->currentPage() - 1) * $siswa->perPage() }}</td>
                                            <td class="text-center">
                                                @if ($item->foto)
                                                    <img src="{{ asset('storage/siswa/' . $item->foto) }}"
                                                        alt="Foto {{ $item->nama_siswa }}" class="rounded-circle"
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="avatar avatar-sm">
                                                        <div class="avatar-title rounded-circle bg-primary text-white">
                                                            {{ strtoupper(substr($item->nama_siswa, 0, 1)) }}
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $item->nama_siswa }}</div>
                                                <small class="text-muted">{{ $item->username }}</small>
                                            </td>
                                            <td><code>{{ $item->nisn }}</code></td>
                                            <td><code>{{ $item->nis }}</code></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-{{ $item->jk == 'Laki-laki' ? 'info' : 'danger' }}">
                                                    {{ $item->jk == 'Laki-laki' ? 'L' : 'P' }}
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-light text-dark">{{ $item->kelas->nama_kelas ?? $item->kode_kelas }}</button>
                                            </td>
                                            <td>
                                                @if ($item->email)
                                                    {{ $item->email }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                    {{ $item->status }}
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                                    <h5>Tidak ada data siswa</h5>
                                                    <p>Belum ada data siswa yang tersedia</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($siswa->hasPages())
                        <div class="card-footer bg-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="text-muted">
                                        <small>
                                            Menampilkan {{ $siswa->firstItem() }} - {{ $siswa->lastItem() }}
                                            dari {{ $siswa->total() }} data
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination pagination-sm justify-content-end mb-0">
                                            @if ($siswa->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $siswa->previousPageUrl() }}" rel="prev">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            {!! $siswa->links('pagination::bootstrap-5') !!}
                                            @if ($siswa->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $siswa->nextPageUrl() }}" rel="next">
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
