@extends('layouts.app')

@section('titlepage', 'Detail Kelas')

@section('content')
    <div class="container-fluid py-4">
        <h1 class="h3 mb-4">Detail Kelas</h1>
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">

                    <div class="ms-3">
                        <h4 class="mb-0">{{ $kelas->nama_kelas }}</h4>
                        <p class="mb-1"><i class="fas fa-layer-group me-2"></i>Tingkat {{ $kelas->tingkat }}</p>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-primary rounded-pill">
                                <i class="fas fa-door-open me-1"></i>{{ $kelas->nama_kelas }}
                            </button>
                            <button
                                class="btn btn-sm btn-{{ $kelas->status == 'Aktif' ? 'success' : 'secondary' }} rounded-pill">
                                {{ $kelas->status }}
                            </button>
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2"><i class="fas fa-users me-2 text-success"></i>Jumlah Siswa</h6>
                        <h4 class="mb-0 fw-bold">{{ $kelas->jumlah_siswa }}</h4>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2"><i class="fas fa-chart-bar me-2 text-info"></i>Kapasitas</h6>
                        <h4 class="mb-0 fw-bold">{{ $kelas->kapasitas }}</h4>
                    </div>
                </div>
                <div class="progress mt-4 mb-3" style="height: 30px;">
                    <div class="progress-bar bg-{{ $kelas->jumlah_siswa >= $kelas->kapasitas ? 'danger' : ($kelas->jumlah_siswa >= $kelas->kapasitas * 0.8 ? 'warning' : 'success') }}"
                        role="progressbar" style="width: {{ ($kelas->jumlah_siswa / $kelas->kapasitas) * 100 }}%">
                        {{ $kelas->jumlah_siswa }}/{{ $kelas->kapasitas }}
                    </div>
                </div>
                <small class="text-muted">Kapasitas Terisi</small>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title mb-4">Informasi Kelas</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small">Nama Kelas</label>
                            <div class="fw-semibold">{{ $kelas->nama_kelas }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">Tingkat</label>
                            <div class="fw-semibold">{{ $kelas->tingkat }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">Jurusan</label>
                            <div class="fw-semibold">{{ $kelas->jurusan ?: '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small">Wali Kelas</label>
                            <div class="fw-semibold">{{ $kelas->wali_kelas ?: '-' }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">Ruangan</label>
                            <div class="fw-semibold">{{ $kelas->ruangan ?: '-' }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">Status</label>
                            <button
                                class="btn btn-sm btn-{{ $kelas->status == 'Aktif' ? 'success' : 'secondary' }} rounded-pill">
                                {{ $kelas->status }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($kelas->siswas->count() > 0)
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Data Siswa</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>NIS</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas->siswas->take(5) as $siswa)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $siswa->nama_siswa }}</td>
                                        <td>{{ $siswa->nis }}</td>
                                        <td>
                                            <button
                                                class="btn btn-sm btn-{{ $siswa->jk == 'Laki-laki' ? 'info' : 'danger' }}">
                                                {{ $siswa->jk }}
                                            </button>
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-sm btn-{{ $siswa->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                {{ $siswa->status }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($kelas->siswas->count() > 5)
                        <div class="text-center mt-3">
                            <a href="{{ route($userRole . '.siswa.index') }}?kelas={{ $kelas->id }}"
                                class="btn btn-outline-primary">
                                Lihat Semua Siswa ({{ $kelas->siswas->count() }})
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
