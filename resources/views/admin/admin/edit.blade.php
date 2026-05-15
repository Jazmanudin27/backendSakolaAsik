@extends('layouts.app')

@section('titlepage', 'Form Edit Admin')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Edit Data Admin</h1>
                    <p class="text-muted mb-0">Perbarui data admin yang ada</p>
                </div>
                <div>
                    <a href="{{ route($userRole . '.admin.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route($userRole . '.admin.update', $admin->id) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        
                        <!-- Personal Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-primary text-white me-3">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Informasi Admin</h5>
                                        <small class="text-muted">Data identitas admin</small>
                                    </div>
                                </div>
                                <hr class="my-3">
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control form-control-sm" placeholder="Masukkan nama lengkap admin"
                                            value="{{ old('name', $admin->name) }}" required>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control form-control-sm" placeholder="email@example.com"
                                            value="{{ old('email', $admin->email) }}" required>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Password</label>
                                    <input type="password" name="password" class="form-control form-control-sm" placeholder="Minimal 6 karakter">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Sekolah</label>
                                    <select class="form-select select2" name="id_sekolah">
                                        <option value="">Pilih Sekolah (Opsional)</option>
                                        @if(isset($sekolah))
                                            @foreach($sekolah as $skl)
                                                <option value="{{ $skl->kode_sekolah }}" {{ old('id_sekolah', $admin->id_sekolah) == $skl->kode_sekolah ? 'selected' : '' }}>
                                                    {{ $skl->nama_sekolah }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="text-muted">Kosongkan untuk Super Admin</small>
                                    @error('id_sekolah')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <div>
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Field dengan tanda <span class="text-danger">*</span> wajib diisi
                                        </small>
                                    </div>
                                    <div>
                                        <a href="{{ route($userRole . '.admin.index') }}" class="btn btn-outline-secondary me-2">
                                            <i class="fas fa-times me-2"></i>Batal
                                        </a>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-save me-2"></i>Update Data Admin
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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

.form-control:focus, .form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.form-label {
    color: #495057;
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
