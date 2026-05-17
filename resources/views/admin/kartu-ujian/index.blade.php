@extends('layouts.app')
@section('titlepage', 'Data Kartu Ujian')
@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Data Kartu Ujian</h1>
                        <p class="text-muted mb-0">Kelola data kartu ujian</p>
                    </div>
                    <a href="{{ route($userRole . '.kartu-ujian.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Kartu Ujian
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
                                <h4 class="mb-0">{{ $kartuUjians->total() }}</h4>
                                <p class="mb-0">Total Kartu Ujian</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-id-card fa-2x opacity-75"></i>
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
                                <h4 class="mb-0">{{ $kelasList->count() }}</h4>
                                <p class="mb-0">Total Kelas</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-users fa-2x opacity-75"></i>
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
                                <h4 class="mb-0">{{ $kartuUjians->count() }}</h4>
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
                        <form action="{{ route($userRole . '.kartu-ujian.index') }}" method="GET" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Cari Kartu Ujian</label>
                                <input type="text" name="search" class="form-control form-control-sm"
                                    placeholder="Nama Ujian, Kode, atau Tahun..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Kelas</label>
                                <select name="id_kelas" class="form-select select2">
                                    <option value="">Semua Kelas</option>
                                    @foreach ($kelasList as $kelas)
                                        <option value="{{ $kelas->id }}"
                                            {{ request('id_kelas') == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama_kelas }}
                                        </option>
                                    @endforeach
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
                            <h5 class="card-title mb-0">Daftar Kartu Ujian</h5>
                            <div class="text-muted">
                                <small>Menampilkan {{ $kartuUjians->count() }} dari {{ $kartuUjians->total() }}
                                    data</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">No</th>
                                        <th>Nama Ujian</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Kelas</th>
                                        <th class="text-center" style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kartuUjians as $item)
                                        <tr>
                                            <td class="text-center">
                                                <button
                                                    class="btn btn-sm btn-secondary">{{ $loop->iteration + ($kartuUjians->currentPage() - 1) * $kartuUjians->perPage() }}</button>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        <div class="avatar-title rounded-circle bg-primary text-white">
                                                            <i class="fas fa-id-card"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $item->nama_ujian }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $item->tahunAjaran->tahun_ajaran . ' - Semester' . $item->tahunAjaran->semester }}
                                            </td>
                                            <td>
                                                @if ($item->kelas)
                                                    <button
                                                        class="btn btn-sm btn-light text-dark">{{ $item->kelas->nama_kelas }}</button>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route($userRole . '.kartu-ujian.show', $item->id) }}"
                                                        class="btn btn-sm btn-info" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route($userRole . '.kartu-ujian.print', $item->id) }}"
                                                        class="btn btn-sm btn-success" title="Cetak">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                    <a href="{{ route($userRole . '.kartu-ujian.edit', $item->id) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route($userRole . '.kartu-ujian.destroy', $item->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger delete"
                                                            title="Hapus"
                                                            data-href="{{ route($userRole . '.kartu-ujian.destroy', $item->id) }}">
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
                                                    <h5>Tidak ada data kartu ujian</h5>
                                                    <p>Belum ada data kartu ujian yang tersedia</p>
                                                    <a href="{{ route($userRole . '.kartu-ujian.create') }}"
                                                        class="btn btn-primary">
                                                        <i class="fas fa-plus me-2"></i>Tambah Kartu Ujian
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($kartuUjians->hasPages())
                        <div class="card-footer bg-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="text-muted">
                                        <small>
                                            Menampilkan {{ $kartuUjians->firstItem() }} - {{ $kartuUjians->lastItem() }}
                                            dari {{ $kartuUjians->total() }} data
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination pagination-sm justify-content-end mb-0">
                                            {{-- Previous Page Link --}}
                                            @if ($kartuUjians->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $kartuUjians->previousPageUrl() }}"
                                                        rel="prev">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </a>
                                                </li>
                                            @endif

                                            {!! $kartuUjians->links('pagination::bootstrap-5') !!}

                                            {{-- Next Page Link --}}
                                            @if ($kartuUjians->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $kartuUjians->nextPageUrl() }}"
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
