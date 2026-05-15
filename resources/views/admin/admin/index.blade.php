@extends('layouts.app')
@section('titlepage', 'Data Admin')
@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Data Admin</h1>
                        <p class="text-muted mb-0">Kelola data admin sekolah</p>
                    </div>
                    <a href="{{ route($userRole . '.admin.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Admin
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
                                <h4 class="mb-0">{{ $admins->total() }}</h4>
                                <p class="mb-0">Total Admin</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-user-shield fa-2x opacity-75"></i>
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
                                    {{ $admins->where('id_sekolah', '!=', null)->count() }}
                                </h4>
                                <p class="mb-0">Admin Sekolah</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-school fa-2x opacity-75"></i>
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
                                    {{ $admins->where('id_sekolah', null)->count() }}
                                </h4>
                                <p class="mb-0">Super Admin</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-crown fa-2x opacity-75"></i>
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
                                <h4 class="mb-0">{{ $admins->count() }}</h4>
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
                        <form action="{{ route($userRole . '.admin.index') }}" method="GET" class="row g-3">
                            <div class="col-md-10">
                                <label class="form-label">Cari Admin</label>
                                <input type="text" name="search" class="form-control form-control-sm"
                                    placeholder="Nama atau Email..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label><br>
                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-search me-2"></i>Cari
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
                            <h5 class="card-title mb-0">Daftar Admin</h5>
                            <div class="text-muted">
                                <small>Menampilkan {{ $admins->count() }} dari {{ $admins->total() }} data</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">No</th>
                                        <th>Nama Admin</th>
                                        <th>Email</th>
                                        <th>Sekolah</th>
                                        <th class="text-center" style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($admins as $item)
                                        <tr>
                                            <td class="text-center">
                                                <button
                                                    class="btn btn-sm btn-secondary">{{ $loop->iteration + ($admins->currentPage() - 1) * $admins->perPage() }}</button>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        <div class="avatar-title rounded-circle bg-primary text-white">
                                                            {{ strtoupper(substr($item->name, 0, 1)) }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $item->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-envelope text-muted me-2"></i>
                                                    {{ $item->email }}
                                                </div>
                                            </td>
                                            <td>
                                                @if ($item->sekolah)
                                                    <button class="btn btn-sm btn-light text-dark">
                                                        {{ $item->sekolah->nama_sekolah }}
                                                    </button>
                                                @else
                                                    <span class="badge bg-warning">Super Admin</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route($userRole . '.admin.show', $item->id) }}"
                                                        class="btn btn-sm btn-info" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route($userRole . '.admin.edit', $item->id) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route($userRole . '.admin.destroy', $item->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger delete"
                                                            title="Hapus"
                                                            data-href="{{ route($userRole . '.admin.destroy', $item->id) }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                                    <h5>Tidak ada data admin</h5>
                                                    <p>Belum ada data admin yang tersedia</p>
                                                    <a href="{{ route($userRole . '.admin.create') }}"
                                                        class="btn btn-primary">
                                                        <i class="fas fa-plus me-2"></i>Tambah Admin
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($admins->hasPages())
                        <div class="card-footer bg-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="text-muted">
                                        <small>
                                            Menampilkan {{ $admins->firstItem() }} - {{ $admins->lastItem() }}
                                            dari {{ $admins->total() }} data
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination pagination-sm justify-content-end mb-0">
                                            {{-- Previous Page Link --}}
                                            @if ($admins->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $admins->previousPageUrl() }}"
                                                        rel="prev">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </a>
                                                </li>
                                            @endif

                                            {!! $admins->links('pagination::bootstrap-5') !!}

                                            {{-- Next Page Link --}}
                                            @if ($admins->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $admins->nextPageUrl() }}"
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
