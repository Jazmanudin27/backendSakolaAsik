@extends('layouts.app')

@section('titlepage', 'Detail Jurusan')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Detail Jurusan</h1>
                <p class="text-muted mb-0">Informasi lengkap data jurusan</p>
            </div>
            <div>
                <a href="{{ route($userRole . '.jurusan.index') }}" class="btn btn-sm btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <a href="{{ route($userRole . '.jurusan.edit', $jurusan->id) }}" class="btn btn-sm btn-warning me-2">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
                <form action="{{ route($userRole . '.jurusan.destroy', $jurusan->id) }}" method="POST"
                    class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger delete">
                        <i class="fas fa-trash me-2"></i>Hapus
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <!-- Left Column - Jurusan Info Card -->
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <!-- Jurusan Header -->
                        <div class="text-center mb-4">
                            <div class="avatar-wrapper mb-3">
                                <div class="avatar-title rounded-circle bg-primary text-white shadow"
                                    style="width: 80px; height: 80px; font-size: 2rem; font-weight: bold; display: flex; align-items: center; justify-content: center;">
                                    {{ strtoupper(substr($jurusan->singkatan, 0, 1)) }}
                                </div>
                            </div>
                            <h4 class="mb-2 fw-bold">{{ $jurusan->nama_jurusan }}</h4>
                            <p class="text-muted mb-3">
                                <i class="fas fa-tag me-2"></i>{{ $jurusan->singkatan }}
                            </p>
                            <div class="d-flex justify-content-center gap-2 mb-3">
                                <button
                                    class="btn btn-sm btn-{{ $jurusan->jenis == 'Akademik' ? 'success' : 'info' }} rounded-pill">
                                    @if ($jurusan->jenis == 'Akademik')
                                        <i class="fas fa-university me-1"></i>
                                    @else
                                        <i class="fas fa-tools me-1"></i>
                                    @endif
                                    {{ $jurusan->jenis }}
                                </button>
                                <button
                                    class="btn btn-sm btn-{{ $jurusan->status == 'Aktif' ? 'success' : 'secondary' }} rounded-pill">
                                    {{ $jurusan->status }}
                                </button>
                            </div>
                        </div>

                        <!-- Statistics -->
                        <div class="row text-center mb-3">
                            <div class="col-6">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-door-open me-2 text-primary"></i>Total Kelas
                                </h6>
                                <h4 class="mb-0 fw-bold">{{ $jurusan->kelas->count() }}</h4>
                            </div>
                            <div class="col-6">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-edit-3 me-2 text-info"></i>Total Soal
                                </h6>
                                <h4 class="mb-0 fw-bold">{{ $jurusan->soalUjians->count() }}</h4>
                            </div>
                        </div>

                        @if ($jurusan->kepala_jurusan)
                            <div class="text-center">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-user-tie me-2 text-warning"></i>Kepala Jurusan
                                </h6>
                                <h5 class="mb-0 fw-bold">{{ $jurusan->kepala_jurusan }}</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Details -->
            <div class="col-md-8 mb-4">
                <!-- Jurusan Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4">Informasi Jurusan</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Nama Jurusan</label>
                                    <div class="fw-semibold">{{ $jurusan->nama_jurusan }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Singkatan</label>
                                    <div class="fw-semibold">{{ $jurusan->singkatan }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Jenis</label>
                                    <div class="fw-semibold">{{ $jurusan->jenis }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Kepala Jurusan</label>
                                    <div class="fw-semibold">{{ $jurusan->kepala_jurusan ?: '-' }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Status</label>
                                    <button
                                        class="btn btn-sm btn-{{ $jurusan->status == 'Aktif' ? 'success' : 'secondary' }} rounded-pill">
                                        {{ $jurusan->status }}
                                    </button>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Tanggal Dibuat</label>
                                    <div class="fw-semibold">{{ $jurusan->created_at->format('d F Y') }}</div>
                                </div>
                            </div>
                        </div>

                        @if ($jurusan->keterangan)
                            <div class="mt-3">
                                <label class="text-muted small">Keterangan</label>
                                <div class="fw-semibold">{{ $jurusan->keterangan }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Related Classes -->
                @if ($jurusan->kelas->count() > 0)
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4">Data Kelas</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kelas</th>
                                            <th>Tingkat</th>
                                            <th>Wali Kelas</th>
                                            <th>Jumlah Siswa</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jurusan->kelas->take(5) as $kelas)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="fw-semibold">{{ $kelas->nama_kelas }}</div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary">
                                                        {{ $kelas->tingkat }}
                                                    </button>
                                                </td>
                                                <td>{{ $kelas->wali_kelas ?: '-' }}</td>
                                                <td>{{ $kelas->jumlah_siswa }}</td>
                                                <td>
                                                    <button
                                                        class="btn btn-sm btn-{{ $kelas->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                        {{ $kelas->status }}
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if ($jurusan->kelas->count() > 5)
                                <div class="text-center mt-3">
                                    <a href="{{ route($userRole . '.kelas.index') }}?jurusan={{ $jurusan->id }}"
                                        class="btn btn-outline-primary">
                                        Lihat Semua Kelas ({{ $jurusan->kelas->count() }})
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
        </div>
    </div>
@endsection
