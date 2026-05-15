@extends('layouts.app')

@section('titlepage', 'Detail Admin')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Detail Admin</h1>
                    <p class="text-muted mb-0">Informasi lengkap data admin</p>
                </div>
                <div>
                    <a href="{{ route($userRole . '.admin.index') }}" class="btn btn-sm btn-outline-secondary">
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
                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                        </div>
                    </div>
                    <h4 class="mb-1">{{ $admin->name }}</h4>
                    <p class="text-muted mb-3">{{ $admin->email }}</p>
                    @if ($admin->sekolah)
                        <span class="badge bg-success">Admin Sekolah</span>
                    @else
                        <span class="badge bg-warning">Super Admin</span>
                    @endif
                    <div class="mt-4">
                        <a href="{{ route($userRole . '.admin.edit', $admin->id) }}" class="btn btn-sm btn-primary me-2">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Informasi Admin</h5>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted fw-semibold">Nama Lengkap</label>
                        </div>
                        <div class="col-md-8">
                            <span>{{ $admin->name }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted fw-semibold">Email</label>
                        </div>
                        <div class="col-md-8">
                            <span>{{ $admin->email }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted fw-semibold">Role</label>
                        </div>
                        <div class="col-md-8">
                            @if ($admin->sekolah)
                                <span class="badge bg-success">Admin Sekolah</span>
                            @else
                                <span class="badge bg-warning">Super Admin</span>
                            @endif
                        </div>
                    </div>

                    @if ($admin->sekolah)
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted fw-semibold">Sekolah</label>
                        </div>
                        <div class="col-md-8">
                            <span>{{ $admin->sekolah->nama_sekolah }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted fw-semibold">ID Admin</label>
                        </div>
                        <div class="col-md-8">
                            <code>{{ $admin->id }}</code>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-1"></i>
                                Dibuat: {{ $admin->created_at->format('d M Y H:i') }}
                            </small>
                        </div>
                        <div>
                            <small class="text-muted">
                                <i class="fas fa-edit me-1"></i>
                                Diperbarui: {{ $admin->updated_at->format('d M Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
