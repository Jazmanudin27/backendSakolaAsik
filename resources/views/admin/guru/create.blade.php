@extends('layouts.app')

@section('titlepage', 'Form Tambah Guru')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Tambah Guru Baru</h1>
                    <p class="text-muted mb-0">Masukkan data guru baru ke sistem</p>
                </div>
                <div>
                    <a href="{{ route($userRole . '.guru.index') }}" class="btn btn-sm btn-outline-secondary">
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
                    <form action="{{ route($userRole . '.guru.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Personal Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-primary text-white me-3">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Informasi Pribadi</h5>
                                        <small class="text-muted">Data identitas diri guru</small>
                                    </div>
                                </div>
                                <hr class="my-3">
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">NIP <span class="text-danger">*</span></label>
                                    <input type="text" name="nip" class="form-control form-control-sm" placeholder="Nomor Induk Pegawai"
                                            value="{{ old('nip') }}" required>
                                    @error('nip')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_guru" class="form-control form-control-sm" placeholder="Masukkan nama lengkap guru"
                                            value="{{ old('nama_guru') }}" required>
                                    @error('nama_guru')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="jk" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ old('jk') == 'Laki-laki' ? 'selected' : '' }}>
                                            <i class="fas fa-mars me-1"></i>Laki-laki
                                        </option>
                                        <option value="Perempuan" {{ old('jk') == 'Perempuan' ? 'selected' : '' }}>
                                            <i class="fas fa-venus me-1"></i>Perempuan
                                        </option>
                                    </select>
                                    @error('jk')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control form-control-sm" placeholder="Kota kelahiran"
                                        value="{{ old('tempat_lahir') }}">
                                    @error('tempat_lahir')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" class="form-control form-control-sm"
                                        value="{{ old('tgl_lahir') }}">
                                    @error('tgl_lahir')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" class="form-control form-control-sm" placeholder="email@example.com"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">No. HP</label>
                                    <input type="text" name="no_hp" class="form-control form-control-sm" placeholder="08123456789"
                                        value="{{ old('no_hp') }}">
                                    @error('no_hp')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Foto Profil</label>
                                    <input type="file" name="foto" class="form-control form-control-sm" accept="image/*">
                                    <small class="text-muted">Format: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                                    @error('foto')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Professional Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-success text-white me-3">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Informasi Profesional</h5>
                                        <small class="text-muted">Data pekerjaan dan pendidikan</small>
                                    </div>
                                </div>
                                <hr class="my-3">
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Pendidikan Terakhir <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="pendidikan_terakhir" required>
                                        <option value="">Pilih Pendidikan</option>
                                        <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>S1</option>
                                        <option value="S2" {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}>S2</option>
                                        <option value="S3" {{ old('pendidikan_terakhir') == 'S3' ? 'selected' : '' }}>S3</option>
                                        <option value="D3" {{ old('pendidikan_terakhir') == 'D3' ? 'selected' : '' }}>D3</option>
                                        <option value="D4" {{ old('pendidikan_terakhir') == 'D4' ? 'selected' : '' }}>D4</option>
                                    </select>
                                    @error('pendidikan_terakhir')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Jurusan <span class="text-danger">*</span></label>
                                    <input type="text" name="jurusan" class="form-control form-control-sm" placeholder="Contoh: Pendidikan Matematika"
                                        value="{{ old('jurusan') }}" required>
                                    @error('jurusan')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Jabatan <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="jabatan" required>
                                        <option value="">Pilih Jabatan</option>
                                        <option value="Kepala Sekolah" {{ old('jabatan') == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                                        <option value="Wakil Kepala Sekolah" {{ old('jabatan') == 'Wakil Kepala Sekolah' ? 'selected' : '' }}>Wakil Kepala Sekolah</option>
                                        <option value="Guru" {{ old('jabatan') == 'Guru' ? 'selected' : '' }}>Guru</option>
                                    </select>
                                    @error('jabatan')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                        <option value="Cuti" {{ old('status') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-info text-white me-3">
                                        <i class="fas fa-address-book"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Informasi Kontak</h5>
                                        <small class="text-muted">Data alamat dan komunikasi</small>
                                    </div>
                                </div>
                                <hr class="my-3">
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Alamat <span class="text-danger">*</span></label>
                                    <textarea name="alamat" class="form-control form-control-sm" rows="3" placeholder="Alamat lengkap guru"
                                            required>{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Sekolah <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="id_sekolah" required>
                                        <option value="">Pilih Sekolah</option>
                                        @if(isset($sekolah))
                                            @foreach($sekolah as $skl)
                                                <option value="{{ $skl->kode_sekolah }}" {{ old('id_sekolah') == $skl->kode_sekolah ? 'selected' : '' }}>
                                                    {{ $skl->nama_sekolah }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
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
                                        <a href="{{ route($userRole . '.guru.index') }}" class="btn btn-outline-secondary me-2">
                                            <i class="fas fa-times me-2"></i>Batal
                                        </a>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-save me-2"></i>Simpan Data Guru
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
