@extends('layouts.app')

@section('titlepage', 'Form Tambah Siswa')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Tambah Siswa Baru</h1>
                    <p class="text-muted mb-0">Masukkan data siswa baru ke sistem</p>
                </div>
                <div>
                    <a href="{{ route($userRole . '.siswa.index') }}" class="btn btn-sm btn-outline-secondary">
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
                    <form action="{{ route($userRole . '.siswa.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
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
                                        <small class="text-muted">Data identitas diri siswa</small>
                                    </div>
                                </div>
                                <hr class="my-3">
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_siswa" class="form-control form-control-sm" placeholder="Masukkan nama lengkap siswa"
                                            value="{{ old('nama_siswa') }}" required>
                                    @error('nama_siswa')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" class="form-control form-control-sm" placeholder="Username untuk login"
                                            value="{{ old('username') }}" required>
                                    @error('username')
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
                                    <label class="form-label fw-semibold">NISN <span class="text-danger">*</span></label>
                                    <input type="text" name="nisn" class="form-control form-control-sm" placeholder="Nomor Induk Siswa Nasional"
                                       value="{{ old('nisn') }}" required>
                                    @error('nisn')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">NIS <span class="text-danger">*</span></label>
                                    <input type="text" name="nis" class="form-control form-control-sm" placeholder="Nomor Induk Siswa"
                                       value="{{ old('nis') }}" required>
                                    @error('nis')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tgl_lahir" class="form-control form-control-sm"
                                       value="{{ old('tgl_lahir') }}" required>
                                    @error('tgl_lahir')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Agama</label>
                                    <select class="form-select select2" name="agama">
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
                                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                    </select>
                                    @error('agama')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Academic Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-success text-white me-3">
                                        <i class="fas fa-school"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Informasi Akademik</h5>
                                        <small class="text-muted">Data sekolah dan kelas siswa</small>
                                    </div>
                                </div>
                                <hr class="my-3">
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

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="kode_kelas" required>
                                        <option value="">Pilih Kelas</option>
                                        @if(isset($kelas))
                                            @foreach($kelas as $kls)
                                                <option value="{{ $kls->id }}" {{ old('kode_kelas') == $kls->nama_kelas ? 'selected' : '' }}>
                                                    {{ $kls->nama_kelas }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('kode_kelas')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Status</label>
                                    <select class="form-select select2" name="status">
                                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Keluar/Pindah" {{ old('status') == 'Keluar/Pindah' ? 'selected' : '' }}>Keluar/Pindah</option>
                                        <option value="Lulus" {{ old('status') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
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
                                    <textarea name="alamat" class="form-control form-control-sm" rows="3" placeholder="Alamat lengkap siswa"
                                        required>{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
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
                            </div>
                        </div>

                        <!-- Account & Photo Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-warning text-white me-3">
                                        <i class="fas fa-cog"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Akun & Foto</h5>
                                        <small class="text-muted">Data login dan foto profil</small>
                                    </div>
                                </div>
                                <hr class="my-3">
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                                    <input type="password" name="password" class="form-control form-control-sm" placeholder="Minimal 6 karakter">
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Foto Profil</label>
                                    @if(old('foto'))
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/temp/' . old('foto')) }}" 
                                                 class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                                            <br>
                                            <small class="text-muted">Foto saat ini</small>
                                        </div>
                                    @endif
                                    <input type="file" name="foto" class="form-control form-control-sm" accept="image/*">
                                    <small class="text-muted">Format: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                                    @error('foto')
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
                                        <a href="{{ route($userRole . '.siswa.index') }}" class="btn btn-outline-secondary me-2">
                                            <i class="fas fa-times me-2"></i>Batal
                                        </a>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-save me-2"></i>Simpan Data Siswa
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
    border-radius: 0.375rem;
    font-weight: 500;
}
</style>
@endsection
