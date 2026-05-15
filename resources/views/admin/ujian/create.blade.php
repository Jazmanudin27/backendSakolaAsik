@extends('layouts.app')
@section('titlepage', 'Tambah Ujian')
@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Tambah Ujian Baru</h1>
                        <p class="text-muted mb-0">Buat jadwal ujian baru</p>
                    </div>
                    <a href="{{ route($userRole . '.ujian.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="btn btn-primary btn-lg rounded-circle">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="card-title mb-0">Informasi Ujian</h5>
                                <small class="text-muted">Isi data ujian dengan lengkap dan benar</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($userRole . '.ujian.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Informasi Dasar Ujian -->
                            <div class="card mb-4 border-light">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0 text-primary">
                                        <i class="fas fa-info-circle me-2"></i>Informasi Dasar Ujian
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label for="kode_ujian" class="form-label fw-semibold">
                                                    <i class="fas fa-barcode me-2 text-primary"></i>
                                                    Kode Ujian <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-tag"></i>
                                                    </span>
                                                    <input type="text"
                                                        class="form-control form-control-sm @error('kode_ujian') is-invalid @enderror"
                                                        id="kode_ujian" name="kode_ujian" value="{{ old('kode_ujian') }}"
                                                        placeholder="Kode ujian otomatis" readonly required>
                                                </div>
                                                @error('kode_ujian')
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label for="id_sekolah" class="form-label fw-semibold">
                                                    <i class="fas fa-school me-2 text-primary"></i>
                                                    Sekolah <span class="text-danger">*</span>
                                                </label>
                                                <select
                                                    class="form-select select2 @error('id_sekolah') is-invalid @enderror"
                                                    id="id_sekolah" name="id_sekolah" required>
                                                    <option value="">-- Pilih Sekolah --</option>
                                                    @if (isset($sekolahs))
                                                        @foreach ($sekolahs as $sekolah)
                                                            <option value="{{ $sekolah->kode_sekolah }}"
                                                                {{ old('id_sekolah') == $sekolah->kode_sekolah ? 'selected' : '' }}>
                                                                {{ $sekolah->nama_sekolah }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('id_sekolah')
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Ujian -->
                            <div class="card mb-4 border-light">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0 text-primary">
                                        <i class="fas fa-calendar-check me-2"></i>Detail Ujian
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label for="tanggal_ujian" class="form-label fw-semibold">
                                                    <i class="fas fa-calendar me-2 text-primary"></i>
                                                    Tanggal Ujian <span class="text-danger">*</span>
                                                </label>
                                                <input type="date"
                                                    class="form-control form-control-sm @error('tanggal_ujian') is-invalid @enderror"
                                                    id="tanggal_ujian" name="tanggal_ujian"
                                                    value="{{ old('tanggal_ujian') }}" required>
                                                @error('tanggal_ujian')
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label for="durasi" class="form-label fw-semibold">
                                                    <i class="fas fa-hourglass-half me-2 text-primary"></i>
                                                    Durasi (menit) <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="number"
                                                        class="form-control form-control-sm @error('durasi') is-invalid @enderror"
                                                        id="durasi" name="durasi" value="{{ old('durasi', 90) }}"
                                                        min="1" max="480" required>
                                                </div>
                                                @error('durasi')
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                                <small class="text-muted">Maksimal 480 menit (8 jam)</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label for="status" class="form-label fw-semibold">
                                                    <i class="fas fa-toggle-on me-2 text-primary"></i>
                                                    Status Ujian <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select select2 @error('status') is-invalid @enderror"
                                                    id="status" name="status" required>
                                                    <option value="">-- Pilih Status --</option>
                                                    <option value="Draft"
                                                        {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                                                    <option value="Aktif"
                                                        {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="Selesai"
                                                        {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="Dibatalkan"
                                                        {{ old('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan
                                                    </option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Akademik & Jurusan -->
                            <div class="card mb-4 border-light">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0 text-primary">
                                        <i class="fas fa-graduation-cap me-2"></i>Informasi Akademik & Jurusan
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label for="tingkat" class="form-label fw-semibold">
                                                    <i class="fas fa-layer-group me-2 text-primary"></i>
                                                    Tingkat <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select select2 @error('tingkat') is-invalid @enderror"
                                                    id="tingkat" name="tingkat" required>
                                                    <option value="">-- Pilih Tingkat --</option>
                                                    <option value="VII">VII</option>
                                                    <option value="VIII">VIII</option>
                                                    <option value="IX">IX</option>
                                                    <option value="X">X</option>
                                                    <option value="XI">XI</option>
                                                    <option value="XII">XII</option>
                                                </select>
                                                @error('tingkat')
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-2">
                                                <label for="mapel_id" class="form-label fw-semibold">
                                                    <i class="fas fa-book me-2 text-primary"></i>
                                                    Mata Pelajaran <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select select2 @error('mapel_id') is-invalid @enderror"
                                                    id="mapel_id" name="id_mapel" required>

                                                    <option value="">-- Pilih Mata Pelajaran --</option>

                                                    @foreach ($mapels as $mapel)
                                                        <option value="{{ $mapel->id }}"
                                                            data-singkatan="{{ $mapel->singkatan }}"
                                                            {{ old('mapel_id') == $mapel->id ? 'selected' : '' }}>

                                                            {{ $mapel->nama_mapel }} ({{ $mapel->singkatan }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('mapel_id')
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>


                                            <div class="mb-2">
                                                <label for="type_ujian" class="form-label fw-semibold">
                                                    <i class="fas fa-list-alt me-2 text-primary"></i>
                                                    Tipe Ujian <span class="text-danger">*</span>
                                                </label>
                                                <select
                                                    class="form-select select2 @error('type_ujian') is-invalid @enderror"
                                                    id="type_ujian" name="jenis_ujian" required>
                                                    <option value="">-- Pilih Tipe Ujian --</option>
                                                    <option value="Ujian Tengah Semester"
                                                        {{ old('jenis_ujian') == 'Ujian Tengah Semester' ? 'selected' : '' }}>
                                                        Ujian Tengah Semester</option>
                                                    <option value="Ujian Akhir Semester"
                                                        {{ old('jenis_ujian') == 'Ujian Akhir Semester' ? 'selected' : '' }}>
                                                        Ujian Akhir Semester</option>
                                                    <option value="Ujian Tengah Tahun"
                                                        {{ old('jenis_ujian') == 'Ujian Tengah Tahun' ? 'selected' : '' }}>
                                                        Ujian Tengah Tahun</option>
                                                    <option value="Ujian Akhir Tahun"
                                                        {{ old('jenis_ujian') == 'Ujian Akhir Tahun' ? 'selected' : '' }}>
                                                        Ujian Akhir Tahun</option>
                                                    <option value="Ujian Nasional"
                                                        {{ old('jenis_ujian') == 'Ujian Nasional' ? 'selected' : '' }}>
                                                        Ujian Nasional</option>
                                                </select>
                                                @error('type_ujian')
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label for="tahun_pelajaran_id" class="form-label fw-semibold">
                                                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                                    Tahun Pelajaran <span class="text-danger">*</span>
                                                </label>
                                                <select
                                                    class="form-select select2 @error('tahun_pelajaran_id') is-invalid @enderror"
                                                    id="tahun_pelajaran_id" name="id_tahun_ajaran" required>
                                                    <option value="">-- Pilih Tahun Pelajaran --</option>
                                                    @foreach ($tahunAjarans as $ta)
                                                        <option value="{{ $ta->id }}"
                                                            {{ old('tahun_pelajaran_id') == $ta->id ? 'selected' : '' }}>
                                                            {{ $ta->tahun_ajaran }} - {{ $ta->semester }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('tahun_pelajaran_id')
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <!-- Jurusan Selection -->
                                            <div class="mb-2">
                                                <label class="form-label fw-semibold">
                                                    <i class="fas fa-users me-2 text-primary"></i>
                                                    Jurusan (Multi-Select)
                                                </label>
                                                <div class="border rounded p-3 bg-light">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="select_all_jurusan">
                                                        <label class="form-check-label" for="select_all_jurusan">
                                                            <strong>Pilih Semua</strong>
                                                        </label>
                                                    </div>
                                                    <div class="row">
                                                        @foreach ($jurusans as $jurusan)
                                                            <div class="col-md-6 mb-2">
                                                                <div class="form-check">
                                                                    <input
                                                                        class="form-check-input jurusan-checkbox @error('id_jurusan') is-invalid @enderror"
                                                                        type="checkbox" name="id_jurusan[]"
                                                                        value="{{ $jurusan->id }}"
                                                                        id="jurusan_{{ $jurusan->id }}"
                                                                        {{ in_array($jurusan->id, old('id_jurusan', [])) ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="jurusan_{{ $jurusan->id }}">
                                                                        {{ $jurusan->nama_jurusan }}
                                                                        ({{ $jurusan->singkatan }})
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @error('id_jurusan')
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                                <small class="text-muted">Pilih satu atau lebih jurusan yang dapat
                                                    mengikuti ujian ini. Kosongkan jika untuk semua jurusan.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4 border-light">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0 text-primary"> <i class="fas fa-images me-2"></i>Upload Gambar Soal
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3"> <label class="form-label fw-semibold"> Gambar Soal </label>
                                        <input type="file" name="gambar_soal[]" id="gambar_soal" multiple
                                            accept="image/*" class="form-control"> <small class="text-muted"> Bisa upload
                                            banyak gambar sekaligus </small>
                                    </div>
                                    <div class="row" id="preview_gambar"></div>
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="card mb-4 border-light">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0 text-primary">
                                        <i class="fas fa-comment me-2"></i>Keterangan Tambahan
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <label for="keterangan" class="form-label fw-semibold">
                                            <i class="fas fa-info-circle me-2 text-primary"></i>
                                            Keterangan
                                        </label>
                                        <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan"
                                            rows="3" placeholder="Tambahkan keterangan atau informasi tambahan tentang ujian...">{{ old('keterangan') }}</textarea>
                                        @error('keterangan')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                        <small class="text-muted">Opsional: tambahkan informasi tambahan</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                        <div class="text-muted">
                                            <small>
                                                Pastikan semua data yang ditandai * sudah diisi dengan benar
                                            </small>
                                        </div>
                                        <div class="btn-group">
                                            <a href="{{ route($userRole . '.ujian.index') }}"
                                                class="btn btn-sm btn-secondary">
                                                <i class="fas fa-times me-2"></i>Batal
                                            </a>
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="fas fa-save me-2"></i>Simpan Ujian
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

    <script>
        $(document).ready(function() {
            // Select all / deselect all jurusan functionality
            $('#select_all_jurusan').on('change', function() {
                var isChecked = $(this).prop('checked');
                $('.jurusan-checkbox').each(function() {
                    $(this).prop('checked', isChecked);
                });
                console.log('Select all clicked:', isChecked);
            });

            // Update select all checkbox when individual checkboxes change
            $('.jurusan-checkbox').on('change', function() {
                var totalCheckboxes = $('.jurusan-checkbox').length;
                var checkedCheckboxes = $('.jurusan-checkbox:checked').length;
                var allChecked = totalCheckboxes === checkedCheckboxes;
                $('#select_all_jurusan').prop('checked', allChecked);
                console.log('Individual checkbox changed:', checkedCheckboxes + '/' + totalCheckboxes);
            });

            // File upload preview
            $('#file_soal').on('change', function() {
                const fileName = $(this).val().split('\\').pop();
                if (fileName) {
                    $('#fileName').text(fileName);
                    $('#fileInfo').show();
                } else {
                    $('#fileInfo').hide();
                }
            });

            $('#gambar_soal').on('change', function() {
                $('#preview_gambar').html('');
                let files = this.files;
                for (let i = 0; i < files.length; i++) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview_gambar').append(
                            ` <div class="col-md-2 mb-3"> <img src="${e.target.result}" class="img-fluid rounded border shadow-sm"> <small class="d-block text-center mt-1"> ${files[i].name} </small> </div> `
                        );
                    }
                    reader.readAsDataURL(files[i]);
                }
            });

            function generateKodeUjian() {
                let jenisUjian = $('#type_ujian').val();
                let tanggal = $('#tanggal_ujian').val();
                let mapelOption = $('#mapel_id option:selected');
                let mapelKode = mapelOption.data('singkatan');
                if (!jenisUjian || !tanggal || !mapelKode) {
                    return;
                }
                let jenisKode = 'UJN';
                switch (jenisUjian) {
                    case 'Ujian Tengah Semester':
                        jenisKode = 'UTS';
                        break;
                    case 'Ujian Akhir Semester':
                        jenisKode = 'UAS';
                        break;
                    case 'Ujian Tengah Tahun':
                        jenisKode = 'UTT';
                        break;
                    case 'Ujian Akhir Tahun':
                        jenisKode = 'UAT';
                        break;
                    case 'Ujian Nasional':
                        jenisKode = 'UN';
                        break;
                }
                let tahun = new Date(tanggal).getFullYear();
                $.ajax({
                    url: "{{ route($userRole . '.ujian.generate-kode') }}",
                    type: "GET",
                    data: {
                        jenis: jenisKode,
                        mapel: mapelKode,
                        tahun: tahun
                    },
                    success: function(response) {
                        let nomor = String(response.nomor).padStart(3, '0');
                        let kode = `${jenisKode}-${mapelKode}-${tahun}-${nomor}`;
                        $('#kode_ujian').val(kode);
                        console.log('Kode generated:', kode);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal generate kode ujian'
                        });
                    }
                });
            }
            $('#type_ujian').on('change', generateKodeUjian);
            $('#mapel_id').on('change', generateKodeUjian);
            $('#tanggal_ujian').on('change', generateKodeUjian);

            // Initialize select all state on page load
            var totalCheckboxes = $('.jurusan-checkbox').length;
            var checkedCheckboxes = $('.jurusan-checkbox:checked').length;
            $('#select_all_jurusan').prop('checked', totalCheckboxes > 0 && totalCheckboxes ===
                checkedCheckboxes);
            console.log('Initial state:', checkedCheckboxes + '/' + totalCheckboxes);
        });
    </script>
@endsection
