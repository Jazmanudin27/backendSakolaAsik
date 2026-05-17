@extends('layouts.app')

@section('titlepage', 'Laporan Kartu Ujian')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Laporan Kartu Ujian</h1>
                        <p class="text-muted mb-0">Cetak kartu ujian siswa</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route($userRole . '.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mb-3">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Filter Kartu Ujian</h5>
                        <form action="{{ route($userRole . '.laporan.kartu-ujian') }}" method="GET" class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Kelas</label>
                                <select name="kelas" class="form-select select2">
                                    <option value="">Semua Kelas</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->kode_kelas }}"
                                            {{ request('kelas') == $k->kode_kelas ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex gap-2">
                                    <a href="{{ route($userRole . '.laporan.kartu-ujian.print', request()->query()) }}"
                                        class="btn btn-sm btn-success w-100" target="_blank">
                                        <i class="fas fa-print me-1"></i> Cetak Kartu Ujian
                                    </a>
                                    <a href="{{ route($userRole . '.laporan.kartu-ujian') }}"
                                        class="btn btn-sm btn-secondary w-100">
                                        <i class="fas fa-redo me-1"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
