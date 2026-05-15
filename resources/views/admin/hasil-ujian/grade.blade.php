@extends('layouts.app')

@php
    $userRole = 'admin';
    if (Auth::guard('guru')->check()) {
        $userRole = 'guru';
    }
@endphp

@section('titlepage', 'Penilaian Jawaban Esai')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Penilaian Jawaban Esai</h1>
                        <p class="text-muted mb-0">Beri nilai untuk jawaban esai siswa</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route($userRole . '.hasil-ujian.show', $jawabanSiswa->id) }}"
                            class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student & Exam Info -->
        <div class="row mb-4">
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
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>NIS:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $jawabanSiswa->siswa->nis }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>Kelas:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $jawabanSiswa->ujian->kelas->nama_kelas }}
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
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>Mata Pelajaran:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $jawabanSiswa->ujian->mapel->nama_mapel }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>Tanggal:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $jawabanSiswa->ujian->tanggal_ujian->format('d F Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Essay Questions Grading -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Soal Esai untuk Dinilai</h5>
                            <div class="text-muted">
                                <small>{{ $essayQuestions->count() }} soal esai</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST"
                            action="{{ route($userRole . '.hasil-ujian.save-grades', $jawabanSiswa->id) }}">
                            @csrf

                            @forelse($essayQuestions as $index => $question)
                                <div class="border rounded mb-4 p-4">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-start mb-3">
                                                <span class="badge bg-primary me-2">{{ $index + 1 }}</span>
                                                <div class="flex-grow-1">
                                                    <div class="fw-semibold mb-2">
                                                        Soal Esai
                                                        <span class="badge bg-warning ms-2">{{ $question->bobot }}
                                                            poin</span>
                                                        <span
                                                            class="badge bg-info ms-2">{{ $question->tingkat_kesulitan }}</span>
                                                    </div>
                                                    <div class="mb-3">
                                                        {!! $question->soal !!}
                                                    </div>

                                                    <div class="mb-3">
                                                        <strong>Jawaban Siswa:</strong>
                                                        <div class="border rounded p-3 bg-light">
                                                            @if ($question->detailJawabanSiswa->isNotEmpty())
                                                                {{ $question->detailJawabanSiswa->first()->jawaban }}
                                                            @else
                                                                <em class="text-muted">Siswa tidak menjawab soal ini</em>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    @if ($question->pembahasan)
                                                        <div class="mb-3">
                                                            <small class="text-muted">
                                                                <strong>Pembahasan/Petunjuk:</strong><br>
                                                                {!! $question->pembahasan !!}
                                                            </small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="border rounded p-3">
                                                <h6 class="mb-3">Penilaian</h6>

                                                @if ($question->detailJawabanSiswa->isNotEmpty())
                                                    @php
                                                        $answer = $question->detailJawabanSiswa->first();
                                                    @endphp

                                                    <div class="mb-3">
                                                        <label for="score_{{ $question->id }}" class="form-label">
                                                            <strong>Nilai (0 - {{ $question->bobot }}):</strong>
                                                        </label>
                                                        <input type="number" name="scores[{{ $question->id }}]"
                                                            id="score_{{ $question->id }}" class="form-control"
                                                            min="0" max="{{ $question->bobot }}" step="0.5"
                                                            value="{{ $answer->manual_score ?? 0 }}" required>
                                                        <small class="text-muted">Maksimal: {{ $question->bobot }}
                                                            poin</small>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="notes_{{ $question->id }}" class="form-label">
                                                            <strong>Catatan (Opsional):</strong>
                                                        </label>
                                                        <textarea name="notes[{{ $question->id }}]" id="notes_{{ $question->id }}" class="form-control" rows="3"
                                                            placeholder="Tambahkan catatan atau feedback untuk siswa...">{{ $answer->admin_notes ?? '' }}</textarea>
                                                    </div>

                                                    @if ($answer->is_graded)
                                                        <div class="alert alert-success py-2">
                                                            <small>
                                                                <i class="fas fa-check-circle me-1"></i>
                                                                Sudah dinilai pada {{ $answer->graded_at->format('d M Y H:i') }}
                                                            </small>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="alert alert-warning py-2">
                                                        <small>
                                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                                            Siswa tidak menjawab soal ini
                                                        </small>
                                                    </div>
                                                    <input type="hidden" name="scores[{{ $question->id }}]"
                                                        value="0">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-edit fa-3x mb-3 d-block"></i>
                                        <h5>Tidak ada soal esai</h5>
                                        <p>Ujian ini tidak memiliki soal esai atau siswa tidak menjawab soal esai</p>
                                    </div>
                                </div>
                            @endforelse

                            @if (
                                $essayQuestions->isNotEmpty() &&
                                    $essayQuestions->filter(function ($q) {
                                            return $q->detailJawabanSiswa->isNotEmpty();
                                        })->isNotEmpty())
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-2"></i>Simpan Nilai
                                    </button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Validate scores before submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const scoreInputs = document.querySelectorAll('input[name^="scores"]');
            let isValid = true;

            scoreInputs.forEach(input => {
                const maxScore = parseFloat(input.getAttribute('max'));
                const value = parseFloat(input.value);

                if (value < 0 || value > maxScore) {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Pastikan semua nilai berada dalam rentang yang valid!');
            }
        });

        // Auto-save functionality (optional enhancement)
        let autoSaveTimer;
        document.querySelectorAll('input[name^="scores"], textarea[name^="notes"]').forEach(element => {
            element.addEventListener('input', function() {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(function() {
                    // You could implement auto-save here
                    console.log('Auto-save triggered');
                }, 5000);
            });
        });
    </script>
@endsection
