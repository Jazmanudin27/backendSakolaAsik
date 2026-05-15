@extends('layouts.app')

@section('titlepage', 'Detail Ujian')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Detail Ujian</h1>
                        <p class="text-muted mb-0">Informasi lengkap ujian: {{ $ujian->kode_ujian }}</p>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('admin.ujian.create-soal', $ujian->id) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-plus me-2"></i>Tambah Soal
                        </a>
                        <a href="{{ route('admin.ujian.edit', $ujian->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Ujian
                        </a>
                        <a href="{{ route('admin.ujian.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ujian Info Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">{{ $ujian->kode_ujian }}</h5>
                                <p class="mb-0">Kode Ujian</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-barcode fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">{{ $ujian->durasi }}m</h5>
                                <p class="mb-0">Durasi</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-clock fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">{{ $ujian->detailUjians->count() }}</h5>
                                <p class="mb-0">Total Soal</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-question-circle fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">{{ $ujian->detailUjians->sum('bobot') }}</h5>
                                <p class="mb-0">Total Bobot</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-weight fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Detailed Information -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2 text-primary"></i>Informasi Umum
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <div>
                                    <div class="fw-semibold">Kode Ujian</div>
                                    <div class="text-muted">{{ $ujian->kode_ujian }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <div>
                                    <div class="fw-semibold">Tanggal Ujian</div>
                                    <div class="text-muted">
                                        {{ $ujian->tanggal_ujian ? $ujian->tanggal_ujian->format('d-m-Y') : 'Tanggal tidak ditentukan' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <div>
                                    <div class="fw-semibold">Tipe Ujian</div>
                                    <div>
                                        <button
                                            class="btn btn-sm btn-{{ $ujian->jenis_ujian == 'Ujian Tengah Semester' || $ujian->jenis_ujian == 'Ujian Akhir Semester' ? 'danger' : ($ujian->jenis_ujian == 'Ujian Tengah Tahun' || $ujian->jenis_ujian == 'Ujian Akhir Tahun' ? 'warning' : 'info') }}">
                                            {{ $ujian->jenis_ujian }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-start">
                                <div>
                                    <div class="fw-semibold">Keterangan</div>
                                    <div class="text-muted">
                                        {{ $ujian->keterangan ? $ujian->keterangan : 'Tidak ada keterangan' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-graduation-cap me-2 text-success"></i>Detail Akademik
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <div>
                                    <div class="fw-semibold">Tingkat</div>
                                    <div class="text-muted">{{ $ujian->tingkat }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <div>
                                    <div class="fw-semibold">Jurusan</div>
                                    <div class="text-muted">
                                        @if ($ujian->id_jurusan && is_array($ujian->id_jurusan))
                                            @php
                                                $jurusanIds = $ujian->id_jurusan;
                                                $jurusans = \App\Models\Jurusan::whereIn('id', $jurusanIds)->get();
                                            @endphp
                                            @if ($jurusans->count() > 0)
                                                {{ $jurusans->pluck('nama_jurusan')->implode(', ') }}
                                            @else
                                                Semua Jurusan
                                            @endif
                                        @else
                                            Semua Jurusan
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <div>
                                    <div class="fw-semibold">Mata Pelajaran</div>
                                    <div class="text-muted">{{ $ujian->mapel->nama_mapel }}
                                        ({{ $ujian->mapel->singkatan }})</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <div>
                                    <div class="fw-semibold">Tahun Pelajaran</div>
                                    <div class="text-muted">{{ $ujian->tahunPelajaran->tahun_ajaran }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-images me-2 text-info"></i>Gambar Soal
                            </h5>
                            <div class="text-muted">
                                <small>
                                    {{ $ujian->gambarSoals->count() }} gambar tersedia
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($ujian->gambarSoals->count() > 0)
                            <div class="row">
                                @foreach ($ujian->gambarSoals as $gambar)
                                    <div class="col-md-3 mb-3">
                                        <div class="card shadow-sm border-0">
                                            <a href="{{ asset('storage/gambar_soal/' . $gambar->gambar_soal) }}"
                                                target="_blank">
                                                <img src="{{ asset('storage/gambar_soal/' . $gambar->gambar_soal) }}"
                                                    class="card-img-top img-fluid" loading="lazy"
                                                    style="height: 220px; object-fit: cover;">
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-image fa-3x mb-3"></i>
                                <p class="mb-0">
                                    Belum ada gambar soal
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-question-circle me-2 text-info"></i>Daftar Soal Ujian
                            </h5>
                            <div class="d-flex align-items-center gap-2">
                                @if ($ujian->detailUjians->isNotEmpty())
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="confirmDeleteAllQuestions()">
                                        <i class="fas fa-trash-alt me-1"></i>Hapus Semua
                                    </button>
                                @endif
                                <div class="text-muted">
                                    <small>{{ $ujian->detailUjians->count() }} soal tersedia</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Generate Questions Section -->
                        <div class="mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">
                                        <i class="fas fa-magic me-2 text-warning"></i>Generate Soal Otomatis
                                    </h6>
                                    <form id="generateQuestionsForm" class="mb-3">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="questionCount" class="form-label fw-semibold">
                                                    Jumlah Soal <span class="text-danger">*</span>
                                                </label>
                                                <input type="number" class="form-control form-control-sm"
                                                    id="questionCount" name="questionCount" min="1"
                                                    max="100" value="30" required>
                                            </div>
                                            <div class="col-md-6 d-flex align-items-end">
                                                <button type="submit" class="btn btn-sm btn-warning w-100">
                                                    <i class="fas fa-cogs me-2"></i>Generate Soal
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="alert alert-info">
                                        <small class="mb-0">
                                            <i class="fas fa-info-circle me-1"></i>
                                            <strong>Catatan:</strong> Fitur ini akan membuat soal kosong dengan ID ujian
                                            yang sama.
                                            Soal yang sudah ada tidak akan terpengaruh. ID ujian akan di-looping sesuai
                                            jumlah yang dimasukkan.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @if ($ujian->detailUjians->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0" style="zoom:90%">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" style="width: 50px;">No</th>
                                                <th>Soal</th>
                                                <th class="text-center" style="width: 150px;">Kunci Jawaban</th>
                                                <th class="text-center" style="width: 120px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ujian->detailUjians as $index => $soal)
                                                <tr>
                                                    <td class="text-center">
                                                        <button
                                                            class="btn btn-sm btn-secondary">{{ $index + 1 }}</button>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-start">
                                                            <div class="flex-grow-1">
                                                                <div class="fw-semibold soal-text">
                                                                    {{ Str::limit(strip_tags($soal->soal), 100) }}
                                                                </div>
                                                                <small class="text-muted">
                                                                    @if ($soal->tipe_soal == 'pilihan_ganda')
                                                                        {{ $soal->opsi_a ? 'A, ' : '' }}{{ $soal->opsi_b ? 'B, ' : '' }}{{ $soal->opsi_c ? 'C, ' : '' }}{{ $soal->opsi_d ? 'D, ' : '' }}{{ $soal->opsi_e ? 'E' : '' }}
                                                                    @endif
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($soal->tipe_soal == 'essay')
                                                            <span class="text-muted">-</span>
                                                        @else
                                                            <form
                                                                action="{{ route($userRole . '.ujian.update-kunci', [$ujian->id, $soal->id]) }}"
                                                                method="POST" class="d-inline update-kunci-form">
                                                                @csrf
                                                                @method('PUT')
                                                                @if ($soal->tipe_soal == 'pilihan_ganda')
                                                                    <select name="kunci_jawaban"
                                                                        class="form-select select2">
                                                                        <option value="">-</option>
                                                                        <option value="A"
                                                                            {{ $soal->kunci_jawaban == 'A' ? 'selected' : '' }}>
                                                                            A</option>
                                                                        <option value="B"
                                                                            {{ $soal->kunci_jawaban == 'B' ? 'selected' : '' }}>
                                                                            B</option>
                                                                        <option value="C"
                                                                            {{ $soal->kunci_jawaban == 'C' ? 'selected' : '' }}>
                                                                            C</option>
                                                                        <option value="D"
                                                                            {{ $soal->kunci_jawaban == 'D' ? 'selected' : '' }}>
                                                                            D</option>
                                                                        <option value="E"
                                                                            {{ $soal->kunci_jawaban == 'E' ? 'selected' : '' }}>
                                                                            E</option>
                                                                    </select>
                                                                @elseif ($soal->tipe_soal == 'benar_salah')
                                                                    <select name="kunci_jawaban"
                                                                        class="form-select form-select-sm">
                                                                        <option value="">-</option>
                                                                        <option value="Benar"
                                                                            {{ $soal->kunci_jawaban == 'Benar' ? 'selected' : '' }}>
                                                                            Benar</option>
                                                                        <option value="Salah"
                                                                            {{ $soal->kunci_jawaban == 'Salah' ? 'selected' : '' }}>
                                                                            Salah</option>
                                                                    </select>
                                                                @elseif ($soal->tipe_soal == 'isian_singkat')
                                                                    <input type="text" name="kunci_jawaban"
                                                                        value="{{ $soal->kunci_jawaban ?? '' }}"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Kunci jawaban">
                                                                @else
                                                                    <input type="text" name="kunci_jawaban"
                                                                        value="{{ $soal->kunci_jawaban ?? '' }}"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Kunci jawaban">
                                                                @endif
                                                            </form>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <a href="{{ route($userRole . '.ujian.edit-soal', [$ujian->id, $soal->id]) }}"
                                                                class="btn btn-sm btn-warning" title="Edit Soal">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form
                                                                action="{{ route($userRole . '.ujian.destroy-soal', [$ujian->id, $soal->id]) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-danger delete"
                                                                    title="Hapus Soal"
                                                                    data-href="{{ route($userRole . '.ujian.destroy-soal', [$ujian->id, $soal->id]) }}">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        <h5>Belum ada soal</h5>
                                        <p>Ujian ini belum memiliki soal</p>
                                        <a href="{{ route($userRole . '.ujian.create-soal', $ujian->id) }}"
                                            class="btn btn-sm btn-secondary">
                                            <i class="fas fa-plus me-2"></i>Tambah Soal Pertama
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // GENERATE QUESTIONS AJAX
        $('#generateQuestionsForm').on('submit', function(e) {
            e.preventDefault();

            let questionCount = $('#questionCount').val();

            Swal.fire({
                title: 'Generate Soal?',
                text: `Akan membuat ${questionCount} soal baru`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Generate!',
                cancelButtonText: 'Batal'
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ route('admin.ujian.generate-questions', $ujian->id) }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            questionCount: questionCount
                        },

                        beforeSend: function() {

                            Swal.fire({
                                title: 'Loading...',
                                text: 'Sedang generate soal',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                        },

                        success: function(response) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message ??
                                    'Soal berhasil digenerate'
                            }).then(() => {
                                location.reload();
                            });

                        },

                        error: function(xhr) {

                            let message = 'Terjadi kesalahan';

                            if (xhr.responseJSON?.message) {
                                message = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: message
                            });

                        }
                    });

                }

            });
        });


        // DELETE ALL QUESTIONS
        function confirmDeleteAllQuestions() {

            Swal.fire({
                title: 'Hapus Semua Soal?',
                text: "Semua soal akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'

            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({

                        url: "{{ route('admin.ujian.delete-all-questions', $ujian->id) }}",
                        type: "POST",

                        data: {
                            _token: "{{ csrf_token() }}"
                        },

                        beforeSend: function() {

                            Swal.fire({
                                title: 'Loading...',
                                text: 'Sedang menghapus soal',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                        },

                        success: function(response) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message ??
                                    'Semua soal berhasil dihapus'
                            }).then(() => {
                                location.reload();
                            });

                        },

                        error: function(xhr) {

                            let message = 'Terjadi kesalahan';

                            if (xhr.responseJSON?.message) {
                                message = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: message
                            });

                        }

                    });

                }

            });

        }
    </script>
@endsection
