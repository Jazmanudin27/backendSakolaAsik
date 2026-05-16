@extends('layouts.app')

@section('titlepage', 'Hasil Ujian')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Hasil Ujian Saya</h1>
                        <p class="text-muted mb-0">Lihat hasil ujian yang sudah dibuka oleh guru/admin</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Cards -->
        <div class="row">
            @if ($hasilUjians->count() > 0)
                @foreach ($hasilUjians as $hasil)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-1">{{ $hasil->ujian->mapel->nama_mapel }}</h6>
                                        <small class="text-muted">{{ $hasil->ujian->jenis_ujian }}</small>
                                    </div>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Dibuka
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <small class="text-muted">Tanggal Ujian</small>
                                        <small class="fw-semibold">{{ $hasil->waktu_selesai->format('d M Y') }}</small>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <small class="text-muted">Durasi</small>
                                        <small class="fw-semibold">{{ $hasil->ujian->durasi }} menit</small>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <small class="text-muted">Kelas</small>
                                        <small class="fw-semibold">{{ $hasil->siswa->kelas->nama_kelas }}</small>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <a href="{{ route('siswa.hasil-ujian.show', $hasil->id) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-2"></i>Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-chart-line fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-muted">Belum Ada Hasil Ujian</h5>
                            <p class="text-muted">Hasil ujian akan ditampilkan di sini setelah dibuka oleh guru atau admin.
                            </p>
                            <a href="{{ route('siswa.ujian.index') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-clipboard-list me-2"></i>Lihat Ujian Tersedia
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
