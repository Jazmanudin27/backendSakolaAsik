@extends('layouts.app')

@section('titlepage', 'Daftar Ujian')


@section('content')
    <div class="container-fluid">
        <!-- Hero Section -->
        <div class="bg-primary  rounded-3 p-4 mb-4">
            <div class="row align-items-center text-white">
                <div class="col-md-8">
                    <h2 class="mb-2">
                        <i class="fas fa-tasks me-2"></i>
                        Daftar Ujian
                    </h2>
                    <p class="mb-0 opacity-86 text-white">Pilih ujian yang ingin Anda ikuti</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-inline-block bg-white bg-opacity-25 px-3 py-2 rounded">
                        <i class="fas fa-layer-group me-2"></i>
                        {{ $ujians->count() }} Ujian Tersedia
                    </div>
                </div>
            </div>
        </div>
        <!-- Exam Cards -->
        @if ($ujians->count() > 0)
            <div class="row">
                @foreach ($ujians as $ujian)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm h-100 border-0">
                            <!-- Card Header -->
                            <div class="card-header {{ $ujian->has_completed ? 'bg-success' : 'bg-primary' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">{{ $ujian->kode_ujian }}</h5>
                                        <small class="text-white">{{ $ujian->jenis_ujian }}</small>
                                    </div>
                                    <div class="bg-white bg-opacity-25 px-2 py-1 rounded">
                                        <i class="fas fa-clock"></i>
                                        <small>{{ $ujian->durasi }}m</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <div class="d-flex align-items-center p-2 bg-light rounded">
                                            <div>
                                                <small class="text-muted">Mata Pelajaran</small>
                                                <div class="fw-bold">{{ $ujian->mapel->nama_mapel }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex align-items-center p-2 bg-light rounded">
                                            <div>
                                                <small class="text-muted">Tingkat</small>
                                                <div class="fw-bold">{{ $ujian->tingkat }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex align-items-center p-2 bg-light rounded">
                                            <div>
                                                <small class="text-muted">Tanggal</small>
                                                <div class="fw-bold">{{ $ujian->tanggal_ujian->format('d M Y') }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex align-items-center p-2 bg-light rounded">
                                            <div>
                                                <small class="text-muted">Tahun Pelajaran</small>
                                                <div class="fw-bold">{{ $ujian->tahunPelajaran->tahun_ajaran }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($ujian->keterangan)
                                    <div class="mt-3">
                                        <div class="alert alert-info alert-sm">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <small>{{ $ujian->keterangan }}</small>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Card Footer -->
                            <div class="card-footer bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-start">
                                        @if ($ujian->has_completed)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Selesai
                                            </span>
                                        @else
                                            <span
                                                class="badge bg-{{ $ujian->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                {{ $ujian->status }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ route('siswa.ujian.show', $ujian->id) }}"
                                            class="btn btn-sm btn-outline-primary me-2">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if ($ujian->status == 'Aktif' && !$ujian->has_completed)
                                            <a href="{{ route('siswa.ujian.start', $ujian->id) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="fas fa-play-circle"></i>
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="bg-light rounded-3 p-5 d-inline-block">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Tidak Ada Ujian</h4>
                    <p class="text-muted">Belum ada ujian yang tersedia untuk kelas Anda.</p>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-info me-1"></i>
                            Hubungi guru untuk informasi lebih lanjut
                        </small>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
