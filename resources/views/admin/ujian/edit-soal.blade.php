@extends('layouts.app')

@php
    $userRole = 'admin';
    if (Auth::guard('guru')->check()) {
        $userRole = 'guru';
    }
@endphp

@section('titlepage', 'Edit Soal Ujian')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Edit Soal Ujian</h1>
                    <p class="text-muted mb-0">Ujian: {{ $ujian->kode_ujian }} - Soal
                        #{{ $loop->index ?? 1 }}</p>
                </div>
                <a href="{{ route($userRole . '.ujian.show', $ujian->id) }}"
                    class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-danger d-flex align-items-start" role="alert">
                    <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                    <div>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
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
                            <div class="btn btn-warning btn-lg rounded-circle">
                                <i class="fas fa-edit"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="card-title mb-0">Edit Soal</h5>
                            <small class="text-muted">Perbarui soal yang sudah ada</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form
                        action="{{ route($userRole . '.ujian.update-soal', [$ujian->id, $soal->id]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Question Section -->
                            <div class="col-12">
                                <div class="mb-4">
                                    <label for="soal" class="form-label fw-semibold">
                                        <i class="fas fa-question-circle me-2 text-warning"></i>
                                        Soal <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('soal') is-invalid @enderror" id="soal"
                                        name="soal" rows="4" placeholder="Tuliskan soal di sini..."
                                        required>{{ old('soal', $soal->soal) }}</textarea>
                                    @error('soal')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                    <small class="text-muted">Gunakan editor di bawah untuk soal yang kompleks, gambar,
                                        atau matematika</small>
                                </div>
                                
                                <!-- Image Upload Section -->
                                <div class="mb-4">
                                    <label for="gambar_soal" class="form-label fw-semibold">
                                        <i class="fas fa-image me-2 text-warning"></i>
                                        Upload Gambar Soal
                                    </label>
                                    <input type="file" class="form-control @error('gambar_soal') is-invalid @enderror"
                                        id="gambar_soal" name="gambar_soal" accept="image/*">
                                    @error('gambar_soal')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal: 2MB</small>
                                    
                                    @if($soal->gambar_soal)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $soal->gambar_soal) }}" alt="Current Image"
                                                class="img-thumbnail" style="max-height: 200px;">
                                            <br>
                                            <small class="text-muted">Gambar saat ini</small>
                                        </div>
                                    @endif
                                    
                                    @if(old('gambar_soal_preview'))
                                        <div class="mt-2">
                                            <img src="{{ old('gambar_soal_preview') }}" alt="Preview"
                                                class="img-thumbnail" style="max-height: 200px;">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Type and Settings -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="tipe_soal" class="form-label fw-semibold">
                                        <i class="fas fa-list-alt me-2 text-warning"></i>
                                        Tipe Soal <span class="text-danger">*</span>
                                    </label>
                                    <div class="mb-3">
                                        <select class="form-select select2 @error('tipe_soal') is-invalid @enderror"
                                            id="tipe_soal" name="tipe_soal" required onchange="toggleOpsi()">
                                            <option value="">-- Pilih Tipe Soal --</option>
                                            <option value="pilihan_ganda"
                                                {{ old('tipe_soal', $soal->tipe_soal) == 'pilihan_ganda' ? 'selected' : '' }}>
                                                Pilihan Ganda</option>
                                            <option value="essay"
                                                {{ old('tipe_soal', $soal->tipe_soal) == 'essay' ? 'selected' : '' }}>
                                                Essay</option>
                                            <option value="benar_salah"
                                                {{ old('tipe_soal', $soal->tipe_soal) == 'benar_salah' ? 'selected' : '' }}>
                                                Benar/Salah</option>
                                            <option value="isian_singkat"
                                                {{ old('tipe_soal', $soal->tipe_soal) == 'isian_singkat' ? 'selected' : '' }}>
                                                Isian Singkat</option>
                                        </select>
                                    </div>
                                    @error('tipe_soal')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="bobot" class="form-label fw-semibold">
                                        <i class="fas fa-weight me-2 text-warning"></i>
                                        Bobot Soal <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-star"></i>
                                        </span>
                                        <input type="number" class="form-control @error('bobot') is-invalid @enderror"
                                            id="bobot" name="bobot"
                                            value="{{ old('bobot', $soal->bobot) }}" min="1"
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

                                <div class="mb-4">
                                    <label for="tingkat_kesulitan" class="form-label fw-semibold">
                                        <i class="fas fa-signal me-2 text-warning"></i>
                                        Tingkat Kesulitan <span class="text-danger">*</span>
                                    </label>
                                    <div class="mb-3">
                                        <select class="form-select select2 @error('tingkat_kesulitan') is-invalid @enderror"
                                            id="tingkat_kesulitan" name="tingkat_kesulitan" required>
                                            <option value="mudah"
                                                {{ old('tingkat_kesulitan', $soal->tingkat_kesulitan) == 'mudah' ? 'selected' : '' }}>
                                                🟢 Mudah</option>
                                            <option value="sedang"
                                                {{ old('tingkat_kesulitan', $soal->tingkat_kesulitan) == 'sedang' ? 'selected' : '' }}>
                                                🟡 Sedang</option>
                                            <option value="sulit"
                                                {{ old('tingkat_kesulitan', $soal->tingkat_kesulitan) == 'sulit' ? 'selected' : '' }}>
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
                                            <i class="fas fa-check-square me-2 text-warning"></i>
                                            Opsi Jawaban (Pilihan Ganda)
                                        </label>
                                        <div class="row">
                                            <div class="col-6 mb-2">
                                                <div class="input-group">
                                                    <span class="input-group-text bg-warning text-dark">A</span>
                                                    <input type="text"
                                                        class="form-control @error('opsi_a') is-invalid @enderror"
                                                        id="opsi_a" name="opsi_a"
                                                        value="{{ old('opsi_a', $soal->opsi_a) }}"
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
                                                    <span class="input-group-text bg-warning text-dark">B</span>
                                                    <input type="text"
                                                        class="form-control @error('opsi_b') is-invalid @enderror"
                                                        id="opsi_b" name="opsi_b"
                                                        value="{{ old('opsi_b', $soal->opsi_b) }}"
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
                                                    <span class="input-group-text bg-warning text-dark">C</span>
                                                    <input type="text"
                                                        class="form-control @error('opsi_c') is-invalid @enderror"
                                                        id="opsi_c" name="opsi_c"
                                                        value="{{ old('opsi_c', $soal->opsi_c) }}"
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
                                                    <span class="input-group-text bg-warning text-dark">D</span>
                                                    <input type="text"
                                                        class="form-control @error('opsi_d') is-invalid @enderror"
                                                        id="opsi_d" name="opsi_d"
                                                        value="{{ old('opsi_d', $soal->opsi_d) }}"
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
                                                    <span class="input-group-text bg-warning text-dark">E</span>
                                                    <input type="text"
                                                        class="form-control @error('opsi_e') is-invalid @enderror"
                                                        id="opsi_e" name="opsi_e"
                                                        value="{{ old('opsi_e', $soal->opsi_e) }}"
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
                                        <i class="fas fa-key me-2 text-warning"></i>
                                        Kunci Jawaban <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="text"
                                            class="form-control @error('kunci_jawaban') is-invalid @enderror"
                                            id="kunci_jawaban" name="kunci_jawaban"
                                            value="{{ old('kunci_jawaban', $soal->kunci_jawaban) }}"
                                            placeholder="Jawaban yang benar" required>
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
                        </div>

                        <!-- Explanation Section -->
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-4">
                                    <label for="pembahasan" class="form-label fw-semibold">
                                        <i class="fas fa-lightbulb me-2 text-warning"></i>
                                        Pembahasan
                                    </label>
                                    <textarea class="form-control @error('pembahasan') is-invalid @enderror"
                                        id="pembahasan" name="pembahasan" rows="3"
                                        placeholder="Tuliskan pembahasan soal...">{{ old('pembahasan', $soal->pembahasan) }}</textarea>
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
                                            Perubahan akan disimpan dan langsung berlaku
                                        </small>
                                    </div>
                                    <div class="btn-group">
                                        <a href="{{ route($userRole . '.ujian.show', $ujian->id) }}"
                                            class="btn btn-secondary">
                                            <i class="fas fa-times me-2"></i>Batal
                                        </a>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-save me-2"></i>Update Soal
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

