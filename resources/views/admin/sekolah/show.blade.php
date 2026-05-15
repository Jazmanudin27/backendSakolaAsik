@extends('layouts.app')

@section('titlepage', 'Detail Sekolah')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Detail Sekolah</h1>
                    <p class="text-muted mb-0">Informasi lengkap data sekolah</p>
                </div>
                <div>
                    <a href="{{ route($userRole . '.sekolah.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Section -->
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="avatar avatar-xl mb-3">
                        <div class="avatar-title rounded-circle bg-primary text-white" style="width: 100px; height: 100px; font-size: 2.5rem;">
                            <i class="fas fa-school"></i>
                        </div>
                    </div>
                    <h4 class="mb-1">{{ $sekolah->nama_sekolah }}</h4>
                    <p class="text-muted mb-3">{{ $sekolah->npsn }}</p>
                    <span class="badge bg-{{ $sekolah->status == 'Aktif' ? 'success' : 'secondary' }}">
                        {{ $sekolah->status }}
                    </span>
                    <div class="mt-4">
                        <a href="{{ route($userRole . '.sekolah.edit', $sekolah->kode_sekolah) }}" class="btn btn-sm btn-primary me-2">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Informasi Sekolah</h5>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted fw-semibold">Nama Sekolah</label>
                        </div>
                        <div class="col-md-8">
                            <span>{{ $sekolah->nama_sekolah }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted fw-semibold">Kode Sekolah</label>
                        </div>
                        <div class="col-md-8">
                            <code>{{ $sekolah->kode_sekolah }}</code>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted fw-semibold">NPSN</label>
                        </div>
                        <div class="col-md-8">
                            <code>{{ $sekolah->npsn }}</code>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted fw-semibold">Kepala Sekolah</label>
                        </div>
                        <div class="col-md-8">
                            <span>{{ $sekolah->kepala_sekolah }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted fw-semibold">Jenjang</label>
                        </div>
                        <div class="col-md-8">
                            <span class="badge bg-info">{{ $sekolah->jenjang }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted fw-semibold">Status</label>
                        </div>
                        <div class="col-md-8">
                            <span class="badge bg-{{ $sekolah->status == 'Aktif' ? 'success' : 'secondary' }}">
                                {{ $sekolah->status }}
                            </span>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">Alamat & Lokasi</h6>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted fw-semibold">Alamat</label>
                        </div>
                        <div class="col-md-8">
                            <span>{{ $sekolah->alamat }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted fw-semibold">Kabupaten/Kota</label>
                        </div>
                        <div class="col-md-8">
                            <span>{{ $sekolah->kabupaten_kota }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted fw-semibold">Provinsi</label>
                        </div>
                        <div class="col-md-8">
                            <span>{{ $sekolah->provinsi }}</span>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">Kontak</h6>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted fw-semibold">No. Telepon</label>
                        </div>
                        <div class="col-md-8">
                            <span>{{ $sekolah->no_telp }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted fw-semibold">Email</label>
                        </div>
                        <div class="col-md-8">
                            <a href="mailto:{{ $sekolah->email }}">{{ $sekolah->email }}</a>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted fw-semibold">Website</label>
                        </div>
                        <div class="col-md-8">
                            @if($sekolah->website)
                                <a href="{{ $sekolah->website }}" target="_blank">{{ $sekolah->website }}</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-1"></i>
                                Dibuat: {{ $sekolah->created_at->format('d M Y H:i') }}
                            </small>
                        </div>
                        <div>
                            <small class="text-muted">
                                <i class="fas fa-edit me-1"></i>
                                Diperbarui: {{ $sekolah->updated_at->format('d M Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
