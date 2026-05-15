@extends('layouts.app')

@section('titlepage', 'Form Tambah Mata Pelajaran')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Tambah Mata Pelajaran Baru</h1>
                    <p class="text-muted mb-0">Masukkan data mata pelajaran baru ke sistem</p>
                </div>
                <div>
                    <a href="{{ route($userRole . '.mapel.index') }}" class="btn btn-outline-secondary">
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
                    <form action="{{ route($userRole . '.mapel.store') }}" method="POST" autocomplete="off">
                        @csrf
                        
                        <!-- Mapel Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-primary text-white me-3">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Informasi Mata Pelajaran</h5>
                                        <small class="text-muted">Data dasar mata pelajaran</small>
                                    </div>
                                </div>
                                <hr class="my-3">
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Kode Mata Pelajaran <span class="text-danger">*</span></label>
                                    <input type="text" name="kode_mapel" class="form-control form-control-sm" placeholder="Contoh: MTK001"
                                            value="{{ old('kode_mapel') }}" required>
                                    @error('kode_mapel')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_mapel" class="form-control form-control-sm" placeholder="Contoh: Matematika"
                                            value="{{ old('nama_mapel') }}" required>
                                    @error('nama_mapel')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Singkatan</label>
                                    <input type="text" name="singkatan" class="form-control form-control-sm" placeholder="Contoh: MTK"
                                           value="{{ old('singkatan') }}">
                                    <small class="text-muted">Opsional: singkatan untuk mata pelajaran</small>
                                    @error('singkatan')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Kelompok <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="kelompok" required>
                                        <option value="">Pilih Kelompok</option>
                                        <option value="A" {{ old('kelompok') == 'A' ? 'selected' : '' }}>Kelompok A</option>
                                        <option value="B" {{ old('kelompok') == 'B' ? 'selected' : '' }}>Kelompok B</option>
                                        <option value="C" {{ old('kelompok') == 'C' ? 'selected' : '' }}>Kelompok C</option>
                                        <option value="Muatan Lokal" {{ old('kelompok') == 'Muatan Lokal' ? 'selected' : '' }}>Muatan Lokal</option>
                                        <option value="Peminatan" {{ old('kelompok') == 'Peminatan' ? 'selected' : '' }}>Peminatan</option>
                                    </select>
                                    @error('kelompok')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Jenis <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="jenis" required>
                                        <option value="">Pilih Jenis</option>
                                        <option value="Wajib" {{ old('jenis') == 'Wajib' ? 'selected' : '' }}>Wajib</option>
                                        <option value="Pilihan" {{ old('jenis') == 'Pilihan' ? 'selected' : '' }}>Pilihan</option>
                                    </select>
                                    @error('jenis')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Jam Per Minggu <span class="text-danger">*</span></label>
                                    <input type="number" name="jam_per_minggu" class="form-control form-control-sm" placeholder="4"
                                           value="{{ old('jam_per_minggu', 4) }}" min="1" max="40" required>
                                    @error('jam_per_minggu')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-success text-white me-3">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Informasi Tambahan</h5>
                                        <small class="text-muted">Deskripsi dan status mata pelajaran</small>
                                    </div>
                                </div>
                                <hr class="my-3">
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control form-control-sm" rows="4" placeholder="Deskripsi lengkap tentang mata pelajaran">{{ old('deskripsi') }}</textarea>
                                    <small class="text-muted">Opsional: tambahkan deskripsi detail tentang mata pelajaran</small>
                                    @error('deskripsi')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
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
                                        <a href="{{ route($userRole . '.mapel.index') }}" class="btn btn-sm btn-outline-secondary me-2">
                                            <i class="fas fa-times me-2"></i>Batal
                                        </a>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-save me-2"></i>Simpan Data Mata Pelajaran
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
    border-radius: 0.5rem;
    font-weight: 500;
}
</style>
@endsection