<style>
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: box-shadow 0.15s ease-in-out;
    }

    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
        min-width: 50px;
        text-align: center;
    }

    .form-control,
    .form-select {
        border-left: none;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }

</style>
@endsection

@section('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.css">
<script>
    function toggleOpsi() {
        var tipeSoal = document.getElementById('tipe_soal').value;
        var opsiContainer = document.getElementById('opsi-container');

        if (tipeSoal === 'pilihan_ganda') {
            opsiContainer.style.display = 'block';
        } else {
            opsiContainer.style.display = 'none';
        }
    }

    // Initialize TinyMCE with Math and Image support
    tinymce.init({
        selector: '#soal_editor',
        height: 300,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | bold italic backcolor | \
            alignleft aligncenter alignright alignjustify | \
            bullist numlist outdent indent | removeformat | help | \
            image | math',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        
        // Image upload configuration
        images_upload_url: '{{ route($userRole . '.ujian.upload-image') }}',
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '{{ route($userRole . '.ujian.upload-image') }}');
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

            xhr.onload = function () {
                if (xhr.status !== 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                var json = JSON.parse(xhr.responseText);
                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                success(json.location);
            };

            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        },
        
        // Custom math plugin
        setup: function (editor) {
            editor.ui.registry.addButton('math', {
                text: '∑',
                tooltip: 'Insert Math Equation',
                onAction: function () {
                    var mathText = prompt(
                        'Enter LaTeX equation (e.g., x = \\frac{-b \\pm \\sqrt{b^2-4ac}}{2a}):'
                        );
                    if (mathText) {
                        try {
                            var mathHtml = '<span class="math-equation" data-latex="' + mathText
                                .replace(/"/g, '&quot;') + '">$' + mathText + '$</span>';
                            editor.insertContent(mathHtml);
                        } catch (e) {
                            alert('Invalid LaTeX equation');
                        }
                    }
                }
            });
        }
    });

    // Image preview
    document.getElementById('gambar_soal').addEventListener('change', function (e) {
        var file = e.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
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
    document.addEventListener('DOMContentLoaded', function () {
        toggleOpsi();
    });

</script>
@endsection
