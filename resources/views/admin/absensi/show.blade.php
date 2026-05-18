@extends('layouts.app')

@section('titlepage', 'Detail Absensi')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Detail Absensi</h1>
                    <p class="text-muted mb-0">Informasi lengkap data absensi siswa</p>
                </div>
                <div>
                    <a href="{{ route($userRole . '.absensi.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route($userRole . '.absensi.edit', $absensi->id) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Section -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <!-- Student Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-primary text-white me-3">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">Informasi Siswa</h5>
                                    <small class="text-muted">Data siswa yang diabsen</small>
                                </div>
                            </div>
                            <hr class="my-3">
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Nama Siswa</label>
                                <div class="fw-semibold fs-5">{{ $absensi->siswa->nama_siswa ?? '-' }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">NISN</label>
                                <div class="fw-semibold"><code>{{ $absensi->siswa->nisn ?? '-' }}</code></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">NIS</label>
                                <div class="fw-semibold"><code>{{ $absensi->siswa->nis ?? '-' }}</code></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Kelas</label>
                                <div class="fw-semibold">
                                    <button class="btn btn-sm btn-light text-dark">{{ $absensi->siswa->kelas->nama_kelas ?? '-' }}</button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">Jenis Kelamin</label>
                                <div class="fw-semibold">{{ $absensi->siswa->jk ?? '-' }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">Username</label>
                                <div class="fw-semibold">{{ $absensi->siswa->username ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-success text-white me-3">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">Informasi Absensi</h5>
                                    <small class="text-muted">Data kehadiran</small>
                                </div>
                            </div>
                            <hr class="my-3">
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Tanggal Absensi</label>
                                <div class="fw-semibold fs-5">{{ \Carbon\Carbon::parse($absensi->tanggal_absensi)->format('d F Y') }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">Status Kehadiran</label>
                                <div class="fw-semibold">
                                    @if($absensi->status == 'Hadir')
                                        <button class="btn btn-sm btn-success">Hadir</button>
                                    @elseif($absensi->status == 'Sakit')
                                        <button class="btn btn-sm btn-warning">Sakit</button>
                                    @elseif($absensi->status == 'Izin')
                                        <button class="btn btn-sm btn-info">Izin</button>
                                    @else
                                        <button class="btn btn-sm btn-danger">Alpha</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Keterangan</label>
                                <div class="fw-semibold">
                                    @if ($absensi->keterangan)
                                        {{ $absensi->keterangan }}
                                    @else
                                        <span class="text-muted">Tidak ada keterangan</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">Sekolah</label>
                                <div class="fw-semibold">{{ $absensi->sekolah->nama_sekolah ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Timestamp Information -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-info text-white me-3">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">Informasi Waktu</h5>
                                    <small class="text-muted">Timestamp data</small>
                                </div>
                            </div>
                            <hr class="my-3">
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Dibuat Pada</label>
                                <div class="fw-semibold">{{ $absensi->created_at->format('d F Y H:i:s') }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Diperbarui Pada</label>
                                <div class="fw-semibold">{{ $absensi->updated_at->format('d F Y H:i:s') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        ID Absensi: #{{ $absensi->id }}
                                    </small>
                                </div>
                                <div>
                                    <a href="{{ route($userRole . '.absensi.index') }}" class="btn btn-outline-secondary me-2">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali
                                    </a>
                                    <a href="{{ route($userRole . '.absensi.edit', $absensi->id) }}" class="btn btn-warning me-2">
                                        <i class="fas fa-edit me-2"></i>Edit
                                    </a>
                                    <form action="{{ route($userRole . '.absensi.destroy', $absensi->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete" data-href="{{ route($userRole . '.absensi.destroy', $absensi->id) }}">
                                            <i class="fas fa-trash me-2"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-wrapper {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.form-label {
    color: #6c757d;
    font-weight: 500;
}

hr {
    border-color: #e9ecef;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transition: box-shadow 0.15s ease-in-out;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.btn {
    border-radius: 0.375rem;
    font-weight: 500;
}
</style>
@endsection
