@extends('layouts.app')
@section('titlepage', 'Menu')
@section('content')

    <div class="menu-header text-center mb-2">
        <h1>🎓 Sakola Digital</h1>
        <p>Smart School Management System</p>
    </div>
    @if (Auth::guard($userRole)->user()->role === 'admin')
        @php
            $userRoleGuru = 'admin';
        @endphp
    @else
        @php
            $userRoleGuru = 'guru';
        @endphp
    @endif
    <!-- Tab Navigation -->
    <div class="tab-navigation text-center mb-2">
        @if ($userRoleGuru === 'admin')
            <button class="tab-btn active" data-tab="data-master">📊 Data Master</button>
        @endif
        <button class="tab-btn {{ $userRoleGuru === 'guru' ? 'active' : '' }}" data-tab="learning">📚 Learning</button>
        <button class="tab-btn" data-tab="laporan">📄 Laporan</button>
        <button class="tab-btn" data-tab="setting">⚙️ Setting</button>
    </div>

    <!-- Tab Content: Data Master -->
    @if ($userRoleGuru === 'admin')
        <div class="tab-content active" id="data-master">
            <div class="row g-4 justify-content-center">

                <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                    <a href="{{ route($userRole . '.guru.index') }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                            <div class="card-body py-4">
                                <div class="mb-2">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                        style="width:90px;height:90px;">
                                        <i class="fas fa-chalkboard-teacher fa-3x text-primary"></i>
                                    </div>
                                </div>
                                <h6 class="mb-0 text-dark">Data Guru</h6>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                    <a href="{{ route($userRole . '.siswa.index') }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                            <div class="card-body py-4">
                                <div class="mb-2">
                                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                        style="width:90px;height:90px;">
                                        <i class="fas fa-user-graduate fa-3x text-success"></i>
                                    </div>
                                </div>
                                <h6 class="mb-0 text-dark">Data Siswa</h6>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                    <a href="{{ route($userRole . '.kelas.index') }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                            <div class="card-body py-4">
                                <div class="mb-2">
                                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                        style="width:90px;height:90px;">
                                        <i class="fas fa-school fa-3x text-info"></i>
                                    </div>
                                </div>
                                <h6 class="mb-0 text-dark">Data Kelas</h6>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                    <a href="{{ route($userRole . '.jurusan.index') }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                            <div class="card-body py-4">
                                <div class="mb-2">
                                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                        style="width:90px;height:90px;">
                                        <i class="fas fa-layer-group fa-3x text-warning"></i>
                                    </div>
                                </div>
                                <h6 class="mb-0 text-dark">Jurusan</h6>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                    <a href="{{ route($userRole . '.mapel.index') }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                            <div class="card-body py-4">
                                <div class="mb-2">
                                    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                        style="width:90px;height:90px;">
                                        <i class="fas fa-book fa-3x text-danger"></i>
                                    </div>
                                </div>
                                <h6 class="mb-0 text-dark">Mata Pelajaran</h6>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                    <a href="{{ route($userRole . '.tahun_ajaran.index') }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                            <div class="card-body py-4">
                                <div class="mb-2">
                                    <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                        style="width:90px;height:90px;">
                                        <i class="fas fa-calendar-alt fa-3x text-secondary"></i>
                                    </div>
                                </div>
                                <h6 class="mb-0 text-dark">Tahun Ajaran</h6>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    @endif

    <!-- Tab Content: Learning -->
    <div class="tab-content" id="learning">
        <div class="row g-4 justify-content-center">

            <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                <a href="{{ route($userRole . '.ujian.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                        <div class="card-body py-4">
                            <div class="mb-2">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width:90px;height:90px;">
                                    <i class="fas fa-edit fa-3x text-primary"></i>
                                </div>
                            </div>
                            <h6 class="mb-0 text-dark">Data Ujian</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                <a href="{{ route($userRole . '.hasil-ujian.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                        <div class="card-body py-4">
                            <div class="mb-2">
                                <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width:90px;height:90px;">
                                    <i class="fas fa-chart-bar fa-3x text-info"></i>
                                </div>
                            </div>
                            <h6 class="mb-0 text-dark">Hasil Ujian</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                <a href="{{ route($userRole . '.kartu-ujian.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                        <div class="card-body py-4">
                            <div class="mb-2">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width:90px;height:90px;">
                                    <i class="fas fa-id-card fa-3x text-warning"></i>
                                </div>
                            </div>
                            <h6 class="mb-0 text-dark">Kartu Ujian</h6>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <!-- Tab Content: Laporan -->
    <div class="tab-content" id="laporan">
        <div class="row g-4 justify-content-center">

            <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                <a href="#" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                        <div class="card-body py-4">
                            <div class="mb-2">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width:90px;height:90px;">
                                    <i class="fas fa-user-graduate fa-3x text-primary"></i>
                                </div>
                            </div>
                            <h6 class="mb-0 text-dark">Laporan Siswa</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                <a href="#" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                        <div class="card-body py-4">
                            <div class="mb-2">
                                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width:90px;height:90px;">
                                    <i class="fas fa-chalkboard-teacher fa-3x text-success"></i>
                                </div>
                            </div>
                            <h6 class="mb-0 text-dark">Laporan Guru</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                <a href="#" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                        <div class="card-body py-4">
                            <div class="mb-2">
                                <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width:90px;height:90px;">
                                    <i class="fas fa-school fa-3x text-info"></i>
                                </div>
                            </div>
                            <h6 class="mb-0 text-dark">Laporan Kelas</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                <a href="#" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                        <div class="card-body py-4">
                            <div class="mb-2">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width:90px;height:90px;">
                                    <i class="fas fa-users fa-3x text-warning"></i>
                                </div>
                            </div>
                            <h6 class="mb-0 text-dark">Siswa Per Kelas</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                <a href="#" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                        <div class="card-body py-4">
                            <div class="mb-2">
                                <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width:90px;height:90px;">
                                    <i class="fas fa-edit fa-3x text-danger"></i>
                                </div>
                            </div>
                            <h6 class="mb-0 text-dark">Laporan Ujian</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                <a href="#" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                        <div class="card-body py-4">
                            <div class="mb-2">
                                <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width:90px;height:90px;">
                                    <i class="fas fa-chart-line fa-3x text-secondary"></i>
                                </div>
                            </div>
                            <h6 class="mb-0 text-dark">Laporan Nilai</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-2">
                <a href="{{ route($userRole . '.laporan.kartu-ujian') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                        <div class="card-body py-4">
                            <div class="mb-2">
                                <div class="bg-dark bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width:90px;height:90px;">
                                    <i class="fas fa-id-card fa-3x text-dark"></i>
                                </div>
                            </div>
                            <h6 class="mb-0 text-dark">Cetak Kartu Ujian</h6>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <!-- Tab Content: Setting -->
    <div class="tab-content" id="setting">
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-md-8 col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-2">
                            <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width:90px;height:90px;">
                                <i class="fas fa-cog fa-3x text-secondary"></i>
                            </div>
                        </div>
                        <h6 class="mb-0 text-dark">Pengaturan Sistem</h6>
                        <p class="text-muted small mt-2">Fitur pengaturan akan segera hadir</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const tabId = this.getAttribute('data-tab');

                    tabBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    tabContents.forEach(content => content.classList.remove('active'));
                    document.getElementById(tabId).classList.add('active');
                });
            });
        });
    </script>

@endsection
