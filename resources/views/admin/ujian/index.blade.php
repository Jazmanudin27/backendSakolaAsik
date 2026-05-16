@extends('layouts.app')
@section('titlepage', 'Manajemen Ujian')
@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Manajemen Ujian</h1>
                        <p class="text-muted mb-0">Kelola jadwal dan soal ujian sekolah</p>
                    </div>
                    <a href="{{ route($userRole . '.ujian.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">{{ $ujians->count() }}</h4>
                                <p class="mb-0">Total Ujian</p>
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
                                    {{ $ujians->where('tanggal', '>=', now())->count() }}
                                </h4>
                                <p class="mb-0">Ujian Akan Datang</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-calendar-check fa-2x opacity-75"></i>
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
                                <h4 class="mb-0">
                                    {{ $ujians->where('tanggal', '<', now())->count() }}
                                </h4>
                                <p class="mb-0">Ujian Selesai</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-history fa-2x opacity-75"></i>
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
                                    {{ $ujians->sum(function ($ujian) {return $ujian->detailUjians->count();}) }}
                                </h4>
                                <p class="mb-0">Total Soal</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-question-circle fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="row g-2">
                            <div class="col-12 col-md-6">
                                <input type="text" class="form-control form-control-sm" id="searchInput"
                                    placeholder="Cari ujian...">
                            </div>
                            <div class="col-6 col-md-3">
                                <select class="form-select select2" id="filterTipe">
                                    <option value="">Semua Tipe</option>
                                    <option value="Ujian Tengah Semester">UTS</option>
                                    <option value="Ujian Akhir Semester">UAS</option>
                                    <option value="Ujian Tengah Tahun">UTT</option>
                                    <option value="Ujian Akhir Tahun">UAT</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-3">
                                <select class="form-select select2" id="filterStatus">
                                    <option value="">Semua Status</option>
                                    <option value="Draft">Draft</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 60px;">No</th>
                                        <th style="min-width: 120px;">Kode Ujian</th>
                                        <th style="min-width: 100px;">Tingkat</th>
                                        <th style="min-width: 150px;">Mapel</th>
                                        <th class="text-center" style="min-width: 100px;">Tipe</th>
                                        <th class="text-center" style="min-width: 100px;">Status</th>
                                        <th class="text-center" style="width: 200px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ujians as $index => $ujian)
                                        <tr>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-secondary">{{ $index + 1 }}</button>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-semibold">{{ $ujian->kode_ujian }}</div>
                                                        <small class="text-muted">
                                                            {{ $ujian->tanggal_ujian->format('d-m-Y') }},
                                                            {{ $ujian->durasi }}m
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-semibold">{{ $ujian->tingkat }}</div>
                                                        <small class="text-muted">
                                                            @if ($ujian->id_jurusan && is_array($ujian->id_jurusan))
                                                                @php
                                                                    $jurusanIds = $ujian->id_jurusan;
                                                                    $jurusans = \App\Models\Jurusan::whereIn(
                                                                        'id',
                                                                        $jurusanIds,
                                                                    )->get();
                                                                @endphp
                                                                @if ($jurusans->count() > 0)
                                                                    {{ $jurusans->pluck('nama_jurusan')->implode(', ') }}
                                                                @else
                                                                    Semua Jurusan
                                                                @endif
                                                            @else
                                                                Semua Jurusan
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-semibold">{{ $ujian->mapel->singkatan }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button
                                                    class="btn btn-sm btn-{{ $ujian->jenis_ujian == 'Ujian Tengah Semester' || $ujian->jenis_ujian == 'Ujian Akhir Semester' ? 'danger' : ($ujian->jenis_ujian == 'Ujian Tengah Tahun' || $ujian->jenis_ujian == 'Ujian Akhir Tahun' ? 'warning' : 'info') }}"
                                                    title="{{ $ujian->jenis_ujian }}">
                                                    @switch($ujian->jenis_ujian)
                                                        @case('Ujian Tengah Semester')
                                                            UTS
                                                        @break

                                                        @case('Ujian Akhir Semester')
                                                            UAS
                                                        @break

                                                        @case('Ujian Tengah Tahun')
                                                            UTT
                                                        @break

                                                        @case('Ujian Akhir Tahun')
                                                            UAT
                                                        @break

                                                        @default
                                                            {{ Str::limit($ujian->jenis_ujian, 8) }}
                                                    @endswitch
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <button
                                                    class="btn btn-sm btn-{{ $ujian->status == 'Aktif' ? 'success' : ($ujian->status == 'Draft' ? 'secondary' : ($ujian->status == 'Selesai' ? 'info' : 'danger')) }}">
                                                    {{ $ujian->status }}
                                                </button>
                                            </td>

                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">

                                                    @if ($ujian->status == 'Draft')
                                                        <form
                                                            action="{{ route($userRole . '.ujian.activate', $ujian->id) }}"
                                                            method="POST" class="d-inline activate-exam-form">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-sm btn-success"
                                                                title="Aktifkan Ujian">
                                                                <i class="fas fa-play me-2"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button type="button" class="btn btn-sm btn-secondary" disabled
                                                            title="Hanya ujian dengan status Draft yang dapat diaktifkan">
                                                            <i class="fas fa-play me-2"></i>
                                                        </button>
                                                    @endif

                                                    @if ($ujian->jawabanSiswas->isEmpty())
                                                        <button type="button" class="btn btn-sm btn-secondary"
                                                            title="Belum ada hasil ujian" disabled>
                                                            <i class="fas fa-clock me-2"></i>
                                                        </button>
                                                    @elseif($ujian->jawabanSiswas->contains('status_nilai', 'dibuka'))
                                                        <form
                                                            action="{{ route($userRole . '.hasil-ujian.close-results', $ujian->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success"
                                                                title="Kunci Hasil">
                                                                <i class="fas fa-lock me-2"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form
                                                            action="{{ route($userRole . '.hasil-ujian.open-results', $ujian->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                title="Buka Hasil">
                                                                <i class="fas fa-unlock me-2"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <a href="{{ route($userRole . '.ujian.show', $ujian->id) }}"
                                                        class="btn btn-sm btn-info" title="Detail">
                                                        <i class="fas fa-eye me-2"></i>
                                                    </a>
                                                    <a href="{{ route($userRole . '.ujian.edit', $ujian->id) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit me-2"></i>
                                                    </a>
                                                    <form action="{{ route($userRole . '.ujian.destroy', $ujian->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger delete"
                                                            title="Hapus"
                                                            data-href="{{ route($userRole . '.ujian.destroy', $ujian->id) }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center py-5">
                                                    <div class="text-muted">
                                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                                        <h5>Belum ada data ujian</h5>
                                                        <p>Belum ada jadwal ujian yang tersedia</p>
                                                        <a href="{{ route($userRole . '.ujian.create') }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fas fa-plus me-2"></i>Tambah Ujian
                                                        </a>
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
            document.addEventListener('DOMContentLoaded', function() {
                // Search functionality
                const searchInput = document.getElementById('searchInput');
                const filterTipe = document.getElementById('filterTipe');
                const filterStatus = document.getElementById('filterStatus');
                const tableRows = document.querySelectorAll('tbody tr');

                function filterTable() {
                    const searchTerm = searchInput.value.toLowerCase();
                    const tipeValue = filterTipe.value.toLowerCase();
                    const statusValue = filterStatus.value.toLowerCase();

                    tableRows.forEach(row => {
                        const kodeUjian = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                        const kelas = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                        const mapel = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
                        const tipe = row.querySelector('td:nth-child(8)').textContent.toLowerCase();
                        const status = row.querySelector('td:nth-child(7)').textContent.toLowerCase();

                        let showRow = true;

                        // Search filter
                        if (searchTerm && !kodeUjian.includes(searchTerm) && !kelas.includes(searchTerm) && !
                            mapel.includes(searchTerm)) {
                            showRow = false;
                        }

                        // Type filter
                        if (tipeValue && !tipe.includes(tipeValue)) {
                            showRow = false;
                        }

                        // Status filter
                        if (statusValue && !status.includes(statusValue)) {
                            showRow = false;
                        }

                        row.style.display = showRow ? '' : 'none';
                    });
                }

                // Event listeners
                searchInput.addEventListener('input', filterTable);
                filterTipe.addEventListener('change', filterTable);
                filterStatus.addEventListener('change', filterTable);

                // Handle exam activation forms
                const activateForms = document.querySelectorAll('.activate-exam-form');
                activateForms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const submitButton = this.querySelector('button');
                        const originalContent = submitButton.innerHTML;

                        // Show loading state
                        submitButton.disabled = true;
                        submitButton.innerHTML =
                            '<i class="fas fa-spinner fa-spin me-2"></i>Mengaktifkan...';

                        fetch(this.action, {
                                method: 'PUT',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Show success message
                                    const toast = document.createElement('div');
                                    toast.className =
                                        'alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3';
                                    toast.style.zIndex = '9999';
                                    toast.innerHTML = `
                                    <strong>Berhasil!</strong> ${data.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                `;
                                    document.body.appendChild(toast);

                                    // Remove toast after 3 seconds
                                    setTimeout(() => {
                                        toast.remove();
                                    }, 3000);

                                    // Reload page to reflect changes
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                } else {
                                    // Show error message
                                    const toast = document.createElement('div');
                                    toast.className =
                                        'alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3';
                                    toast.style.zIndex = '9999';
                                    toast.innerHTML = `
                                    <strong>Gagal!</strong> ${data.message || 'Terjadi kesalahan'}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                `;
                                    document.body.appendChild(toast);

                                    // Remove toast after 3 seconds
                                    setTimeout(() => {
                                        toast.remove();
                                    }, 3000);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                // Show error message
                                const toast = document.createElement('div');
                                toast.className =
                                    'alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3';
                                toast.style.zIndex = '9999';
                                toast.innerHTML = `
                                <strong>Error!</strong> Terjadi kesalahan koneksi
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            `;
                                document.body.appendChild(toast);

                                // Remove toast after 3 seconds
                                setTimeout(() => {
                                    toast.remove();
                                }, 3000);
                            })
                            .finally(() => {
                                // Restore button state
                                submitButton.disabled = false;
                                submitButton.innerHTML = originalContent;
                            });
                    });
                });
            });
        </script>
    @endsection
