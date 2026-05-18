@extends('layouts.app')

@section('titlepage', 'Form Tambah Absensi')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Tambah Absensi Baru</h1>
                    <p class="text-muted mb-0">Masukkan data absensi siswa</p>
                </div>
                <div>
                    <a href="{{ route($userRole . '.absensi.index') }}" class="btn btn-sm btn-outline-secondary">
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
                    <form action="{{ route($userRole . '.absensi.store') }}" method="POST" autocomplete="off">
                        @csrf
                        
                        <!-- Attendance Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-primary text-white me-3">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Informasi Absensi</h5>
                                        <small class="text-muted">Data kehadiran siswa</small>
                                    </div>
                                </div>
                                <hr class="my-3">
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Siswa <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="kode_siswa" required>
                                        <option value="">Pilih Siswa</option>
                                        @if(isset($siswa))
                                            @foreach($siswa as $sw)
                                                <option value="{{ $sw->kode_siswa }}" {{ old('kode_siswa') == $sw->kode_siswa ? 'selected' : '' }}>
                                                    {{ $sw->nama_siswa }} - {{ $sw->nisn }} ({{ $sw->kelas->nama_kelas ?? '-' }})
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('kode_siswa')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tanggal Absensi <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_absensi" class="form-control form-control-sm"
                                       value="{{ old('tanggal_absensi') ?? date('Y-m-d') }}" required>
                                    @error('tanggal_absensi')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Status Kehadiran <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="Hadir" {{ old('status') == 'Hadir' ? 'selected' : '' }}>
                                            <i class="fas fa-user-check me-1"></i>Hadir
                                        </option>
                                        <option value="Sakit" {{ old('status') == 'Sakit' ? 'selected' : '' }}>
                                            <i class="fas fa-procedures me-1"></i>Sakit
                                        </option>
                                        <option value="Izin" {{ old('status') == 'Izin' ? 'selected' : '' }}>
                                            <i class="fas fa-user-clock me-1"></i>Izin
                                        </option>
                                        <option value="Alpha" {{ old('status') == 'Alpha' ? 'selected' : '' }}>
                                            <i class="fas fa-user-times me-1"></i>Alpha
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Keterangan</label>
                                    <textarea name="keterangan" class="form-control form-control-sm" rows="3" placeholder="Tambahkan keterangan jika diperlukan">{{ old('keterangan') }}</textarea>
                                    <small class="text-muted">Opsional</small>
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
                                        <a href="{{ route($userRole . '.absensi.index') }}" class="btn btn-outline-secondary me-2">
                                            <i class="fas fa-times me-2"></i>Batal
                                        </a>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-save me-2"></i>Simpan Absensi
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
