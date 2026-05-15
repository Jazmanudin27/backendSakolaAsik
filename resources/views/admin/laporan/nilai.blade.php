@extends('layouts.app')

@section('titlepage', 'Laporan Nilai')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Laporan Nilai</h1>
                        <p class="text-muted mb-0">Laporan nilai ujian siswa</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route($userRole . '.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Format Selection -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Pilih Format Laporan</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <a href="{{ route($userRole . '.laporan.nilai') }}"
                                    class="btn btn-outline-primary w-100 mb-2">
                                    <i class="fas fa-list me-2"></i>Format Umum
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route($userRole . '.laporan.penilaian.rekap') }}"
                                    class="btn btn-outline-info w-100 mb-2">
                                    <i class="fas fa-chart-bar me-2"></i>Format Rekap (Per Siswa)
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route($userRole . '.laporan.penilaian.detail') }}"
                                    class="btn btn-outline-success w-100 mb-2">
                                    <i class="fas fa-table me-2"></i>Format Detail (Per Siswa Per Ujian)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mb-3">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route($userRole . '.laporan.nilai') }}" method="GET" class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Ujian</label>
                                <select name="ujian" class="form-select select2">
                                    <option value="">Semua Ujian</option>
                                    @foreach ($ujian as $u)
                                        <option value="{{ $u->kode_ujian }}"
                                            {{ request('ujian') == $u->kode_ujian ? 'selected' : '' }}>
                                            {{ $u->kode_ujian }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Kelas</label>
                                <select name="kelas" class="form-select select2">
                                    <option value="">Semua Kelas</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->kode_kelas }}"
                                            {{ request('kelas') == $k->kode_kelas ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select select2">
                                    <option value="">Semua Status</option>
                                    <option value="Belum Mulai" {{ request('status') == 'Belum Mulai' ? 'selected' : '' }}>
                                        Belum Mulai</option>
                                    <option value="Sedang Mengerjakan"
                                        {{ request('status') == 'Sedang Mengerjakan' ? 'selected' : '' }}>Sedang
                                        Mengerjakan</option>
                                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex gap-2">
                                    <!-- CETAK -->
                                    <a href="{{ route($userRole . '.laporan.nilai.print', request()->query()) }}"
                                        class="btn btn-sm btn-primary w-100" target="_blank">
                                        <i class="fas fa-print me-1"></i> Cetak
                                    </a>
                                    <!-- EXPORT -->
                                    <a href="#" class="btn btn-sm btn-success w-100" target="_blank">
                                        <i class="fas fa-file-excel me-1"></i> Export
                                    </a>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
