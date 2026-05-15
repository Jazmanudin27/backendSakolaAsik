@extends('layouts.app')

@section('titlepage', 'Detail Hasil Ujian')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Detail Hasil Ujian</h1>
                        <p class="text-muted mb-0">{{ $jawabanSiswa->ujian->mapel->nama_mapel }} -
                            {{ $jawabanSiswa->ujian->jenis_ujian }}</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('siswa.dashboard') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Score Summary Card -->
        <div class="row">
            <div class="col-12">
                <div class="card bg-primary text-white border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="mb-2">Skor Akhir: {{ $totalScore }} / {{ $maxScore }}</h4>
                                <h5 class="mb-0">{{ $percentage }}%</h5>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="row">
                                    <div class="col-6">
                                        <small class="d-block opacity-75">Benar</small>
                                        <h4 class="mb-0">{{ $correctAnswers }}</h4>
                                    </div>
                                    <div class="col-6">
                                        <small class="d-block opacity-75">Total Soal</small>
                                        <h4 class="mb-0">{{ $totalQuestions }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exam Info -->
        <div class="row">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Informasi Ujian
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <small class="text-muted d-block">Mata Pelajaran</small>
                                <strong>{{ $jawabanSiswa->ujian->mapel->nama_mapel }}</strong>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-muted d-block">Jenis Ujian</small>
                                <strong>{{ $jawabanSiswa->ujian->jenis_ujian }}</strong>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-muted d-block">Kelas</small>
                                <strong>{{ $jawabanSiswa->siswa->kelas->nama_kelas }}</strong>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-muted d-block">Tahun Pelajaran</small>
                                <strong>{{ $jawabanSiswa->ujian->tahunPelajaran->tahun_ajaran }}</strong>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-muted d-block">Tanggal Ujian</small>
                                <strong>{{ $jawabanSiswa->waktu_selesai->format('d F Y') }}</strong>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-muted d-block">Durasi</small>
                                <strong>{{ $jawabanSiswa->ujian->durasi }} menit</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-clock text-primary me-2"></i>
                            Waktu Pengerjaan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <small class="text-muted d-block">Waktu Mulai</small>
                                <strong>{{ $jawabanSiswa->waktu_mulai->format('H:i') }}</strong>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-muted d-block">Waktu Selesai</small>
                                <strong>{{ $jawabanSiswa->waktu_selesai->format('H:i') }}</strong>
                            </div>
                            <div class="col-12">
                                <small class="text-muted d-block">Total Waktu</small>
                                <strong>{{ floor($jawabanSiswa->waktu_mulai->diffInMinutes($jawabanSiswa->waktu_selesai)) }}
                                    menit</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Answer Details -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-list-check text-primary me-2"></i>
                            Detail Jawaban
                        </h6>
                    </div>
                    <div class="card-body">
                        @if ($jawabanSiswa->detailJawaban->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Type</th>
                                            <th>Jawaban Anda</th>
                                            <th>Benar</th>
                                            <th>Skor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jawabanSiswa->detailJawaban as $index => $detail)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="text-truncate" style="max-width: 300px;">
                                                        {{ $detail->detailUjian->tipe_soal == 'pilihan_ganda'
                                                            ? 'Pilihan Ganda'
                                                            : ($detail->detailUjian->tipe_soal == 'essay'
                                                                ? 'Essay'
                                                                : ($detail->detailUjian->tipe_soal == 'benar_salah'
                                                                    ? 'Benar/Salah'
                                                                    : 'Isian Singkat')) }}
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($detail->detailUjian->tipe_soal == 'pilihan_ganda')
                                                        {{ $detail->jawaban ?? '-' }}
                                                    @elseif($detail->detailUjian->tipe_soal == 'benar_salah')
                                                        {{ $detail->jawaban ? 'Benar' : 'Salah' }}
                                                    @else
                                                        <span class="text-muted">Isian Singkat</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($detail->benar)
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check"></i> Benar
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times"></i> Salah
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>{{ $detail->detailUjian->bobot ?? 1 }} poin</strong>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada detail jawaban yang tersimpan.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
