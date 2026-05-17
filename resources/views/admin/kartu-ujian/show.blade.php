@extends('layouts.app')

@section('titlepage', 'Detail Kartu Ujian')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Detail Kartu Ujian</h1>
                        <p class="text-muted mb-0">Lihat detail kartu ujian</p>
                    </div>
                    <div>
                        <a href="{{ route($userRole . '.kartu-ujian.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Section -->
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
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

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted">Nama Ujian</label>
                                    <div class="p-2 bg-light rounded">
                                        {{ $kartuUjian->nama_ujian }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted">Tahun Ajaran</label>
                                    <div class="p-2 bg-light rounded">
                                        {{ $kartuUjian->tahunAjaran->tahun_ajaran . ' - Semester ' . $kartuUjian->tahunAjaran->semester }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted">Kelas</label>
                                    <div class="p-2 bg-light rounded">
                                        @if ($kartuUjian->kelas)
                                            <button
                                                class="btn btn-sm btn-light text-dark">{{ $kartuUjian->kelas->nama_kelas }}</button>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex flex-wrap gap-2 justify-content-end pt-3 border-top">
                                    <a href="{{ route($userRole . '.kartu-ujian.edit', $kartuUjian->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit me-2"></i>Edit
                                    </a>
                                    <form action="{{ route($userRole . '.kartu-ujian.destroy', $kartuUjian->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger delete"
                                            data-href="{{ route($userRole . '.kartu-ujian.destroy', $kartuUjian->id) }}">
                                            <i class="fas fa-trash me-2"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-wrapper bg-success text-white me-3">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Daftar Siswa</h5>
                                <small class="text-muted">Siswa yang terdaftar pada kartu ujian ini</small>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle" style="min-width: 600px;">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Ruangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($kartuUjian->detailKartuUjian && $kartuUjian->detailKartuUjian->count() > 0)
                                        @foreach ($kartuUjian->detailKartuUjian as $index => $detail)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-light text-dark">{{ $detail->siswa->nis ?? '-' }}</span>
                                                </td>
                                                <td>
                                                    <strong>{{ $detail->siswa->nama_siswa ?? '-' }}</strong>
                                                </td>
                                                <td>
                                                    @if ($detail->siswa && $detail->siswa->kelas)
                                                        <span
                                                            class="badge bg-info text-white">{{ $detail->siswa->kelas->nama_kelas }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <form action="{{ route($userRole . '.kartu-ujian.update-ruangan', $detail->id) }}" method="POST" class="d-flex gap-1">
                                                        @csrf
                                                        <input type="text" name="ruangan" value="{{ $detail->ruangan ?? '' }}" 
                                                            class="form-control form-control-sm" style="width: 100px;" placeholder="Ruangan">
                                                        <button type="submit" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-save"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                                    <p class="mb-0">Belum ada siswa yang terdaftar</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 gap-2">
                            <small class="text-muted">
                                Total: <strong>{{ $kartuUjian->detailKartuUjian->count() ?? 0 }}</strong> siswa
                            </small>
                            <a href="{{ route($userRole . '.kartu-ujian.print', $kartuUjian->id) }}"
                                class="btn btn-sm btn-primary" target="_blank">
                                <i class="fas fa-print me-2"></i>Cetak Kartu Ujian
                            </a>
                        </div>
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
