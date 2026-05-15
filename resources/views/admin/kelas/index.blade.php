@extends('layouts.app')

@section('titlepage', 'Data Kelas')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Data Kelas</h1>
                        <p class="text-muted mb-0">Manajemen data kelas dan ruangan</p>
                    </div>
                    <div>
                        <a href="{{ route($userRole . '.kelas.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Kelas
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
                                <label class="form-label">Cari Kelas</label>
                                <input type="text" name="search" class="form-control form-control-sm"
                                    placeholder="Cari nama kelas, wali kelas..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Tingkat</label>
                                <select class="form-select select2" name="tingkat">
                                    <option value="">Semua Tingkat</option>
                                    <option value="X" {{ request('tingkat') == 'X' ? 'selected' : '' }}>X</option>
                                    <option value="XI" {{ request('tingkat') == 'XI' ? 'selected' : '' }}>XI</option>
                                    <option value="XII" {{ request('tingkat') == 'XII' ? 'selected' : '' }}>XII</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select class="form-select select2" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
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
                                        <th>Nama Kelas</th>
                                        <th>Tingkat</th>
                                        <th>Jurusan</th>
                                        <th>Wali Kelas</th>
                                        <th>Kapasitas</th>
                                        <th>Siswa</th>
                                        <th>Ruangan</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kelas as $item)
                                        <tr>
                                            <td class="text-center">
                                                <button
                                                    class="btn btn-sm btn-secondary">{{ $loop->iteration + ($kelas->currentPage() - 1) * $kelas->perPage() }}</button>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $item->nama_kelas }}</div>
                                                @if ($item->keterangan)
                                                    <small
                                                        class="text-muted">{{ Str::limit($item->keterangan, 30) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">
                                                    {{ $item->tingkat }}
                                                </button>
                                            </td>
                                            <td>
                                                @if ($item->jurusan_nama)
                                                    <button class="btn btn-sm btn-info">
                                                        {{ $item->jurusan_nama }}
                                                    </button>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $item->wali_kelas ?: '-' }}</div>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-{{ $item->jumlah_siswa >= $item->kapasitas ? 'danger' : ($item->jumlah_siswa >= $item->kapasitas * 0.8 ? 'warning' : 'success') }}"
                                                        role="progressbar"
                                                        style="width: {{ ($item->jumlah_siswa / $item->kapasitas) * 100 }}%">
                                                        {{ $item->jumlah_siswa }}/{{ $item->kapasitas }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $item->jumlah_siswa }}</div>
                                                <small class="text-muted">siswa</small>
                                            </td>
                                            <td>
                                                @if ($item->ruangan)
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-door-open me-1"></i>{{ $item->ruangan }}
                                                    </button>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button
                                                    class="btn btn-sm btn-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                    {{ $item->status }}
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ route($userRole . '.kelas.show', $item->id) }}"
                                                        class="btn btn-sm btn-info" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route($userRole . '.kelas.edit', $item->id) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route($userRole . '.kelas.destroy', $item->id) }}"
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
                                            <td colspan="10" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                                    <h5>Tidak ada data kelas</h5>
                                                    <p>Belum ada data kelas yang tersedia</p>
                                                    <a href="{{ route($userRole . '.kelas.create') }}"
                                                        class="btn btn-primary">
                                                        <i class="fas fa-plus me-2"></i>Tambah Kelas
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
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
                                                {{-- Previous Page Link --}}
                                                @if ($kelas->onFirstPage())
                                                    <li class="page-item disabled">
                                                        <span class="page-link">
                                                            <i class="fas fa-chevron-left"></i>
                                                        </span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $kelas->previousPageUrl() }}"
                                                            rel="prev">
                                                            <i class="fas fa-chevron-left"></i>
                                                        </a>
                                                    </li>
                                                @endif

                                                {{-- Pagination Elements --}}
                                                @foreach ($kelas->links()->elements as $element)
                                                    {{-- "Three Dots" Separator --}}
                                                    @if (is_string($element))
                                                        <li class="page-item disabled"><span
                                                                class="page-link">{{ $element }}</span></li>
                                                    @endif

                                                    {{-- Array Of Links --}}
                                                    @if (is_array($element))
                                                        @foreach ($element as $page => $url)
                                                            @if ($page == $kelas->currentPage())
                                                                <li class="page-item active" aria-current="page">
                                                                    <span class="page-link">{{ $page }}</span>
                                                                </li>
                                                            @else
                                                                <li class="page-item">
                                                                    <a class="page-link"
                                                                        href="{{ $url }}">{{ $page }}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach

                                                {{-- Next Page Link --}}
                                                @if ($kelas->hasMorePages())
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $kelas->nextPageUrl() }}"
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
