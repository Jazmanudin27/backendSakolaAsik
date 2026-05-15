@extends('layouts.app')

@section('titlepage', 'Laporan Kehadiran')

@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Laporan Kehadiran</h1>
                        <p class="text-muted mb-0">Laporan kehadiran siswa</p>
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

        <!-- Info Card -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-calendar-check fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Fitur Kehadiran</h4>
                        <p class="text-muted">Fitur laporan kehadiran akan segera tersedia</p>
                        <p class="text-muted small">Modul kehadiran sedang dalam pengembangan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
