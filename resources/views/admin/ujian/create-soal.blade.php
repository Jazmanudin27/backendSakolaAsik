@extends('layouts.app')

@php
    $userRole = 'admin';
    if (Auth::guard('guru')->check()) {
        $userRole = 'guru';
    }
@endphp

@section('titlepage', 'Tambah Soal Ujian')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Tambah Soal Ujian</h1>
                        <p class="text-muted mb-0">Ujian: {{ $ujian->kode_ujian }} - {{ $ujian->mapel->nama_mapel }}
                        </p>
                    </div>
                    <a href="{{ route($userRole . '.ujian.show', $ujian->id) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-danger d-flex align-items-start" role="alert">
                        <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                        <div>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form Card -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="btn btn-success btn-lg rounded-circle">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="card-title mb-0">Buat Soal Baru</h5>
                                <small class="text-muted">Tambahkan soal untuk ujian ini</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($userRole . '.ujian.store-soal', $ujian->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Question Section -->
                                <div class="col-12">
                                    <div class="mb-4">
                                        <label for="soal_editor" class="form-label fw-semibold">
                                            <i class="fas fa-edit me-2 text-success"></i>
                                            Soal <span class="text-danger">*</span>
                                        </label>
                                        <div class="border rounded">
                                            <textarea id="soal_editor" name="soal_editor" rows="8" class="form-control border-0" style="height: 300px;">{{ old('soal_editor') }}</textarea>
                                        </div>
                                        <input type="hidden" id="soal" name="soal" value="{{ old('soal') }}">
                                        @error('soal')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                        <small class="text-muted">Editor mendukung: Gambar, Persamaan Matematika (LaTeX),
                                            Format Teks, Tabel, dan lainnya</small>
                                    </div>

                                    <!-- Image Upload Section -->
                                    <div class="mb-4">
                                        <label for="gambar_soal" class="form-label fw-semibold">
                                            <i class="fas fa-image me-2 text-warning"></i>
                                            Upload Gambar Soal
                                        </label>
                                        <input type="file"
                                            class="form-control @error('gambar_soal') is-invalid @enderror" id="gambar_soal"
                                            name="gambar_soal" accept="image/*">
                                        @error('gambar_soal')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                        <small class="text-muted">Format: JPG, PNG, GIF. Maksimal: 2MB</small>

                                        @if (old('gambar_soal_preview'))
                                            <div class="mt-2">
                                                <img src="{{ old('gambar_soal_preview') }}" alt="Preview"
                                                    class="img-thumbnail" style="max-height: 200px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Type and Settings -->
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <label for="tipe_soal" class="form-label fw-semibold">
                                            <i class="fas fa-list-alt me-2 text-success"></i>
                                            Tipe Soal <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-clipboard-list"></i>
                                            </span>
                                            <select class="form-select @error('tipe_soal') is-invalid @enderror"
                                                id="tipe_soal" name="tipe_soal" required onchange="toggleOpsi()">
                                                <option value="">-- Pilih Tipe Soal --</option>
                                                <option value="pilihan_ganda"
                                                    {{ old('tipe_soal') == 'pilihan_ganda' ? 'selected' : '' }}>
                                                    Pilihan Ganda</option>
                                                <option value="essay" {{ old('tipe_soal') == 'essay' ? 'selected' : '' }}>
                                                    Essay</option>
                                                <option value="benar_salah"
                                                    {{ old('tipe_soal') == 'benar_salah' ? 'selected' : '' }}>
                                                    Benar/Salah</option>
                                                <option value="isian_singkat"
                                                    {{ old('tipe_soal') == 'isian_singkat' ? 'selected' : '' }}>
                                                    Isian Singkat</option>
                                            </select>
                                        </div>
                                        @error('tipe_soal')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <label for="bobot" class="form-label fw-semibold">
                                            <i class="fas fa-star me-2 text-success"></i>
                                            Bobot Soal <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-star"></i>
                                            </span>
                                            <input type="number" class="form-control @error('bobot') is-invalid @enderror"
                                                id="bobot" name="bobot" value="{{ old('bobot', 1) }}" min="1"
                                                max="100" required>
                                            <span class="input-group-text">poin</span>
                                        </div>
                                        @error('bobot')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                        <small class="text-muted">Bobot maksimal 100 poin</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <label for="tingkat_kesulitan" class="form-label fw-semibold">
                                            <i class="fas fa-signal me-2 text-success"></i>
                                            Tingkat Kesulitan <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-tachometer-alt"></i>
                                            </span>
                                            <select class="form-select @error('tingkat_kesulitan') is-invalid @enderror"
                                                id="tingkat_kesulitan" name="tingkat_kesulitan" required>
                                                <option value="mudah"
                                                    {{ old('tingkat_kesulitan') == 'mudah' ? 'selected' : '' }}>
                                                    🟢 Mudah</option>
                                                <option value="sedang"
                                                    {{ old('tingkat_kesulitan') == 'sedang' ? 'selected' : '' }}>
                                                    🟡 Sedang</option>
                                                <option value="sulit"
                                                    {{ old('tingkat_kesulitan') == 'sulit' ? 'selected' : '' }}>
                                                    🔴 Sulit</option>
                                            </select>
                                        </div>
                                        @error('tingkat_kesulitan')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Options Section -->
                                <div class="col-md-6">
                                    <div id="opsi-container">
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold">
                                                <i class="fas fa-check-square me-2 text-success"></i>
                                                Opsi Jawaban (Pilihan Ganda)
                                            </label>
                                            <div class="row">
                                                <div class="col-6 mb-2">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-success text-white">A</span>
                                                        <input type="text"
                                                            class="form-control @error('opsi_a') is-invalid @enderror"
                                                            id="opsi_a" name="opsi_a" value="{{ old('opsi_a') }}"
                                                            placeholder="Opsi A">
                                                    </div>
                                                    @error('opsi_a')
                                                        <div class="invalid-feedback">
                                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 mb-2">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-success text-white">B</span>
                                                        <input type="text"
                                                            class="form-control @error('opsi_b') is-invalid @enderror"
                                                            id="opsi_b" name="opsi_b" value="{{ old('opsi_b') }}"
                                                            placeholder="Opsi B">
                                                    </div>
                                                    @error('opsi_b')
                                                        <div class="invalid-feedback">
                                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 mb-2">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-success text-white">C</span>
                                                        <input type="text"
                                                            class="form-control @error('opsi_c') is-invalid @enderror"
                                                            id="opsi_c" name="opsi_c" value="{{ old('opsi_c') }}"
                                                            placeholder="Opsi C">
                                                    </div>
                                                    @error('opsi_c')
                                                        <div class="invalid-feedback">
                                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 mb-2">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-success text-white">D</span>
                                                        <input type="text"
                                                            class="form-control @error('opsi_d') is-invalid @enderror"
                                                            id="opsi_d" name="opsi_d" value="{{ old('opsi_d') }}"
                                                            placeholder="Opsi D">
                                                    </div>
                                                    @error('opsi_d')
                                                        <div class="invalid-feedback">
                                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 mb-2">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-success text-white">E</span>
                                                        <input type="text"
                                                            class="form-control @error('opsi_e') is-invalid @enderror"
                                                            id="opsi_e" name="opsi_e" value="{{ old('opsi_e') }}"
                                                            placeholder="Opsi E">
                                                    </div>
                                                    @error('opsi_e')
                                                        <div class="invalid-feedback">
                                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <small class="text-muted">Opsi A dan B wajib diisi untuk tipe soal Pilihan
                                                Ganda</small>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="kunci_jawaban" class="form-label fw-semibold">
                                            <i class="fas fa-key me-2 text-success"></i>
                                            Kunci Jawaban <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="text"
                                                class="form-control @error('kunci_jawaban') is-invalid @enderror"
                                                id="kunci_jawaban" name="kunci_jawaban"
                                                value="{{ old('kunci_jawaban') }}" placeholder="Jawaban yang benar"
                                                required>
                                        </div>
                                        @error('kunci_jawaban')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                        <small class="text-muted">Untuk Pilihan Ganda: A/B/C/D/E, Untuk Essay: jawaban
                                            lengkap</small>
                                    </div>
                                </div>

                                <!-- Explanation Section -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label for="pembahasan" class="form-label fw-semibold">
                                                <i class="fas fa-lightbulb me-2 text-success"></i>
                                                Pembahasan
                                            </label>
                                            <textarea class="form-control @error('pembahasan') is-invalid @enderror" id="pembahasan" name="pembahasan"
                                                rows="3" placeholder="Tuliskan pembahasan soal...">{{ old('pembahasan') }}</textarea>
                                            @error('pembahasan')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                            <small class="text-muted">Opsional: tambahkan pembahasan untuk membantu siswa
                                                memahami</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                            <div class="text-muted">
                                                <small>
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Pastikan semua data yang ditandai * sudah diisi dengan benar
                                                </small>
                                            </div>
                                            <div class="btn-group">
                                                <a href="{{ route($userRole . '.ujian.show', $ujian->id) }}"
                                                    class="btn btn-secondary">
                                                    <i class="fas fa-times me-2"></i>Batal
                                                </a>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fas fa-save me-2"></i>Simpan Soal
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Load TinyMCE from CDN without API key requirement -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.css">

    <script>
        console.log('Scripts section loaded...');

        function toggleOpsi() {
            var tipeSoal = document.getElementById('tipe_soal').value;
            var opsiContainer = document.getElementById('opsi-container');

            if (tipeSoal === 'pilihan_ganda') {
                opsiContainer.style.display = 'block';
            } else {
                opsiContainer.style.display = 'none';
            }
        }

        // TinyMCE initialization function
        function initTinyMCE() {
            console.log('Initializing TinyMCE...');
            console.log('TinyMCE available:', typeof tinymce !== 'undefined');

            // Check if TinyMCE is loaded
            if (typeof tinymce !== 'undefined') {
                console.log('TinyMCE is available, initializing...');

                // Initialize TinyMCE with simple configuration
                tinymce.init({
                    selector: '#soal_editor',
                    height: 400,
                    menubar: true,
                    plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen',
                        'insertdatetime media table paste code help wordcount'
                    ],
                    toolbar: 'undo redo | formatselect | bold italic | \
                        alignleft aligncenter alignright alignjustify | \
                        bullist numlist outdent indent | removeformat | help | \
                        image | code',
                    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
                });
            } else {
                console.error('TinyMCE failed to load');
                alert('Editor tidak dapat dimuat. Menggunakan textarea biasa.');

                // Show the textarea as fallback
                var textarea = document.getElementById('soal_editor');
                if (textarea) {
                    textarea.style.display = 'block';
                    textarea.style.height = '300px';
                }
            }
        }

        // Simple initialization - call immediately when script loads
        console.log('Script loaded, initializing TinyMCE...');
        initTinyMCE();

        // Image preview
        document.getElementById('gambar_soal').addEventListener('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.createElement('div');
                    preview.className = 'mt-2';
                    preview.innerHTML = '<img src="' + e.target.result +
                        '" alt="Preview" class="img-thumbnail" style="max-height: 200px;">';

                    var existingPreview = e.target.parentNode.querySelector('.mt-2');
                    if (existingPreview && !existingPreview.querySelector('img[src*="storage"]')) {
                        existingPreview.remove();
                    }

                    e.target.parentNode.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleOpsi();
        });
    </script>
@endsection
