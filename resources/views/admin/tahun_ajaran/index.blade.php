@extends('layouts.app')

@section('titlepage', 'Tahun Ajaran')

@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Tahun Ajaran</h1>
                        <p class="text-muted mb-0">Manajemen tahun ajaran dan semester</p>
                    </div>
                    <div>
                        <a href="{{ route($userRole . '.tahun_ajaran.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Tahun Ajaran
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm bg-gradient-start">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper bg-primary text-white me-3">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Total Tahun Ajaran</h6>
                                <h3 class="mb-0 fw-bold">{{ $tahunAjarans->total() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm bg-gradient-mid">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper bg-success text-white me-3">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Aktif</h6>
                                <h3 class="mb-0 fw-bold">{{ $tahunAjarans->where('status', 'Aktif')->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm bg-gradient-end">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper bg-warning text-white me-3">
                                <i class="fas fa-pause-circle"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Tidak Aktif</h6>
                                <h3 class="mb-0 fw-bold">{{ $tahunAjarans->where('status', 'Tidak Aktif')->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm bg-gradient-end">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper bg-info text-white me-3">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Semester Ganjil</h6>
                                <h3 class="mb-0 fw-bold">{{ $tahunAjarans->where('semester', 'Ganjil')->count() }}</h3>
                            </div>
                        </div>
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
                                        <th>Tahun Ajaran</th>
                                        <th>Semester</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tahunAjarans as $item)
                                        <tr>
                                            <td class="text-center">
                                                <button
                                                    class="btn btn-sm btn-secondary">{{ $loop->iteration + ($tahunAjarans->currentPage() - 1) * $tahunAjarans->perPage() }}</button>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $item->tahun_ajaran }}</div>
                                                <small class="text-muted">{{ $item->keterangan }}</small>
                                            </td>
                                            <td>
                                                <button
                                                    class="btn btn-sm btn-{{ $item->semester == 'Ganjil' ? 'info' : 'warning' }}">
                                                    {{ $item->semester }}
                                                </button>
                                            </td>
                                            <td>{{ $item->tanggal_mulai->format('d M Y') }}</td>
                                            <td>{{ $item->tanggal_selesai->format('d M Y') }}</td>
                                            <td>
                                                <button
                                                    class="btn btn-sm btn-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                    {{ $item->status }}
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ route($userRole . '.tahun_ajaran.show', $item->id) }}"
                                                        class="btn btn-sm btn-info" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route($userRole . '.tahun_ajaran.edit', $item->id) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route($userRole . '.tahun_ajaran.destroy', $item->id) }}"
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
                                            <td colspan="7" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                                    <h5>Tidak ada data tahun ajaran</h5>
                                                    <p>Belum ada data tahun ajaran yang tersedia</p>
                                                    <a href="{{ route($userRole . '.tahun_ajaran.create') }}"
                                                        class="btn btn-primary">
                                                        <i class="fas fa-plus me-2"></i>Tambah Tahun Ajaran
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if ($tahunAjarans->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">
                                    Menampilkan {{ $tahunAjarans->count() }} dari {{ $tahunAjarans->total() }} data
                                </small>
                                {{ $tahunAjarans->links() }}
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
