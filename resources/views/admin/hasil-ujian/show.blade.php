@extends('layouts.app')

@php
    $userRole = 'admin';
    if (Auth::guard('guru')->check()) {
        $userRole = 'guru';
    }
@endphp

@section('titlepage', 'Detail Hasil Ujian Siswa')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Detail Hasil Ujian</h1>
                        <p class="text-muted mb-0">Analisis lengkap hasil ujian siswa</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route($userRole . '.hasil-ujian.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        @if ($detailUjians->where('tipe_soal', 'essay')->count() > 0)
                            <a href="{{ route($userRole . '.hasil-ujian.grade', $jawabanSiswa->id) }}"
                                class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Nilai Esai
                            </a>
                        @endif
                        <a href="{{ route($userRole . '.hasil-ujian.print', $jawabanSiswa->id) }}" class="btn btn-primary"
                            target="_blank">
                            <i class="fas fa-print me-2"></i>Cetak
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student & Exam Info -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Informasi Siswa</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>Nama:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $jawabanSiswa->siswa->nama_siswa }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>NIS:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $jawabanSiswa->siswa->nis }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>Kelas:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $jawabanSiswa->siswa->kelas->nama_kelas }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Informasi Ujian</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>Kode Ujian:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $jawabanSiswa->ujian->kode_ujian }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>Mata Pelajaran:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $jawabanSiswa->ujian->mapel->nama_mapel }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>Tanggal:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $jawabanSiswa->ujian->tanggal_ujian->format('d F Y') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>Durasi:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $jawabanSiswa->ujian->durasi }} menit
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Score Overview -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Ringkasan Nilai</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h2
                                        class="text-{{ $scoreDetails['total_max_score'] > 0 ? (($scoreDetails['total_score'] / $scoreDetails['total_max_score']) * 100 >= 80 ? 'success' : (($scoreDetails['total_score'] / $scoreDetails['total_max_score']) * 100 >= 60 ? 'warning' : 'danger')) : 'muted' }}">
                                        {{ $scoreDetails['total_max_score'] > 0 ? round(($scoreDetails['total_score'] / $scoreDetails['total_max_score']) * 100, 1) : 0 }}%
                                    </h2>
                                    <p class="text-muted">Nilai Akhir</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-primary">
                                        {{ $scoreDetails['total_score'] }}/{{ $scoreDetails['total_max_score'] }}</h4>
                                    <p class="text-muted">Skor</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-success">{{ $scoreDetails['correct_count'] }}</h4>
                                    <p class="text-muted">Benar</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-danger">{{ $scoreDetails['wrong_count'] }}</h4>
                                    <p class="text-muted">Salah</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Answers -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Detail Jawaban</h5>
                            <div class="text-muted">
                                <small>{{ $detailUjians->count() }} soal</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach ($detailUjians as $index => $soal)
                            <div class="border rounded mb-3 p-3">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-start mb-2">
                                            <div class="flex-grow-1">
                                                <div class="fw-semibold mb-1">
                                                    No. {{ $index + 1 }} |
                                                    {{ $soal->tipe_soal == 'pilihan_ganda'
                                                        ? 'Pilihan Ganda'
                                                        : ($soal->tipe_soal == 'essay'
                                                            ? 'Essay'
                                                            : ($soal->tipe_soal == 'benar_salah'
                                                                ? 'Benar/Salah'
                                                                : 'Isian Singkat')) }}

                                                </div>
                                                @if ($soal->tipe_soal == 'pilihan_ganda')
                                                    <div class="row ms-3 gap-2">
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm {{ isset($studentAnswers[$soal->id]) && $studentAnswers[$soal->id]->jawaban == 'A' ? 'btn-success' : 'btn-outline-secondary' }}"
                                                                disabled>
                                                                A
                                                            </button>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm {{ isset($studentAnswers[$soal->id]) && $studentAnswers[$soal->id]->jawaban == 'B' ? 'btn-success' : 'btn-outline-secondary' }}"
                                                                disabled>
                                                                B
                                                            </button>
                                                        </div>
                                                        @if ($soal->opsi_c)
                                                            <div class="col-auto">
                                                                <button type="button"
                                                                    class="btn btn-sm {{ isset($studentAnswers[$soal->id]) && $studentAnswers[$soal->id]->jawaban == 'C' ? 'btn-success' : 'btn-outline-secondary' }}"
                                                                    disabled>
                                                                    C
                                                                </button>
                                                            </div>
                                                        @endif
                                                        @if ($soal->opsi_d)
                                                            <div class="col-auto">
                                                                <button type="button"
                                                                    class="btn btn-sm {{ isset($studentAnswers[$soal->id]) && $studentAnswers[$soal->id]->jawaban == 'D' ? 'btn-success' : 'btn-outline-secondary' }}"
                                                                    disabled>
                                                                    D
                                                                </button>
                                                            </div>
                                                        @endif
                                                        @if ($soal->opsi_e)
                                                            <div class="col-auto">
                                                                <button type="button"
                                                                    class="btn btn-sm {{ isset($studentAnswers[$soal->id]) && $studentAnswers[$soal->id]->jawaban == 'E' ? 'btn-success' : 'btn-outline-secondary' }}"
                                                                    disabled>
                                                                    E
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @elseif($soal->tipe_soal == 'benar_salah')
                                                    <div class="ms-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" disabled
                                                                {{ isset($studentAnswers[$soal->id]) && $studentAnswers[$soal->id]->jawaban == 'Benar' ? 'checked' : '' }}>
                                                            <label class="form-check-label">Benar</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" disabled
                                                                {{ isset($studentAnswers[$soal->id]) && $studentAnswers[$soal->id]->jawaban == 'Salah' ? 'checked' : '' }}>
                                                            <label class="form-check-label">Salah</label>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="ms-3">
                                                        <strong>Jawaban Siswa:</strong>
                                                        <div class="border rounded p-2 bg-light">
                                                            {{ isset($studentAnswers[$soal->id]) ? $studentAnswers[$soal->id]->jawaban : 'Tidak dijawab' }}
                                                        </div>
                                                        @if ($soal->tipe_soal == 'essay' && isset($studentAnswers[$soal->id]))
                                                            @if ($studentAnswers[$soal->id]->is_graded)
                                                                <div class="mt-2">
                                                                    <span class="badge bg-success">
                                                                        <i class="fas fa-check-circle me-1"></i>
                                                                        Nilai:
                                                                        {{ $studentAnswers[$soal->id]->manual_score }}/{{ $soal->bobot }}
                                                                    </span>
                                                                    @if ($studentAnswers[$soal->id]->admin_notes)
                                                                        <div class="mt-1">
                                                                            <small class="text-muted">
                                                                                <strong>Catatan:</strong>
                                                                                {{ $studentAnswers[$soal->id]->admin_notes }}
                                                                            </small>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <div class="mt-2">
                                                                    <span class="badge bg-warning">
                                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                                        Belum dinilai
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <!-- KUNCI JAWABAN -->
                                                <small class="text-muted d-block mb-1">Kunci Jawaban</small>
                                                <div class="d-flex align-items-center justify-content-between gap-3">

                                                    <!-- KUNCI JAWABAN -->
                                                    <div class="p-2 border rounded bg-light fw-semibold flex-grow-1">
                                                        {{ $soal->kunci_jawaban }}
                                                    </div>

                                                    <!-- STATUS NILAI -->
                                                    @if (isset($studentAnswers[$soal->id]))
                                                        @php
                                                            $answerRecord = $studentAnswers[$soal->id];
                                                            $score = 0;
                                                            $status = 'Salah';
                                                            $badgeClass = 'danger';
                                                            $icon = 'times';

                                                            if ($soal->tipe_soal == 'essay') {
                                                                if (
                                                                    $answerRecord->is_graded &&
                                                                    $answerRecord->manual_score !== null
                                                                ) {
                                                                    $score = $answerRecord->manual_score;
                                                                    $status = $score > 0 ? 'Benar' : 'Salah';
                                                                    $badgeClass = $score > 0 ? 'success' : 'danger';
                                                                    $icon = $score > 0 ? 'check' : 'times';
                                                                } else {
                                                                    $status = 'Belum Dinilai';
                                                                    $badgeClass = 'warning';
                                                                    $icon = 'clock';
                                                                }
                                                            } else {
                                                                if (
                                                                    strtolower($answerRecord->jawaban) ==
                                                                    strtolower($soal->kunci_jawaban)
                                                                ) {
                                                                    $score = $soal->bobot;
                                                                    $status = 'Benar';
                                                                    $badgeClass = 'success';
                                                                    $icon = 'check';
                                                                }
                                                            }
                                                        @endphp

                                                        <div
                                                            class="alert alert-{{ $badgeClass }} d-flex align-items-center py-1 px-3 mb-0">
                                                            <i class="fas fa-{{ $icon }} me-2"></i>
                                                            <strong class="me-1">{{ $status }}</strong>
                                                            <span>({{ $score }} poin)</span>
                                                        </div>
                                                    @else
                                                        <div
                                                            class="alert alert-secondary d-flex align-items-center py-1 px-3 mb-0">
                                                            <i class="fas fa-minus me-2"></i>
                                                            <strong>Tidak Dijawab</strong>
                                                            <span class="ms-1">(0 poin)</span>
                                                        </div>
                                                    @endif

                                                </div>
                                                @if ($soal->pembahasan)
                                                    <div class="mt-3">
                                                        <small class="text-muted d-block mb-1">Pembahasan</small>
                                                        <div class="p-2 border rounded bg-white" style="line-height:1.6;">
                                                            {!! $soal->pembahasan !!}
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
