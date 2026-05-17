@extends('layouts.app')

@section('titlepage', 'Tambah Kartu Ujian')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Tambah Kartu Ujian</h1>
                        <p class="text-muted mb-0">Buat kartu ujian baru</p>
                    </div>
                    <div>
                        <a href="{{ route($userRole . '.kartu-ujian.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="row">
            <div class="col-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route($userRole . '.kartu-ujian.store') }}" method="POST" autocomplete="off">
                            @csrf

                            <!-- Informasi Dasar -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-wrapper bg-primary text-white me-3">
                                            <i class="fas fa-id-card"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">Informasi Kartu Ujian</h5>
                                            <small class="text-muted">Data kartu ujian</small>
                                        </div>
                                    </div>
                                    <hr class="my-3">
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Nama Ujian <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="nama_ujian" class="form-control form-control-sm"
                                            placeholder="Masukkan nama ujian" value="{{ old('nama_ujian') }}" required>
                                        @error('nama_ujian')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Tahun Ajaran <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select select2" name="id_tahun_ajaran" required>
                                            <option value="">Pilih Tahun Ajaran</option>
                                            @foreach ($tahunAjaranList as $tahunAjaran)
                                                <option value="{{ $tahunAjaran->id }}"
                                                    {{ old('id_tahun_ajaran') == $tahunAjaran->id ? 'selected' : '' }}>
                                                    {{ $tahunAjaran->tahun_ajaran . ' - Semester ' . $tahunAjaran->semester }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_tahun_ajaran')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Kelas <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select select2" name="id_kelas" required>
                                            <option value="">Pilih Kelas</option>
                                            @foreach ($kelasList as $kelas)
                                                <option value="{{ $kelas->id }}"
                                                    {{ old('id_kelas') == $kelas->id ? 'selected' : '' }}>
                                                    {{ $kelas->nama_kelas }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_kelas')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <div>
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Field dengan tanda <span class="text-danger">*</span> wajib diisi
                                        </small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <a href="{{ route($userRole . '.kartu-ujian.index') }}"
                                            class="btn btn-sm btn-secondary btn-block me-2">
                                            <i class="fas fa-times me-2"></i>Batal
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-sm btn-primary  btn-block">
                                            <i class="fas fa-save me-2"></i>Simpan Kartu Ujian
                                        </button>
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
        .icon-wrapper {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .form-label {
            color: #495057;
            font-weight: 500;
        }

        hr {
            border-color: #e9ecef;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: box-shadow 0.15s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .btn {
            border-radius: 0.375rem;
            font-weight: 500;
        }
    </style>
@endsection
