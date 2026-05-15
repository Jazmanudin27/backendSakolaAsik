@extends('layouts.app')

@section('titlepage', 'Detail Mata Pelajaran')

@section('content')
<div class="container-fluid p-0">
    <!-- Header with Background -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white border-0">
                <div class="card-body pb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <h1 class="h3 mb-1">Detail Mata Pelajaran</h1>
                            <p class="mb-0 opacity-75">Informasi lengkap data mata pelajaran</p>
                        </div>
                        <div>
                            <a href="{{ route($userRole . '.mapel.index') }}"
                                class="btn btn-outline-light me-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <a href="{{ route($userRole . '.mapel.edit', $mapel->id) }}"
                                class="btn btn-warning me-2">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <form
                                action="{{ route($userRole . '.mapel.destroy', $mapel->id) }}"
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
                    <div class="text-center mb-4">
                        <div class="avatar-wrapper mb-3">
                            <div class="avatar avatar-xl mb-3">
                                <div class="avatar-title rounded-circle bg-primary text-white border-4 border-white shadow"
                                    style="width: 140px; height: 140px; font-size: 3.5rem; font-weight: bold;">
                                    {{ strtoupper(substr($mapel->nama_mapel, 0, 1)) }}
                                </div>
                            </div>
                        </div>
                        <h3 class="mb-2 fw-bold">{{ $mapel->nama_mapel }}</h3>
                        <p class="text-muted mb-3">
                            <i class="fas fa-tag me-2"></i>{{ $mapel->kode_mapel }}
                        </p>
                        <div class="d-flex justify-content-center gap-2">
                            <button
                                class="btn btn-sm btn-{{ 
                                    $mapel->kelompok == 'A' ? 'primary' : 
                                    ($mapel->kelompok == 'B' ? 'success' : 
                                    ($mapel->kelompok == 'C' ? 'warning' : 'info')) 
                                }} rounded-pill">
                                {{ $mapel->kelompok }}
                            </button>
                            <button class="btn btn-sm btn-{{ $mapel->status == 'Aktif' ? 'success' : 'secondary' }} rounded-pill">
                                {{ $mapel->status }}
                            </button>
                        </div>
                    </div>
                    
                    <!-- Statistics -->
                    <div class="text-center mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-clock me-2 text-primary"></i>Jam/Minggu
                                </h6>
                                <h4 class="mb-0 fw-bold">{{ $mapel->jam_per_minggu }}</h4>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-edit-3 me-2 text-info"></i>Total Soal
                                </h6>
                                <h4 class="mb-0 fw-bold">{{ $mapel->soalUjians->count() }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-list me-2 text-warning"></i>Jenis
                            </h6>
                            <h5 class="mb-0 fw-bold">{{ $mapel->jenis }}</h5>
                        </div>
                        @if($mapel->singkatan)
                            <div class="mb-3">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-font me-2 text-info"></i>Singkatan
                                </h6>
                                <h5 class="mb-0 fw-bold">{{ $mapel->singkatan }}</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <!-- Mapel Information -->
                    <div class="mb-4">
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Kode Mata Pelajaran</label>
                                    <div class="fw-semibold">{{ $mapel->kode_mapel }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Nama Mata Pelajaran</label>
                                    <div class="fw-semibold">{{ $mapel->nama_mapel }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Singkatan</label>
                                    <div class="fw-semibold">{{ $mapel->singkatan ?: '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Kelompok</label>
                                    <button class="btn btn-sm btn-{{ 
                                        $mapel->kelompok == 'A' ? 'primary' : 
                                        ($mapel->kelompok == 'B' ? 'success' : 
                                        ($mapel->kelompok == 'C' ? 'warning' : 'info') 
                                    }}">
                                        {{ $mapel->kelompok }}
                                    </button>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Jenis</label>
                                    <button class="btn btn-sm btn-{{ $mapel->jenis == 'Wajib' ? 'primary' : 'secondary' }}">
                                        {{ $mapel->jenis }}
                                    </button>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Status</label>
                                    <button class="btn btn-sm btn-{{ $mapel->status == 'Aktif' ? 'success' : 'secondary' }} rounded-pill">
                                        {{ $mapel->status }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule Information -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-wrapper bg-success text-white me-3">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Informasi Jadwal</h5>
                                <small class="text-muted">Jam dan jadwal pelajaran</small>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Jam Per Minggu</label>
                                    <div class="fw-semibold">{{ $mapel->jam_per_minggu }} jam</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Total Jam Per Bulan</label>
                                    <div class="fw-semibold">{{ $mapel->jam_per_minggu * 4 }} jam</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Total Jam Per Semester</label>
                                    <div class="fw-semibold">{{ $mapel->jam_per_minggu * 16 }} jam</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Total Jam Per Tahun</label>
                                    <div class="fw-semibold">{{ $mapel->jam_per_minggu * 32 }} jam</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($mapel->deskripsi)
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-info text-white me-3">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">Deskripsi</h5>
                                    <small class="text-muted">Informasi detail tentang mata pelajaran</small>
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="text-muted small">Deskripsi Lengkap</label>
                                        <div class="fw-semibold">{{ $mapel->deskripsi }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Statistics -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-wrapper bg-warning text-white me-3">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Statistik</h5>
                                <small class="text-muted">Ringkasan data mata pelajaran</small>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="text-muted small">Total Soal Ujian</label>
                                    <div class="fw-semibold">{{ $mapel->soalUjians->count() }} soal</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="text-muted small">Status Aktif</label>
                                    <div class="fw-semibold">{{ $mapel->status }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="text-muted small">Jenis</label>
                                    <div class="fw-semibold">{{ $mapel->jenis }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="text-muted small">Tanggal Dibuat</label>
                                    <div class="fw-semibold">{{ $mapel->created_at->format('d F Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Exam Questions -->
                    @if($mapel->soalUjians->count() > 0)
                        <div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-info text-white me-3">
                                    <i class="fas fa-edit-3"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">Soal Ujian</h5>
                                    <small class="text-muted">Soal ujian untuk mata pelajaran ini</small>
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Soal</th>
                                            <th>Guru</th>
                                            <th>Tahun Ajaran</th>
                                            <th>Tingkat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($mapel->soalUjians->take(5) as $soal)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="fw-semibold">{{ Str::limit($soal->soal, 50) }}</div>
                                                    <small class="text-muted">{{ $soal->tipe_soal }}</small>
                                                </td>
                                                <td>{{ $soal->guru->nama_guru ?? '-' }}</td>
                                                <td>{{ $soal->tahunAjaran->tahun_ajaran ?? '-' }}</td>
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
                            @if($mapel->soalUjians->count() > 5)
                                <div class="text-center mt-3">
                                    <a href="{{ route($userRole . '.soal_ujian.index') }}?mapel={{ $mapel->id }}" class="btn btn-outline-primary">
                                        Lihat Semua Soal ({{ $mapel->soalUjians->count() }})
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
