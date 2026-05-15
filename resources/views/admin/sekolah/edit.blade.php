@extends('layouts.app')

@section('titlepage', 'Form Edit Sekolah')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Edit Data Sekolah</h1>
                    <p class="text-muted mb-0">Perbarui data sekolah yang ada</p>
                </div>
                <div>
                    <a href="{{ route($userRole . '.sekolah.index') }}" class="btn btn-sm btn-outline-secondary">
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
                    <form action="{{ route($userRole . '.sekolah.update', $sekolah->kode_sekolah) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        
                        <!-- Informasi Dasar -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-primary text-white me-3">
                                        <i class="fas fa-school"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Informasi Dasar Sekolah</h5>
                                        <small class="text-muted">Data identitas sekolah</small>
                                    </div>
                                </div>
                                <hr class="my-3">
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nama Sekolah <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_sekolah" class="form-control form-control-sm" placeholder="Masukkan nama sekolah"
                                            value="{{ old('nama_sekolah', $sekolah->nama_sekolah) }}" required>
                                    @error('nama_sekolah')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">NPSN <span class="text-danger">*</span></label>
                                    <input type="text" name="npsn" class="form-control form-control-sm" placeholder="Nomor Pokok Sekolah Nasional"
                                            value="{{ old('npsn', $sekolah->npsn) }}" required>
                                    @error('npsn')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Kepala Sekolah <span class="text-danger">*</span></label>
                                    <input type="text" name="kepala_sekolah" class="form-control form-control-sm" placeholder="Nama kepala sekolah"
                                            value="{{ old('kepala_sekolah', $sekolah->kepala_sekolah) }}" required>
                                    @error('kepala_sekolah')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Jenjang <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="jenjang" required>
                                        <option value="">Pilih Jenjang</option>
                                        <option value="SD" {{ old('jenjang', $sekolah->jenjang) == 'SD' ? 'selected' : '' }}>SD</option>
                                        <option value="SMP" {{ old('jenjang', $sekolah->jenjang) == 'SMP' ? 'selected' : '' }}>SMP</option>
                                        <option value="SMA" {{ old('jenjang', $sekolah->jenjang) == 'SMA' ? 'selected' : '' }}>SMA</option>
                                        <option value="SMK" {{ old('jenjang', $sekolah->jenjang) == 'SMK' ? 'selected' : '' }}>SMK</option>
                                    </select>
                                    @error('jenjang')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Alamat <span class="text-danger">*</span></label>
                                    <textarea name="alamat" class="form-control form-control-sm" rows="3" placeholder="Alamat lengkap sekolah"
                                        required>{{ old('alamat', $sekolah->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Kabupaten/Kota <span class="text-danger">*</span></label>
                                    <input type="text" name="kabupaten_kota" class="form-control form-control-sm" placeholder="Kabupaten/Kota"
                                            value="{{ old('kabupaten_kota', $sekolah->kabupaten_kota) }}" required>
                                    @error('kabupaten_kota')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Provinsi <span class="text-danger">*</span></label>
                                    <input type="text" name="provinsi" class="form-control form-control-sm" placeholder="Provinsi"
                                            value="{{ old('provinsi', $sekolah->provinsi) }}" required>
                                    @error('provinsi')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="Aktif" {{ old('status', $sekolah->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak Aktif" {{ old('status', $sekolah->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Kontak -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-success text-white me-3">
                                        <i class="fas fa-address-book"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Informasi Kontak</h5>
                                        <small class="text-muted">Data komunikasi sekolah</small>
                                    </div>
                                </div>
                                <hr class="my-3">
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">No. Telepon <span class="text-danger">*</span></label>
                                    <input type="text" name="no_telp" class="form-control form-control-sm" placeholder="08123456789"
                                            value="{{ old('no_telp', $sekolah->no_telp) }}" required>
                                    @error('no_telp')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control form-control-sm" placeholder="email@sekolah.com"
                                            value="{{ old('email', $sekolah->email) }}" required>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Website</label>
                                    <input type="url" name="website" class="form-control form-control-sm" placeholder="https://www.sekolah.com"
                                            value="{{ old('website', $sekolah->website) }}">
                                    @error('website')
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
                                        <a href="{{ route($userRole . '.sekolah.index') }}" class="btn btn-outline-secondary me-2">
                                            <i class="fas fa-times me-2"></i>Batal
                                        </a>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-save me-2"></i>Update Data Sekolah
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
