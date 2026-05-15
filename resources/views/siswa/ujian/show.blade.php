@extends('layouts.app')

@section('titlepage', 'Detail Ujian')

@section('content')

    <div class="container-fluid">

        <div class="d-flex justify-content-end mb-3">
            <div class="btn-group">
                <a href="{{ route('siswa.ujian.index') }}" class="btn btn-sm btn-secondary px-4">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali
                </a>

                @if ($ujian->status == 'Aktif' && $ujian->detailUjians->count() > 0 && !$hasSubmitted)
                    <a href="{{ route('siswa.ujian.start', $ujian->id) }}" class="btn btn-sm btn-success px-4 shadow-sm">
                        <i class="fas fa-play me-2"></i>
                        Mulai Ujian
                    </a>
                @endif
            </div>
        </div>
        <div class="card border-0 shadow-sm bg-primary text-white mb-4">
            <div class="card-body p-4">

                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 p-3 me-3">
                                <i class="fas fa-file-alt fa-2x"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">
                                    {{ $ujian->kode_ujian }}
                                </h2>
                                <div class="opacity-75">
                                    {{ $ujian->jenis_ujian }} • {{ $ujian->mapel->nama_mapel }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 text-md-end mt-4 mt-md-0">

                        <div class="d-inline-flex align-items-center bg-light text-dark rounded-pill px-4 py-2 fw-semibold">
                            <i class="fas fa-clock text-primary me-2"></i>
                            {{ $ujian->durasi }} Menit
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <!-- INFO -->
        <div class="row g-4 mb-4">

            <!-- INFORMASI UJIAN -->
            <div class="col-lg-6">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Informasi Ujian
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="list-group list-group-flush">

                            <div class="list-group-item px-0">
                                <small class="text-muted d-block">
                                    Mata Pelajaran
                                </small>

                                <div class="fw-semibold fs-6">
                                    {{ $ujian->mapel->nama_mapel }}
                                </div>
                            </div>

                            <div class="list-group-item px-0">
                                <small class="text-muted d-block">
                                    Kelas
                                </small>

                                <div class="fw-semibold fs-6">
                                    {{ $ujian->tingkat }}
                                </div>
                            </div>

                            <div class="list-group-item px-0">
                                <small class="text-muted d-block">
                                    Tanggal Ujian
                                </small>

                                <div class="fw-semibold fs-6">
                                    {{ $ujian->tanggal_ujian->format('d F Y') }}
                                </div>
                            </div>

                            <div class="list-group-item px-0 border-bottom-0">
                                <small class="text-muted d-block">
                                    Tahun Pelajaran
                                </small>

                                <div class="fw-semibold fs-6">
                                    {{ $ujian->tahunPelajaran->tahun_ajaran }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STATUS -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-chart-line text-success me-2"></i>
                            Status Ujian
                        </h5>
                    </div>
                    <div class="card-body">
                        <div
                            class="alert alert-{{ $ujian->status == 'Aktif' ? 'success' : 'secondary' }} d-flex align-items-center">
                            <i class="fas fa-{{ $ujian->status == 'Aktif' ? 'check-circle' : 'times-circle' }} me-2"></i>
                            <div>
                                Status :
                                <strong>{{ $ujian->status }}</strong>
                            </div>
                        </div>
                        @if ($hasSubmitted)
                            <div class="alert alert-warning d-flex align-items-start mb-0">
                                <i class="fas fa-trophy fa-lg me-3 mt-1"></i>
                                <div>
                                    <div class="fw-bold">
                                        Ujian Sudah Selesai
                                    </div>
                                    <small>
                                        Anda sudah menyelesaikan ujian ini.
                                    </small>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info d-flex align-items-start mb-0">
                                <i class="fas fa-play-circle fa-lg me-3 mt-1"></i>
                                <div>
                                    <div class="fw-bold">
                                        Siap Memulai
                                    </div>
                                    <small>
                                        Pastikan koneksi internet stabil sebelum memulai ujian.
                                    </small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- DISTRIBUSI SOAL -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h5 class="fw-bold mb-1">
                            <i class="fas fa-chart-pie text-primary me-2"></i>
                            Distribusi Soal
                        </h5>
                        <small class="text-muted">
                            Total {{ $ujian->detailUjians->count() }} soal tersedia
                        </small>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <span class="badge bg-primary fs-6 px-3 py-2">
                            {{ $ujian->detailUjians->count() }} Soal
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3 col-6">
                        <div class="card bg-primary text-white border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-list fa-2x mb-3 opacity-75"></i>
                                <h2 class="fw-bold mb-1">
                                    {{ $ujian->detailUjians->where('tipe_soal', 'pilihan_ganda')->count() }}
                                </h2>
                                <small>Pilihan Ganda</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card bg-danger text-white border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-pen fa-2x mb-3 opacity-75"></i>
                                <h2 class="fw-bold mb-1">
                                    {{ $ujian->detailUjians->where('tipe_soal', 'essay')->count() }}
                                </h2>
                                <small>Essay</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card bg-info text-white border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-check-double fa-2x mb-3 opacity-75"></i>
                                <h2 class="fw-bold mb-1">
                                    {{ $ujian->detailUjians->where('tipe_soal', 'benar_salah')->count() }}
                                </h2>
                                <small>Benar / Salah</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card bg-success text-white border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-keyboard fa-2x mb-3 opacity-75"></i>
                                <h2 class="fw-bold mb-1">
                                    {{ $ujian->detailUjians->where('tipe_soal', 'isian_singkat')->count() }}
                                </h2>
                                <small>Isian Singkat</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
