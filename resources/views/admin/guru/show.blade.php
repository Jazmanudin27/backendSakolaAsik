@extends('layouts.app')

@section('titlepage', 'Detail Guru')

@section('content')
<div class="container-fluid p-0">
    <!-- Header with Background -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white border-0">
                <div class="card-body pb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <h1 class="h3 mb-1">Detail Guru</h1>
                            <p class="mb-0 opacity-75">Informasi lengkap data guru</p>
                        </div>
                        <div>
                            <a href="{{ route($userRole . '.guru.index') }}"
                                class="btn btn-outline-light me-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <a href="{{ route($userRole . '.guru.edit', $guru->id) }}"
                                class="btn btn-warning me-2">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <form
                                action="{{ route($userRole . '.guru.destroy', $guru->id) }}"
                                method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger delete">
                                    <i class="fas fa-trash me-2"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-lg">
                <div class="card-body pt-4">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <!-- Avatar with Border -->
                            <div class="avatar-wrapper mb-3">
                                <div class="avatar avatar-xl mb-3">
                                    @if($guru->foto)
                                        <img src="{{ asset('storage/guru/' . $guru->foto) }}"
                                            alt="Foto {{ $guru->nama_guru }}"
                                            class="rounded-circle border-4 border-white shadow"
                                            style="width: 140px; height: 140px; object-fit: cover;">
                                    @else
                                        <div class="avatar-title rounded-circle bg-primary text-white border-4 border-white shadow"
                                            style="width: 140px; height: 140px; font-size: 3.5rem; font-weight: bold;">
                                            {{ strtoupper(substr($guru->nama_guru, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <h3 class="mb-2 fw-bold">{{ $guru->nama_guru }}</h3>
                            <p class="text-muted mb-3">
                                <i class="fas fa-user me-3"></i>{{ $guru->nip }}
                            </p>
                            <div class="d-flex justify-content-center gap-2">
                                <button
                                    class="btn btn-sm btn-{{ $guru->jk == 'Laki-laki' ? 'info' : 'danger' }} rounded-pill">
                                    @if($guru->jk == 'Laki-laki')
                                        <i class="fas fa-mars me-1"></i>
                                    @else
                                        <i class="fas fa-venus me-1"></i>
                                    @endif
                                    {{ $guru->jk }}
                                </button>
                                <button class="btn btn-sm btn-light rounded-pill">
                                    <i class="fas fa-graduation-cap me-1"></i>{{ $guru->pendidikan_terakhir }}
                                </button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-4">
                                        <i class="fas fa-briefcase me-2 text-primary"></i>Informasi Profesional
                                    </h6>
                                    <div class="info-item">
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Jabatan</small>
                                            <div class="fw-semibold">{{ $guru->jabatan }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Pendidikan Terakhir</small>
                                            <div class="fw-semibold">{{ $guru->pendidikan_terakhir }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Jurusan</small>
                                            <div class="fw-semibold">{{ $guru->jurusan }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Status</small>
                                            <button class="btn btn-sm btn-{{ $guru->status == 'Aktif' ? 'success' : ($guru->status == 'Cuti' ? 'warning' : 'secondary') }} rounded-pill">
                                                {{ $guru->status }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-4">
                                        <i class="fas fa-address-book me-2 text-info"></i>Informasi Kontak
                                    </h6>
                                    <div class="info-item">
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Email</small>
                                            <div class="fw-semibold">{{ $guru->email ?: '-' }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">No. HP</small>
                                            <div class="fw-semibold">{{ $guru->no_hp ?: '-' }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Sekolah</small>
                                            <div class="fw-semibold">{{ $guru->sekolah->nama_sekolah ?? '-' }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Alamat</small>
                                            <div class="fw-semibold">{{ $guru->alamat }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <!-- Personal Information -->
                    <div class="mb-4">
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Nama Lengkap</label>
                                    <div class="fw-semibold">{{ $guru->nama_guru }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">NIP</label>
                                    <div class="fw-semibold">{{ $guru->nip }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Jenis Kelamin</label>
                                    <div class="fw-semibold">{{ $guru->jk }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Tempat Lahir</label>
                                    <div class="fw-semibold">{{ $guru->tempat_lahir ?: '-' }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Tanggal Lahir</label>
                                    <div class="fw-semibold">{{ $guru->tgl_lahir ? $guru->tgl_lahir->format('d F Y') : '-' }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Usia</label>
                                    <div class="fw-semibold">{{ $guru->tgl_lahir ? $guru->tgl_lahir->age . ' tahun' : '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div class="mb-4">
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Jabatan</label>
                                    <div class="fw-semibold">{{ $guru->jabatan }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Pendidikan Terakhir</label>
                                    <div class="fw-semibold">{{ $guru->pendidikan_terakhir }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Jurusan</label>
                                    <div class="fw-semibold">{{ $guru->jurusan }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Status</label>
                                    <button class="btn btn-sm btn-{{ $guru->status == 'Aktif' ? 'success' : ($guru->status == 'Cuti' ? 'warning' : 'secondary') }} rounded-pill">
                                        {{ $guru->status }}
                                    </button>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Sekolah</label>
                                    <div class="fw-semibold">{{ $guru->sekolah->nama_sekolah ?? '-' }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Tanggal Bergabung</label>
                                    <div class="fw-semibold">{{ $guru->created_at->format('d F Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="mb-4">
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Email</label>
                                    <div class="fw-semibold">{{ $guru->email ?: '-' }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">No. HP</label>
                                    <div class="fw-semibold">{{ $guru->no_hp ?: '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Alamat</label>
                                    <div class="fw-semibold">{{ $guru->alamat }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Data -->
                    @if($guru->soalUjians->count() > 0)
                        <div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-warning text-white me-3">
                                    <i class="fas fa-list"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">Soal Ujian</h5>
                                    <small class="text-muted">Daftar soal ujian yang dibuat</small>
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Soal</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Kelas</th>
                                            <th>Tingkat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($guru->soalUjians->take(5) as $soal)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="fw-semibold">{{ Str::limit($soal->soal, 50) }}</div>
                                                    <small class="text-muted">{{ $soal->tipe_soal }}</small>
                                                </td>
                                                <td>{{ $soal->mapel->nama_mapel ?? '-' }}</td>
                                                <td>{{ $soal->kelas }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-{{ $soal->tingkat_kesulitan == 'Mudah' ? 'success' : ($soal->tingkat_kesulitan == 'Sedang' ? 'warning' : 'danger') }}">
                                                        {{ $soal->tingkat_kesulitan }}
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($guru->soalUjians->count() > 5)
                                <div class="text-center mt-3">
                                    <a href="{{ route($userRole . '.soal_ujian.index') }}?guru={{ $guru->id }}" class="btn btn-outline-primary">
                                        Lihat Semua Soal ({{ $guru->soalUjians->count() }})
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
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

.avatar-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
}

.info-item {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
    border-left: 3px solid #007bff;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transition: all 0.15s ease-in-out;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.btn {
    border-radius: 0.5rem;
    font-weight: 500;
}

.rounded-pill {
    border-radius: 50rem !important;
}
</style>
@endsection
