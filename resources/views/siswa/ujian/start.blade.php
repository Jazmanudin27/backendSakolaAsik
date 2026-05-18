@extends('layouts.app')

@section('titlepage', 'Ujian - ' . $ujian->kode_ujian)

@section('content')
    <div class="container-fluid p-0">
        <!-- Header dengan Timer -->
        <div class="row">
            <div class="col-md-12">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="mb-1">{{ $ujian->kode_ujian }}</h4>
                                <p class="mb-0">{{ $ujian->mapel->nama_mapel }} <br> {{ $ujian->jenis_ujian }}</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="timer-display">
                                    <i class="fas fa-clock me-2"></i>
                                    <span id="timer">{{ $ujian->durasi * 60 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if ($ujian->gambarSoals && $ujian->gambarSoals->count() > 0)
                            <!-- Tombol Navigasi Soal -->
                            <div class="p-2 d-flex flex-wrap gap-2 ">
                                @foreach ($ujian->gambarSoals as $index => $gambar)
                                    <button type="button" class="btn btn-md btn-primary btn-soal"
                                        data-index="{{ $index }}"
                                        data-image="{{ asset('storage/gambar_soal/' . $gambar->gambar_soal) }}"
                                        onclick="openSoalModal(this)">
                                        Soal Hal. {{ $index + 1 }}
                                    </button>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-image fa-3x mb-3 d-block"></i>
                                <p>Tidak ada soal</p>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <!-- Form Ujian -->
        <form id="ujianForm" method="POST" action="{{ route('siswa.ujian.selesai', $ujian->id) }}"
            class="needs-validation">
            @csrf
            <div class="row">
                <!-- Area Jawaban (Kanan) -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h6>Navigasi Soal:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($ujian->detailUjians as $index => $soal)
                                    <button type="button"
                                        class="btn btn-sm question-nav {{ $index == 0 ? 'btn-primary' : 'btn-outline-primary' }}"
                                        data-question="{{ $index }}" onclick="goToQuestion({{ $index }})"
                                        title="Soal {{ $index + 1 }} - {{ ucwords(str_replace('_', ' ', $soal->tipe_soal)) }}">
                                        {{ $index + 1 }}
                                    </button>
                                @endforeach
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Klik nomor soal untuk navigasi langsung. Tombol hijau = sudah dijawab.
                                </small>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-2">
                                <span id="">Soal Nomor</span>
                                <span id="questionNumber">1</span>.
                            </h5>
                            <div id="questionsContainer">
                                @foreach ($ujian->detailUjians as $index => $soal)
                                    <div class="question-item" data-question="{{ $index }}"
                                        style="display: {{ $index == 0 ? 'block' : 'none' }}">
                                        <input type="hidden" name="soal_ids[]" value="{{ $soal->id }}">
                                        @if ($soal->listening)
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">
                                                    <i class="fas fa-volume-up me-2"></i>Audio Listening
                                                </label>
                                                <audio controls class="w-100">
                                                    <source
                                                        src="{{ asset('storage/audio_listening/' . $soal->listening) }}"
                                                        type="audio/mpeg">
                                                    Browser Anda tidak mendukung elemen audio.
                                                </audio>
                                            </div>
                                        @endif
                                        @if ($soal->tipe_soal == 'pilihan_ganda')
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="jawaban_{{ $soal->id }}"
                                                            id="opsi_a_{{ $soal->id }}" value="A"
                                                            onchange="saveAnswer({{ $soal->id }}, 'A')">
                                                        <label class="form-check-label" for="opsi_a_{{ $soal->id }}">
                                                            A.
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="jawaban_{{ $soal->id }}"
                                                            id="opsi_b_{{ $soal->id }}" value="B"
                                                            onchange="saveAnswer({{ $soal->id }}, 'B')">
                                                        <label class="form-check-label" for="opsi_b_{{ $soal->id }}">
                                                            B.
                                                        </label>
                                                    </div>
                                                </div>
                                                @if ($soal->opsi_c)
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="jawaban_{{ $soal->id }}"
                                                                id="opsi_c_{{ $soal->id }}" value="C"
                                                                onchange="saveAnswer({{ $soal->id }}, 'C')">
                                                            <label class="form-check-label"
                                                                for="opsi_c_{{ $soal->id }}">
                                                                C
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($soal->opsi_d)
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="jawaban_{{ $soal->id }}"
                                                                id="opsi_d_{{ $soal->id }}" value="D"
                                                                onchange="saveAnswer({{ $soal->id }}, 'D')">
                                                            <label class="form-check-label"
                                                                for="opsi_d_{{ $soal->id }}">
                                                                D
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($soal->opsi_e)
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="jawaban_{{ $soal->id }}"
                                                                id="opsi_e_{{ $soal->id }}" value="E"
                                                                onchange="saveAnswer({{ $soal->id }}, 'E')">
                                                            <label class="form-check-label"
                                                                for="opsi_e_{{ $soal->id }}">
                                                                E
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Essay -->
                                        @elseif($soal->tipe_soal == 'essay')
                                            <div class="form-group">
                                                <textarea class="form-control" name="jawaban_{{ $soal->id }}" rows="4"
                                                    placeholder="Tulis jawaban Anda di sini..." onblur="saveAnswer({{ $soal->id }}, this.value)"></textarea>
                                            </div>

                                            <!-- Benar/Salah -->
                                        @elseif($soal->tipe_soal == 'benar_salah')
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    name="jawaban_{{ $soal->id }}" id="benar_{{ $soal->id }}"
                                                    value="Benar" onchange="saveAnswer({{ $soal->id }}, 'Benar')">
                                                <label class="form-check-label" for="benar_{{ $soal->id }}">
                                                    Benar
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    name="jawaban_{{ $soal->id }}" id="salah_{{ $soal->id }}"
                                                    value="Salah" onchange="saveAnswer({{ $soal->id }}, 'Salah')">
                                                <label class="form-check-label" for="salah_{{ $soal->id }}">
                                                    Salah
                                                </label>
                                            </div>

                                            <!-- Isian Singkat -->
                                        @elseif($soal->tipe_soal == 'isian_singkat')
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    name="jawaban_{{ $soal->id }}" placeholder="Jawaban singkat..."
                                                    onblur="saveAnswer({{ $soal->id }}, this.value)">
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <!-- Panel Kontrol (Dalam Card Jawaban) -->
                            <hr class="my-4">
                            <div class="row">
                                <!-- Progress & Navigasi -->
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6>Progress:</h6>
                                                <div class="progress">
                                                    <div id="progressBar" class="progress-bar" role="progressbar"
                                                        style="width: 0%">
                                                        0%
                                                    </div>
                                                </div>
                                                <small class="text-muted">Dijawab: <span id="answeredCount">0</span> /
                                                    {{ $ujian->detailUjians->count() }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6>Navigasi:</h6>
                                                <div class="btn-group w-100" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                        onclick="previousQuestion()" id="prevBtn" disabled>
                                                        <i class="fas fa-arrow-left me-2"></i>Sebelumnya
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                        onclick="nextQuestion()" id="nextBtn">
                                                        Selanjutnya<i class="fas fa-arrow-right ms-2"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Submit -->
                                <div class="col-md-12">
                                    <div class="btn-group w-100" role="group">
                                        <button type="submit" class="btn btn-sm btn-success"
                                            onclick="return confirmSubmit()">
                                            <i class="fas fa-check-circle me-2"></i>Selesai
                                        </button>
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            onclick="confirmCancel()">
                                            <i class="fas fa-times me-2"></i>Batal
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="soalModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gambar Soal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="soalImage" src="" class="img-fluid rounded">
                </div>

            </div>
        </div>
    </div>
    <script>
        function openSoalModal(el) {
            const image = el.getAttribute('data-image');

            document.getElementById('soalImage').src = image;

            const modalEl = document.getElementById('soalModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

            modal.show();
        }

        // Dynamic data from Laravel
        window.examData = {
            totalQuestions: {{ $ujian->detailUjians->count() }},
            timeLeft: {{ $remainingTime ?? $ujian->durasi * 60 }},
            questions: {!! json_encode($ujian->detailUjians) !!},
            questionIds: {!! json_encode($ujian->detailUjians->pluck('id')) !!},
            saveAnswerUrl: "{{ route('siswa.ujian.save-answer', $ujian->id) }}",
            existingAnswers: {!! isset($existingAnswers) ? json_encode($existingAnswers) : '[]' !!}
        };

        // Global variables
        let currentQuestion = 0;
        let totalQuestions = window.examData ? window.examData.totalQuestions : 0;
        let timerInterval;
        let timeLeft = window.examData ? window.examData.timeLeft : 0;
        let answers = {};

        // Utility functions
        const $ = (selector) => {
            if (typeof selector !== 'string') {
                return null;
            }
            if (selector === '#document' || selector === 'document') {
                return document;
            }
            try {
                return document.querySelector(selector);
            } catch (error) {
                return null;
            }
        };
        const $$ = (selector) => {
            if (typeof selector !== 'string') {
                console.error('Invalid selector passed to $$ function:', selector, 'Type:', typeof selector);
                return [];
            }
            try {
                return document.querySelectorAll(selector);
            } catch (error) {
                console.error('Error in querySelectorAll with selector:', selector, error);
                return [];
            }
        };

        // Load existing answers
        function loadExistingAnswers() {
            if (!window.examData?.existingAnswers) return;

            const existingAnswers = window.examData.existingAnswers;

            // Populate answers object
            Object.entries(existingAnswers).forEach(([questionId, answer]) => {
                answers[questionId] = answer;
            });

            // Populate form fields
            if (window.examData.questions?.length) {
                window.examData.questions.forEach((question) => {
                    const answer = existingAnswers[question.id];
                    if (answer !== undefined && answer !== null) {
                        const radioInput = $(`input[name="jawaban_${question.id}"][value="${answer}"]`);
                        if (radioInput) radioInput.checked = true;

                        const textInput = $(
                            `input[name="jawaban_${question.id}"], textarea[name="jawaban_${question.id}"]`);
                        if (textInput) textInput.value = answer;
                    }
                });
            }

            updateProgress();
        }

        function startTimer() {
            timerInterval = setInterval(function() {
                timeLeft--;
                updateTimerDisplay();

                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    alert('Waktu ujian habis! Ujian akan disubmit otomatis.');
                    document.getElementById('ujianForm').submit();
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            const hours = Math.floor(timeLeft / 3600);
            const minutes = Math.floor((timeLeft % 3600) / 60);
            const seconds = timeLeft % 60;

            let display = '';
            if (hours > 0) {
                display = hours + ':' + String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
            } else {
                display = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
            }

            document.getElementById('timer').textContent = display;

            // Change color when time is running out
            if (timeLeft < 300) { // 5 minutes
                document.getElementById('timer').classList.add('text-danger');
            }
        }

        // Navigation
        function goToQuestion(index) {
            // Hide all question items
            document.querySelectorAll('.question-item').forEach(item => {
                item.style.display = 'none';
            });

            // Show the selected question item
            const questionItem = document.querySelector(`.question-item[data-question="${index}"]`);
            if (questionItem) {
                questionItem.style.display = 'block';
            }

            // Update navigation buttons
            document.querySelectorAll('.question-nav').forEach(btn => {
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-primary');
            });

            const navButton = document.querySelector(`.question-nav[data-question="${index}"]`);
            if (navButton) {
                navButton.classList.remove('btn-outline-primary');
                navButton.classList.add('btn-primary');
            }

            currentQuestion = index;
            updateNavigationButtons();
            updateQuestionInfo();
        }

        function nextQuestion() {
            if (currentQuestion < totalQuestions - 1) {
                goToQuestion(currentQuestion + 1);
            }
        }

        function previousQuestion() {
            if (currentQuestion > 0) {
                goToQuestion(currentQuestion - 1);
            }
        }

        function updateNavigationButtons() {
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            if (prevBtn) {
                prevBtn.disabled = currentQuestion === 0;
            }

            if (nextBtn) {
                nextBtn.disabled = currentQuestion === totalQuestions - 1;
            }
        }

        function updateQuestionInfo() {
            const questionNumber = document.getElementById('questionNumber');
            const questionType = document.getElementById('questionType');

            if (questionNumber) {
                questionNumber.textContent = currentQuestion + 1;
            }

            let typeText = '';
            if (window.examData && window.examData.questions && window.examData.questions[currentQuestion]) {
                switch (window.examData.questions[currentQuestion].tipe_soal) {
                    case 'pilihan_ganda':
                        typeText = 'Pilihan Ganda';
                        break;
                    case 'essay':
                        typeText = 'Essay';
                        break;
                    case 'benar_salah':
                        typeText = 'Benar/Salah';
                        break;
                    case 'isian_singkat':
                        typeText = 'Isian Singkat';
                        break;
                }
            }

            if (questionType) {
                questionType.textContent = typeText;
            }
        }

        // Save answers
        function saveAnswer(soalId, jawaban) {
            answers[soalId] = jawaban;

            // Update navigation button color
            updateProgress();

            // Debug: Log the data being sent
            console.log('Saving answer:', {
                soalId: soalId,
                jawaban: jawaban,
                url: window.examData.saveAnswerUrl
            });

            // Auto save to server
            const formData = new FormData();
            formData.append('id_soal', soalId);
            formData.append('jawaban', jawaban);

            // Safe CSRF token retrieval
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                formData.append('_token', csrfToken.getAttribute('content'));
            }

            if (!window.examData || !window.examData.saveAnswerUrl) {
                console.error('Save answer URL not available');
                return;
            }

            fetch(window.examData.saveAnswerUrl, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response ok:', response.ok);

                    if (!response.ok) {
                        return response.text().then(text => {
                            console.error('Response text:', text);
                            throw new Error(`HTTP ${response.status}: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);

                    if (data.success) {
                        console.log('Answer saved successfully');
                        // Show success indicator
                        if (window.examData && window.examData.questionIds && Array.isArray(window.examData
                                .questionIds)) {
                            const questionIndex = window.examData.questionIds.indexOf(parseInt(soalId));
                            if (questionIndex !== -1) {
                                const btn = document.querySelector(`[data-question="${questionIndex}"]`);
                                if (btn) {
                                    btn.classList.add('btn-success');
                                    btn.classList.remove('btn-outline-primary');
                                }
                            }
                        }
                    } else {
                        console.error('Save failed:', data.error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal menyimpan jawaban: ' + (data.error || 'Unknown error'),
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error saving answer:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menyimpan jawaban: ' + error.message,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc3545'
                    });
                });
        }

        function saveAllAnswers() {
            // Save all current answers
            Object.keys(answers).forEach(soalId => {
                saveAnswer(soalId, answers[soalId]);
            });

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Semua jawaban berhasil disimpan!',
                confirmButtonText: 'OK',
                confirmButtonColor: '#28a745'
            });
        }

        function updateProgress() {
            const answered = Object.keys(answers).length;
            const percentage = Math.round((answered / totalQuestions) * 100);

            document.getElementById('progressBar').style.width = percentage + '%';
            document.getElementById('progressBar').textContent = percentage + '%';
            document.getElementById('answeredCount').textContent = answered;

            // Update navigation buttons
            Object.keys(answers).forEach(soalId => {
                const questionIndex = window.examData.questionIds.indexOf(parseInt(soalId));
                if (questionIndex !== -1) {
                    const btn = document.querySelector(`[data-question="${questionIndex}"]`);
                    if (btn && !btn.classList.contains('btn-success')) {
                        btn.classList.remove('btn-outline-primary');
                        btn.classList.add('btn-success');
                    }
                }
            });
        }

        function confirmSubmit() {
            const unanswered = totalQuestions - Object.keys(answers).length;

            // Temporarily disabled for testing
            // if (unanswered > 0) {
            //     Swal.fire({
            //         icon: 'warning',
            //         title: 'Perhatian!',
            //         text: `Anda masih memiliki ${unanswered} soal yang belum dijawab. Semua soal harus diisi sebelum dapat submit ujian.`,
            //         confirmButtonText: 'OK',
            //         confirmButtonColor: '#f59e0b'
            //     });
            //     return false;
            // }

            Swal.fire({
                icon: 'question',
                title: 'Konfirmasi Submit',
                text: 'Apakah Anda yakin ingin submit ujian? Jawaban tidak dapat diubah setelah submit.',
                showCancelButton: true,
                confirmButtonText: 'Ya, Submit',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form
                    document.getElementById('ujianForm').submit();
                }
            });

            return false; // Prevent default form submission
        }

        function confirmCancel() {
            const answered = Object.keys(answers).length;

            return Swal.fire({
                icon: 'warning',
                title: 'Konfirmasi Batal',
                text: `Apakah Anda yakin ingin membatalkan ujian? Anda sudah menjawab ${answered} dari ${totalQuestions} soal.`,
                showCancelButton: true,
                confirmButtonText: 'Ya, Batal',
                cancelButtonText: 'Lanjutkan',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#28a745'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('siswa.ujian.index') }}";
                }
            });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadExistingAnswers();
            startTimer();
            updateProgress();
            updateNavigationButtons();
            updateQuestionInfo();
        });

        // Prevent navigation and refresh during active exam
        window.addEventListener('beforeunload', function(e) {
            if (timeLeft > 0) {
                const answered = Object.keys(answers).length;
                const total = totalQuestions;

                if (answered < total) {
                    e.preventDefault();
                    e.returnValue =
                        'Ujian masih berlangsung! Semua jawaban akan hilang jika Anda meninggalkan halaman ini.';
                    return 'Ujian masih berlangsung! Semua jawaban akan hilang jika Anda meninggalkan halaman ini.';
                }
            }
        });

        // Prevent F5 refresh and back button during exam
        // document.addEventListener('keydown', function(e) {
        //     if ((e.keyCode === 116 || (e.ctrlKey && (e.keyCode === 82 || e.keyCode === 121)))) {
        //         if (timeLeft > 0) {
        //             e.preventDefault();
        //             Swal.fire({
        //                 icon: 'warning',
        //                 title: 'Refresh Dilarang!',
        //                 text: 'Tidak dapat merefresh halaman ujian yang sedang berlangsung. Gunakan tombol navigasi yang tersedia.',
        //                 confirmButtonText: 'OK',
        //                 confirmButtonColor: '#f59e0b'
        //             });
        //         }
        //     }
        // });

        // Prevent back button
        window.addEventListener('popstate', function(e) {
            if (timeLeft > 0) {
                e.preventDefault();
                history.pushState(null, null, location.href);
                Swal.fire({
                    icon: 'warning',
                    title: 'Navigasi Dilarang!',
                    text: 'Tidak dapat kembali ke halaman sebelumnya saat ujian sedang berlangsung.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#f59e0b'
                });
            }
        });
    </script>
@endsection
