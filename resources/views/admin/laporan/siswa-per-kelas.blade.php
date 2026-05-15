@extends('layouts.app')

@section('titlepage', 'Laporan Siswa Per Kelas')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Laporan Siswa Per Kelas</h1>
                        <p class="text-muted mb-0">Laporan data siswa berdasarkan kelas</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route($userRole . '.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fas fa-print me-2"></i>Cetak
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route($userRole . '.laporan.siswa-per-kelas') }}" method="GET" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Pilih Kelas</label>
                                <select name="kelas" class="form-select select2" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->kode_kelas }}"
                                            {{ request('kelas') == $k->kode_kelas ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label><br>
                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-search me-2"></i>Tampilkan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if ($selectedKelas)
            <!-- Class Info Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="mb-1">{{ $selectedKelas->nama_kelas }}</h4>
                                    <p class="mb-0 opacity-75">Kode: {{ $selectedKelas->kode_kelas }}</p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <h2 class="mb-0">{{ $siswa ? $siswa->count() : 0 }}</h2>
                                    <p class="mb-0 opacity-75">Total Siswa</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">{{ $siswa ? $siswa->where('jk', 'Laki-laki')->count() : 0 }}</h4>
                                    <p class="mb-0">Laki-laki</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-mars fa-2x opacity-75"></i>
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
                                    <h4 class="mb-0">{{ $siswa ? $siswa->where('jk', 'Perempuan')->count() : 0 }}</h4>
                                    <p class="mb-0">Perempuan</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-venus fa-2x opacity-75"></i>
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
                                    <h4 class="mb-0">{{ $siswa ? $siswa->where('status', 'Aktif')->count() : 0 }}</h4>
                                    <p class="mb-0">Siswa Aktif</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-user-check fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">{{ $siswa ? $siswa->where('status', '!=', 'Aktif')->count() : 0 }}
                                    </h4>
                                    <p class="mb-0">Non-Aktif</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-user-times fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Daftar Siswa Kelas {{ $selectedKelas->nama_kelas }}</h5>
                                <div class="text-muted">
                                    <small>Menampilkan {{ $siswa ? $siswa->count() : 0 }} siswa</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width: 50px;">No</th>
                                            <th>Foto</th>
                                            <th>Nama Siswa</th>
                                            <th>NISN</th>
                                            <th>NIS</th>
                                            <th class="text-center">JK</th>
                                            <th>Email</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($siswa as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">
                                                    @if ($item->foto)
                                                        <img src="{{ asset('storage/siswa/' . $item->foto) }}"
                                                            alt="Foto {{ $item->nama_siswa }}" class="rounded-circle"
                                                            style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <div class="avatar avatar-sm">
                                                            <div class="avatar-title rounded-circle bg-primary text-white">
                                                                {{ strtoupper(substr($item->nama_siswa, 0, 1)) }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="fw-semibold">{{ $item->nama_siswa }}</div>
                                                    <small class="text-muted">{{ $item->username }}</small>
                                                </td>
                                                <td><code>{{ $item->nisn }}</code></td>
                                                <td><code>{{ $item->nis }}</code></td>
                                                <td class="text-center">
                                                    <button
                                                        class="btn btn-sm btn-{{ $item->jk == 'Laki-laki' ? 'info' : 'danger' }}">
                                                        {{ $item->jk == 'Laki-laki' ? 'L' : 'P' }}
                                                    </button>
                                                </td>
                                                <td>
                                                    @if ($item->email)
                                                        {{ $item->email }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <button
                                                        class="btn btn-sm btn-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                        {{ $item->status }}
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-5">
                                                    <div class="text-muted">
                                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                                        <h5>Tidak ada siswa di kelas ini</h5>
                                                        <p>Belum ada siswa yang terdaftar di kelas ini</p>
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
        @else
            <!-- Placeholder -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-school fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">Pilih Kelas</h4>
                            <p class="text-muted">Silakan pilih kelas untuk melihat laporan siswa</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
