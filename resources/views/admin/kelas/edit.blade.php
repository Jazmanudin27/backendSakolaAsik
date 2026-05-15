@extends('layouts.app')

@section('titlepage', 'Form Edit Kelas')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Edit Data Kelas</h1>
                        <p class="text-muted mb-0">Perbarui informasi data kelas</p>
                    </div>
                    <div>
                        <a href="{{ route($userRole . '.kelas.index') }}" class="btn btn-outline-secondary">
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
                        <form action="{{ route($userRole . '.kelas.update', $kelas->id) }}" method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <!-- Kelas Information Section -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-wrapper bg-primary text-white me-3">
                                            <i class="fas fa-door-open"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">Informasi Kelas</h5>
                                            <small class="text-muted">Data dasar kelas</small>
                                        </div>
                                    </div>
                                    <hr class="my-3">
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Nama Kelas <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="nama_kelas" class="form-control form-control-sm"
                                                placeholder="Contoh: XII-IPA-1"
                                                value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
                                        @error('nama_kelas')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Tingkat <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select select2" name="tingkat" required>
                                            <option value="">Pilih Tingkat</option>
                                            <option value="1"
                                                {{ old('tingkat', $kelas->tingkat) == '1' ? 'selected' : '' }}>1
                                            </option>
                                            <option value="2"
                                                {{ old('tingkat', $kelas->tingkat) == '2' ? 'selected' : '' }}>2
                                            </option>
                                            <option value="3"
                                                {{ old('tingkat', $kelas->tingkat) == '3' ? 'selected' : '' }}>3
                                            </option>
                                        </select>
                                        @error('tingkat')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Jurusan</label>
                                        <input type="text" name="jurusan" class="form-control form-control-sm"
                                                placeholder="Contoh: IPA, IPS, TKJ"
                                                value="{{ old('jurusan', $kelas->jurusan) }}">
                                        @error('jurusan')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Wali Kelas</label>
                                        <input type="text" name="wali_kelas" class="form-control form-control-sm"
                                                placeholder="Nama wali kelas"
                                                value="{{ old('wali_kelas', $kelas->wali_kelas) }}">
                                        @error('wali_kelas')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Ruangan</label>
                                        <input type="text" name="ruangan" class="form-control form-control-sm"
                                                placeholder="Contoh: A101, B201"
                                                value="{{ old('ruangan', $kelas->ruangan) }}">
                                        @error('ruangan')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Status <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select select2" name="status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="Aktif"
                                                {{ old('status', $kelas->status) == 'Aktif' ? 'selected' : '' }}>Aktif
                                            </option>
                                            <option value="Tidak Aktif"
                                                {{ old('status', $kelas->status) == 'Tidak Aktif' ? 'selected' : '' }}>
                                                Tidak Aktif</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Capacity Section -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-wrapper bg-success text-white me-3">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">Kapasitas & Jumlah Siswa</h5>
                                            <small class="text-muted">Informasi kapasitas dan jumlah siswa</small>
                                        </div>
                                    </div>
                                    <hr class="my-3">
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Kapasitas Maksimal <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="kapasitas" class="form-control form-control-sm" placeholder="36"
                                                value="{{ old('kapasitas', $kelas->kapasitas) }}" min="1"
                                                max="100" required>
                                        @error('kapasitas')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Jumlah Siswa Saat Ini <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="jumlah_siswa" class="form-control form-control-sm"
                                                placeholder="0" value="{{ old('jumlah_siswa', $kelas->jumlah_siswa) }}"
                                                min="0" max="100" required>
                                        @error('jumlah_siswa')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information Section -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-wrapper bg-info text-white me-3">
                                            <i class="fas fa-info-circle"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">Informasi Tambahan</h5>
                                            <small class="text-muted">Keterangan dan informasi lainnya</small>
                                        </div>
                                    </div>
                                    <hr class="my-3">
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Keterangan</label>
                                        <textarea name="keterangan" class="form-control form-control-sm" rows="3" placeholder="Keterangan tambahan tentang kelas">{{ old('keterangan', $kelas->keterangan) }}</textarea>
                                        <small class="text-muted">Opsional: tambahkan keterangan untuk kelas ini</small>
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
                                            <a href="{{ route($userRole . '.kelas.index') }}"
                                                class="btn btn-outline-secondary me-2">
                                                <i class="fas fa-times me-2"></i>Batal
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-2"></i>Update Data Kelas
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
