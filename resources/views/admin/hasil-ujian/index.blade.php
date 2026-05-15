@extends('layouts.app')
@section('titlepage', 'Hasil Ujian Siswa')
@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-1">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Hasil Ujian Siswa</h1>
                        <p class="text-muted mb-0">Lihat hasil dan nilai ujian siswa</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-primary" onclick="exportResults()">
                            <i class="fas fa-download me-2"></i>Export
                        </button>
                        <button class="btn btn-sm btn-secondary" onclick="printResults()">
                            <i class="fas fa-print me-2"></i>Cetak
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-1">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">{{ $hasilUjians->count() }}</h4>
                                <p class="mb-0">Total Hasil</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-clipboard-list fa-2x opacity-75"></i>
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
                                <h4 class="mb-0">
                                    {{ $hasilUjians->where('score.percentage', '>=', 80)->count() }}
                                </h4>
                                <p class="mb-0">Nilai A (≥80)</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-trophy fa-2x opacity-75"></i>
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
                                <h4 class="mb-0">
                                    {{ $hasilUjians->where('score.percentage', '>=', 60)->where('score.percentage', '<', 80)->count() }}
                                </h4>
                                <p class="mb-0">Nilai B (60-79)</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-star fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">
                                    {{ $hasilUjians->where('score.percentage', '<', 60)->count() }}
                                </h4>
                                <p class="mb-0">Nilai C (< 60) </p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mb-1">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Filter Hasil</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route($userRole . '.hasil-ujian.index') }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="id_ujian" class="form-label">Ujian</label>
                                    <select class="form-select select2" id="id_ujian" name="id_ujian">
                                        <option value="">Semua Ujian</option>
                                        @foreach ($ujians as $ujian)
                                            <option value="{{ $ujian->id }}"
                                                {{ request('id_ujian') == $ujian->id ? 'selected' : '' }}>
                                                {{ $ujian->kode_ujian }} - {{ $ujian->mapel->nama_mapel }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="id_kelas" class="form-label">Kelas</label>
                                    <select class="form-select select2" id="id_kelas" name="id_kelas">
                                        <option value="">Semua Kelas</option>
                                        @foreach ($kelasList as $kelas)
                                            <option value="{{ $kelas->id }}"
                                                {{ request('id_kelas') == $kelas->id ? 'selected' : '' }}>
                                                {{ $kelas->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="id_mapel" class="form-label">Mata Pelajaran</label>
                                    <select class="form-select select2" id="id_mapel" name="id_mapel">
                                        <option value="">Semua Mata Pelajaran</option>
                                        @foreach ($mapelList as $mapel)
                                            <option value="{{ $mapel->id }}"
                                                {{ request('id_mapel') == $mapel->id ? 'selected' : '' }}>
                                                {{ $mapel->nama_mapel }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <div class="btn-group w-100">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-filter me-2"></i>Filter
                                        </button>
                                        <a href="{{ route($userRole . '.hasil-ujian.index') }}"
                                            class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-times me-2"></i>Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Daftar Hasil Ujian</h5>
                            <div class="text-muted">
                                <small>Menampilkan {{ $hasilUjians->count() }} hasil</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 60px;">No</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Tanggal Ujian</th>
                                        <th>Waktu Pengerjaan</th>
                                        <th class="text-center">Nilai</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($hasilUjians as $index => $hasil)
                                        <tr>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-secondary">{{ $index + 1 }}</button>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-semibold">{{ $hasil->siswa->nama_siswa }}</div>
                                                        <small class="text-muted">{{ $hasil->siswa->nis }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-light text-dark">
                                                    {{ $hasil->siswa->kelas->nama_kelas }}
                                                </button>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-semibold">{{ $hasil->ujian->mapel->nama_mapel }}
                                                        </div>
                                                        <small
                                                            class="text-muted">{{ $hasil->ujian->mapel->singkatan }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-semibold">
                                                            {{ \Carbon\Carbon::parse($hasil->ujian->tanggal_ujian)->format('d-m-Y') }}
                                                        </div>
                                                        <small class="text-muted">
                                                            -
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-semibold">
                                                            {{ \Carbon\Carbon::parse($hasil->waktu_mulai)->format('H:i') }}
                                                            -
                                                            {{ \Carbon\Carbon::parse($hasil->waktu_selesai)->format('H:i') }}
                                                        </div>
                                                        <small class="text-muted">
                                                            {{ round(\Carbon\Carbon::parse($hasil->waktu_mulai)->diffInMinutes(\Carbon\Carbon::parse($hasil->waktu_selesai))) }}
                                                            menit
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex flex-column align-items-center">
                                                    <button
                                                        class="btn btn-sm btn-{{ $hasil->score['percentage'] >= 80 ? 'success' : ($hasil->score['percentage'] >= 60 ? 'warning' : 'danger') }}">
                                                        {{ $hasil->score['percentage'] }}%
                                                    </button>
                                                    <small class="text-muted mt-1">
                                                        {{ $hasil->score['score'] }}/{{ $hasil->score['max_score'] }}
                                                    </small>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-success">
                                                    <i class="fas fa-check-circle me-2"></i>Selesai
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route($userRole . '.hasil-ujian.show', $hasil->id) }}"
                                                        class="btn btn-info" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route($userRole . '.hasil-ujian.print', $hasil->id) }}"
                                                        class="btn btn-secondary" title="Cetak">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                                    <h5>Belum ada data hasil ujian</h5>
                                                    <p>Belum ada siswa yang menyelesaikan ujian</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function exportResults() {
            window.location.href = '{{ route($userRole . '.hasil-ujian.export') }}';
        }

        function printResults() {
            window.print();
        }
    </script>
@endsection
