@extends('layouts.app')

@section('titlepage', 'Form Tambah Jurusan')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Tambah Jurusan Baru</h1>
                        <p class="text-muted mb-0">Masukkan data jurusan baru ke sistem</p>
                    </div>
                    <div>
                        <a href="{{ route($userRole . '.jurusan.index') }}" class="btn btn-sm btn-outline-secondary">
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
                        <form action="{{ route($userRole . '.jurusan.store') }}" method="POST" autocomplete="off">
                            @csrf

                            <!-- Jurusan Information Section -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-wrapper bg-primary text-white me-3">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">Informasi Jurusan</h5>
                                            <small class="text-muted">Data dasar jurusan</small>
                                        </div>
                                    </div>
                                    <hr class="my-3">
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Nama Jurusan <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="nama_jurusan" class="form-control form-control-sm"
                                            placeholder="Contoh: Ilmu Pengetahuan Alam" value="{{ old('nama_jurusan') }}"
                                            required>
                                        @error('nama_jurusan')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Singkatan <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="singkatan" class="form-control form-control-sm"
                                            placeholder="Contoh: IPA" value="{{ old('singkatan') }}" required>
                                        <small class="text-muted">Singkatan unik untuk jurusan</small>
                                        @error('singkatan')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Jenis Jurusan <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select select2" name="jenis" required>
                                            <option value="">Pilih Jenis</option>
                                            <option value="Akademik" {{ old('jenis') == 'Akademik' ? 'selected' : '' }}>
                                                <i class="fas fa-university me-1"></i>Akademik
                                            </option>
                                            <option value="Vokasi" {{ old('jenis') == 'Vokasi' ? 'selected' : '' }}>
                                                <i class="fas fa-tools me-1"></i>Vokasi
                                            </option>
                                        </select>
                                        @error('jenis')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Kepala Jurusan</label>
                                        <input type="text" name="kepala_jurusan" class="form-control form-control-sm"
                                            placeholder="Nama kepala jurusan" value="{{ old('kepala_jurusan') }}">
                                        <small class="text-muted">Opsional: nama guru yang mengepalai jurusan</small>
                                        @error('kepala_jurusan')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Status <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select select2" name="status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>
                                                Aktif</option>
                                            <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>
                                                Tidak Aktif</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Description Section -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-wrapper bg-success text-white me-3">
                                            <i class="fas fa-info-circle"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">Deskripsi Jurusan</h5>
                                            <small class="text-muted">Informasi detail tentang jurusan</small>
                                        </div>
                                    </div>
                                    <hr class="my-3">
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Deskripsi</label>
                                        <textarea name="deskripsi" class="form-control form-control-sm" rows="4"
                                            placeholder="Deskripsi lengkap tentang jurusan, visi, misi, dan tujuan">{{ old('deskripsi') }}</textarea>
                                        <small class="text-muted">Opsional: tambahkan deskripsi detail tentang
                                            jurusan</small>
                                        @error('deskripsi')
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
                                            <a href="{{ route($userRole . '.jurusan.index') }}"
                                                class="btn btn-outline-secondary me-2">
                                                <i class="fas fa-times me-2"></i>Batal
                                            </a>
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="fas fa-save me-2"></i>Simpan Data Jurusan
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
@endsection
