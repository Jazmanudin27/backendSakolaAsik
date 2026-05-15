@extends('layouts.app')

@section('titlepage', 'Detail Siswa')

@section('content')
<div class="container-fluid p-0">
    <!-- Header with Background -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white border-0">
                <div class="card-body pb-4">
                    <div class="d-uatkan soal ujian siswa? buflex justify-content-between align-items-center mb-1">
                        <div>
                            <h1 class="h3 mb-1">Detail Siswa</h1>
                            <p class="mb-0 opacity-75">Informasi lengkap data siswa</p>
                        </div>
                        <div>
                            <a href="{{ route($userRole . '.siswa.index') }}"
                                class="btn btn-outline-light me-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <a href="{{ route($userRole . '.siswa.edit', $siswa->kode_siswa) }}"
                                class="btn btn-warning me-2">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <form
                                action="{{ route($userRole . '.siswa.destroy', $siswa->kode_siswa) }}"
                                method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger delete"
                                    data-href="{{ route($userRole . '.siswa.destroy', $siswa->kode_siswa) }}">
                                    <i class="fas fa-trash me-2"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Card with Overlap -->
    <div class="row mb-4" style="margin-top: -60px;">
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-body pt-4">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <!-- Avatar with Border -->
                            <div class="avatar-wrapper mb-3">
                                <div class="avatar avatar-xl mb-3">
                                    @if($siswa->foto)
                                        <img src="{{ asset('storage/siswa/' . $siswa->foto) }}"
                                            alt="Foto {{ $siswa->nama_siswa }}"
                                            class="rounded-circle border-4 border-white shadow"
                                            style="width: 140px; height: 140px; object-fit: cover;">
                                    @else
                                        <div class="avatar-title rounded-circle bg-white text-primary border-4 border-white shadow"
                                            style="width: 140px; height: 140px; font-size: 3.5rem; font-weight: bold;">
                                            {{ strtoupper(substr($siswa->nama_siswa, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <!-- Status Badge -->

                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <h3 class="mb-0 fw-bold me-3">{{ $siswa->nama_siswa }}</h3>
                                <button
                                    class="btn btn-sm btn-{{ $siswa->status == 'Aktif' ? 'success' : 'secondary' }} rounded-pill">
                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                    {{ $siswa->status }}
                                </button>
                            </div>
                            <p class="text-muted mb-3">
                                <i class="fas fa-user me-3"></i>{{ $siswa->username }}
                            </p>
                            <div class="d-flex justify-content-center gap-2">
                                <button
                                    class="btn btn-sm btn-{{ $siswa->jk == 'Laki-laki' ? 'info' : 'danger' }} rounded-pill">
                                    {{ $siswa->jk == 'Laki-laki' ? 'L' : 'P' }}
                                </button>
                                <button class="btn btn-sm btn-light rounded-pill">
                                    <i class="fas fa-graduation-cap me-1"></i>{{ $siswa->kode_kelas }}
                                </button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-4">
                                        <i class="fas fa-school me-2 text-primary"></i>Informasi Akademik
                                    </h6>
                                    <div class="info-item">
                                        <div class="info-label">NISN</div>
                                        <div class="info-value">
                                            <code
                                                class="bg-light text-dark px-3 py-2 rounded">{{ $siswa->nisn }}</code>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">NIS</div>
                                        <div class="info-value">
                                            <code
                                                class="bg-light text-dark px-3 py-2 rounded">{{ $siswa->nis }}</code>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Kelas</div>
                                        <div class="info-value">
                                            <button
                                                class="btn btn-sm btn-outline-primary">{{ $siswa->kode_kelas }}</button>
                                        </div>
                                    </div>
                                    @if($siswa->sekolah)
                                        <div class="info-item">
                                            <div class="info-label">Sekolah</div>
                                            <div class="info-value">
                                                <span
                                                    class="badge bg-light text-dark px-3 py-2">{{ $siswa->sekolah->nama_sekolah }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-4">
                                        <i class="fas fa-user me-2 text-success"></i>Informasi Pribadi
                                    </h6>
                                    <div class="info-item">
                                        <div class="info-label">Agama</div>
                                        <div class="info-value">{{ $siswa->agama ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Tempat Lahir</div>
                                        <div class="info-value">
                                            {{ $siswa->tempat_lahir ?? '-' }}</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Tanggal Lahir</div>
                                        <div class="info-value">
                                            <i
                                                class="fas fa-calendar me-2 text-muted"></i>{{ $siswa->tgl_lahir->format('d F Y') }}
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Umur</div>
                                        <div class="info-value">
                                            <span
                                                class="badge bg-info rounded-pill px-3 py-2">{{ $siswa->tgl_lahir->age }}
                                                tahun</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Contact and Address Cards -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow h-100 bg-gradient-start">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-wrapper bg-success text-white me-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Kontak</h6>
                            <small class="text-muted">Informasi komunikasi</small>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope text-success"></i>
                        </div>
                        <div class="contact-content">
                            <div class="contact-label">Email</div>
                            @if($siswa->email)
                                <a href="mailto:{{ $siswa->email }}" class="contact-value text-decoration-none">
                                    {{ $siswa->email }}
                                </a>
                            @else
                                <div class="contact-value text-muted">-</div>
                            @endif
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone text-success"></i>
                        </div>
                        <div class="contact-content">
                            <div class="contact-label">No. HP</div>
                            @if($siswa->no_hp)
                                <a href="tel:{{ $siswa->no_hp }}" class="contact-value text-decoration-none">
                                    {{ $siswa->no_hp }}
                                </a>
                            @else
                                <div class="contact-value text-muted">-</div>
                            @endif
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-user text-success"></i>
                        </div>
                        <div class="contact-content">
                            <div class="contact-label">Username</div>
                            <div class="contact-value">@{{ $siswa->username }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow h-100 bg-gradient-end">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-wrapper bg-warning text-white me-3">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Alamat</h6>
                            <small class="text-muted">Lokasi dan demografi</small>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-home text-warning"></i>
                        </div>
                        <div class="contact-content">
                            <div class="contact-label">Alamat Lengkap</div>
                            <div class="contact-value">{{ $siswa->alamat }}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-map-pin text-warning"></i>
                                </div>
                                <div class="contact-content">
                                    <div class="contact-label">Tempat Lahir</div>
                                    <div class="contact-value">
                                        {{ $siswa->tempat_lahir ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-birthday-cake text-warning"></i>
                                </div>
                                <div class="contact-content">
                                    <div class="contact-label">Tanggal Lahir</div>
                                    <div class="contact-value">
                                        {{ $siswa->tgl_lahir->format('d M Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Statistics Cards -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h6 class="card-title mb-4">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>Statistik & Informasi Tambahan
                    </h6>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="stat-card bg-primary-gradient">
                                <div class="stat-icon">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Identitas</div>
                                    <div class="stat-value">{{ $siswa->nisn }}</div>
                                    <div class="stat-subtitle">NISN</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card bg-info-gradient">
                                <div class="stat-icon">
                                    <i class="fas fa-school"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Akademik</div>
                                    <div class="stat-value">{{ $siswa->kode_kelas }}</div>
                                    <div class="stat-subtitle">Kelas</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card bg-success-gradient">
                                <div class="stat-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Demografi</div>
                                    <div class="stat-value">{{ $siswa->jk }}</div>
                                    <div class="stat-subtitle">Jenis Kelamin</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card bg-warning-gradient">
                                <div class="stat-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Usia</div>
                                    <div class="stat-value">{{ $siswa->tgl_lahir->age }}</div>
                                    <div class="stat-subtitle">
                                        {{ $siswa->tgl_lahir->format('Y') }}</div>
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
    .avatar {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        font-size: 1rem;
        font-weight: 500;
    }

    .avatar-sm {
        width: 2rem;
        height: 2rem;
        font-size: 0.75rem;
    }

    .avatar-lg {
        width: 3rem;
        height: 3rem;
        font-size: 1.25rem;
    }

    .avatar-xl {
        width: 6rem;
        height: 6rem;
        font-size: 2rem;
    }

    .avatar-wrapper {
        position: relative;
        display: inline-block;
    }

    .status-badge {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
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

    .info-item {
        margin-bottom: 1.5rem;
    }

    .info-label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
        font-weight: 500;
    }

    .info-value {
        font-weight: 600;
        color: #495057;
    }

    .icon-wrapper {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .contact-item {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .contact-icon {
        width: 2rem;
        height: 2rem;
        border-radius: 0.375rem;
        background-color: rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .contact-content {
        flex: 1;
    }

    .contact-label {
        font-size: 0.75rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }

    .contact-value {
        font-weight: 600;
        color: #495057;
    }

    .stat-card {
        padding: 1.5rem;
        border-radius: 0.75rem;
        color: white;
        position: relative;
        overflow: hidden;
        transition: all 0.15s ease-in-out;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
    }

    .stat-icon {
        font-size: 2rem;
        opacity: 0.8;
        margin-bottom: 1rem;
    }

    .stat-label {
        font-size: 0.75rem;
        opacity: 0.8;
        margin-bottom: 0.25rem;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stat-subtitle {
        font-size: 0.875rem;
        opacity: 0.8;
    }

    .bg-primary-gradient {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }

    .bg-info-gradient {
        background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
    }

    .bg-success-gradient {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
    }

    .bg-warning-gradient {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
    }

    .bg-gradient-start {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .bg-gradient-end {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeeba 100%);
    }

    code {
        background-color: #f8f9fa;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
    }

    .btn {
        border-radius: 0.375rem;
        font-weight: 500;
    }

</style>
@endsection
