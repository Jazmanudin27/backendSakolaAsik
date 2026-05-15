@extends('layouts.app')

@section('titlepage', 'Detail Tahun Ajaran')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Detail Tahun Ajaran</h1>
                        <p class="text-muted mb-0">Informasi lengkap tahun ajaran</p>
                    </div>
                    <div>
                        <a href="{{ route($userRole . '.tahun_ajaran.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <a href="{{ route($userRole . '.tahun_ajaran.edit', $tahunAjaran->id) }}"
                            class="btn btn-warning me-2">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <form action="{{ route($userRole . '.tahun_ajaran.destroy', $tahunAjaran->id) }}" method="POST"
                            class="d-inline">
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

        <!-- Main Content -->
        <div class="row">
            <!-- Info Card -->
            <div class="col-md-8 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-wrapper bg-primary text-white me-3">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Informasi Tahun Ajaran</h5>
                                <small class="text-muted">Data lengkap tahun ajaran</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Tahun Ajaran</label>
                                    <div class="fw-semibold">{{ $tahunAjaran->tahun_ajaran }}</div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted small">Semester</label>
                                    <div>
                                        <button
                                            class="btn btn-sm btn-{{ $tahunAjaran->semester == 'Ganjil' ? 'info' : 'warning' }}">
                                            {{ $tahunAjaran->semester }}
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted small">Tanggal Mulai</label>
                                    <div class="fw-semibold">{{ $tahunAjaran->tanggal_mulai->format('d F Y') }}</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Tanggal Selesai</label>
                                    <div class="fw-semibold">{{ $tahunAjaran->tanggal_selesai->format('d F Y') }}</div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted small">Durasi</label>
                                    <div class="fw-semibold">
                                        {{ $tahunAjaran->tanggal_mulai->diffInDays($tahunAjaran->tanggal_selesai) }} hari
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted small">Status</label>
                                    <div>
                                        <button
                                            class="btn btn-sm btn-{{ $tahunAjaran->status == 'Aktif' ? 'success' : 'secondary' }}">
                                            {{ $tahunAjaran->status }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($tahunAjaran->keterangan)
                            <div class="mt-3 pt-3 border-top">
                                <label class="text-muted small">Keterangan</label>
                                <div>{{ $tahunAjaran->keterangan }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Status & Stats Card -->
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-wrapper bg-info text-white me-3">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Statistik</h5>
                                <small class="text-muted">Ringkasan data</small>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Total Soal Ujian</h6>
                                    <small class="text-muted">Untuk tahun ajaran ini</small>
                                </div>
                                <span class="badge bg-primary">{{ $tahunAjaran->soalUjians->count() }}</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Status Aktif</h6>
                                    <small class="text-muted">Saat ini</small>
                                </div>
                                <span class="badge bg-{{ $tahunAjaran->status == 'Aktif' ? 'success' : 'secondary' }}">
                                    {{ $tahunAjaran->status }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Semester</h6>
                                    <small class="text-muted">Periode</small>
                                </div>
                                <span class="badge bg-{{ $tahunAjaran->semester == 'Ganjil' ? 'info' : 'warning' }}">
                                    {{ $tahunAjaran->semester }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Dibuat</h6>
                                    <small class="text-muted">Tanggal pembuatan</small>
                                </div>
                                <span
                                    class="badge bg-light text-dark">{{ $tahunAjaran->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Data -->
        @if ($tahunAjaran->soalUjians->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-wrapper bg-success text-white me-3">
                                    <i class="fas fa-list"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">Soal Ujian Terkait</h5>
                                    <small class="text-muted">Daftar soal ujian untuk tahun ajaran ini</small>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Soal</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Guru</th>
                                            <th>Kelas</th>
                                            <th>Tingkat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tahunAjaran->soalUjians->take(5) as $soal)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="fw-semibold">{{ Str::limit($soal->soal, 50) }}</div>
                                                    <small class="text-muted">{{ $soal->tipe_soal }}</small>
                                                </td>
                                                <td>{{ $soal->mapel->nama_mapel ?? '-' }}</td>
                                                <td>{{ $soal->guru->nama_guru ?? '-' }}</td>
                                                <td>{{ $soal->kelas }}</td>
                                                <td>
                                                    <button
                                                        class="btn btn-sm btn-{{ $soal->tingkat_kesulitan == 'Mudah' ? 'success' : ($soal->tingkat_kesulitan == 'Sedang' ? 'warning' : 'danger') }}">
                                                        {{ $soal->tingkat_kesulitan }}
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if ($tahunAjaran->soalUjians->count() > 5)
                                <div class="text-center mt-3">
                                    <a href="{{ route($userRole . '.soal_ujian.index') }}?tahun_ajaran={{ $tahunAjaran->id }}"
                                        class="btn btn-outline-primary">
                                        Lihat Semua Soal ({{ $tahunAjaran->soalUjians->count() }})
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
