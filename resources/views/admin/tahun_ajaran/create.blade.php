@extends('layouts.app')

@section('titlepage', 'Tambah Tahun Ajaran')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Tambah Tahun Ajaran</h1>
                    <p class="text-muted mb-0">Masukkan data tahun ajaran baru</p>
                </div>
                <div>
                    <a href="{{ route($userRole . '.tahun_ajaran.index') }}" class="btn btn-sm btn-outline-secondary">
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
                    <form action="{{ route($userRole . '.tahun_ajaran.store') }}" method="POST" autocomplete="off">
                        @csrf
                        
                        <!-- Form Fields -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
                                    <input type="text" name="tahun_ajaran" class="form-control form-control-sm" 
                                           placeholder="Contoh: 2024/2025" value="{{ old('tahun_ajaran') }}" required>
                                    @error('tahun_ajaran')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="semester" required>
                                        <option value="">Pilih Semester</option>
                                        <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                        <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                                    </select>
                                    @error('semester')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_mulai" class="form-control form-control-sm" 
                                           value="{{ old('tanggal_mulai') }}" required>
                                    @error('tanggal_mulai')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tanggal Selesai <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_selesai" class="form-control form-control-sm" 
                                           value="{{ old('tanggal_selesai') }}" required>
                                    <small class="text-muted">Tanggal selesai harus setelah tanggal mulai</small>
                                    @error('tanggal_selesai')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Keterangan</label>
                                    <textarea name="keterangan" class="form-control form-control-sm" rows="3" 
                                              placeholder="Keterangan tambahan">{{ old('keterangan') }}</textarea>
                                    <small class="text-muted">Opsional: tambahkan keterangan untuk tahun ajaran ini</small>
                                    @error('keterangan')
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
                                        <a href="{{ route($userRole . '.tahun_ajaran.index') }}" class="btn btn-outline-secondary me-2">
                                            <i class="fas fa-times me-2"></i>Batal
                                        </a>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-save me-2"></i>Simpan Tahun Ajaran
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
.input-group-text {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #6c757d;
}

.form-control:focus, .form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.form-label {
    color: #495057;
    font-weight: 500;
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
    border-radius: 0.5rem;
    font-weight: 500;
}
</style>
@endsection
