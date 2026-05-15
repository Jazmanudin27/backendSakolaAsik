@extends('layouts.app')
@section('titlepage', 'Menu')
@section('content')

    <div class="menu-header text-center mb-4">
        <h1>🎓 Sakola Digital</h1>
        <p>Smart School Management System</p>
    </div>

    <!-- Tab Navigation -->
    <div class="tab-navigation text-center mb-4">
        <button class="tab-btn active" data-tab="data-master">📊 Data Master</button>
        <button class="tab-btn" data-tab="learning">📚 Learning</button>
        <button class="tab-btn" data-tab="laporan">📄 Laporan</button>
        <button class="tab-btn" data-tab="setting">⚙️ Setting</button>
    </div>

    <!-- Tab Content: Data Master -->
    <div class="tab-content active" id="data-master">
        <div class="row g-4 justify-content-center">

            <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                <a href="{{ route($userRole . '.guru.index') }}" class="text-decoration-none">
                    <div class="menu-card card-guru">
                        <div class="card-body">
                            <div class="icon-wrapper">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h6>Data Guru</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                <a href="{{ route($userRole . '.siswa.index') }}" class="text-decoration-none">
                    <div class="menu-card card-siswa">
                        <div class="card-body">
                            <div class="icon-wrapper">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <h6>Data Siswa</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                <a href="{{ route($userRole . '.kelas.index') }}" class="text-decoration-none">
                    <div class="menu-card card-kelas">
                        <div class="card-body">
                            <div class="icon-wrapper">
                                <i class="fas fa-school"></i>
                            </div>
                            <h6>Data Kelas</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                <a href="{{ route($userRole . '.jurusan.index') }}" class="text-decoration-none">
                    <div class="menu-card card-jurusan">
                        <div class="card-body">
                            <div class="icon-wrapper">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <h6>Jurusan</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                <a href="{{ route($userRole . '.mapel.index') }}" class="text-decoration-none">
                    <div class="menu-card card-mapel">
                        <div class="card-body">
                            <div class="icon-wrapper">
                                <i class="fas fa-book"></i>
                            </div>
                            <h6>Mata Pelajaran</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                <a href="{{ route($userRole . '.tahun_ajaran.index') }}" class="text-decoration-none">
                    <div class="menu-card card-tahun">
                        <div class="card-body">
                            <div class="icon-wrapper">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <h6>Tahun Ajaran</h6>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <!-- Tab Content: Learning -->
    <div class="tab-content" id="learning">
        <div class="row g-4 justify-content-center">

            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <a href="{{ route($userRole . '.ujian.index') }}" class="text-decoration-none">
                    <div class="menu-card card-ujian">
                        <div class="card-body">
                            <div class="icon-wrapper">
                                <i class="fas fa-edit"></i>
                            </div>
                            <h6>Data Ujian</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <a href="{{ route($userRole . '.hasil-ujian.index') }}" class="text-decoration-none">
                    <div class="menu-card card-hasil">
                        <div class="card-body">
                            <div class="icon-wrapper">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <h6>Hasil Ujian</h6>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <!-- Tab Content: Laporan -->
    <div class="tab-content" id="laporan">
        <div class="row g-4 justify-content-center">

            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <a href="{{ route($userRole . '.laporan.siswa') }}" class="text-decoration-none">
                    <div class="menu-card card-laporan">
                        <div class="card-body">
                            <div class="icon-wrapper">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <h6>Laporan Siswa</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <a href="{{ route($userRole . '.laporan.guru') }}" class="text-decoration-none">
                    <div class="menu-card card-laporan">
                        <div class="card-body">
                            <div class="icon-wrapper">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h6>Laporan Guru</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <a href="{{ route($userRole . '.laporan.kelas') }}" class="text-decoration-none">
                    <div class="menu-card card-laporan">
                        <div class="card-body">
                            <div class="icon-wrapper">
                                <i class="fas fa-school"></i>
                            </div>
                            <h6>Laporan Kelas</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <a href="{{ route($userRole . '.laporan.siswa-per-kelas') }}" class="text-decoration-none">
                    <div class="menu-card card-laporan">
                        <div class="card-body">
                            <div class="icon-wrapper">
                                <i class="fas fa-users"></i>
                            </div>
                            <h6>Laporan Siswa Per Kelas</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <a href="{{ route($userRole . '.laporan.ujian') }}" class="text-decoration-none">
                    <div class="menu-card card-laporan">
                        <div class="card-body">
                            <div class="icon-wrapper">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <h6>Laporan Ujian</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <a href="{{ route($userRole . '.laporan.nilai') }}" class="text-decoration-none">
                    <div class="menu-card card-laporan">
                        <div class="card-body">
                            <div class="icon-wrapper">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h6>Laporan Nilai</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <a href="{{ route($userRole . '.laporan.kehadiran') }}" class="text-decoration-none">
                    <div class="menu-card card-laporan">
                        <div class="card-body">
                            <div class="icon-wrapper">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <h6>Laporan Kehadiran</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <a href="{{ route($userRole . '.laporan.pembayaran') }}" class="text-decoration-none">
                    <div class="menu-card card-laporan">
                        <div class="card-body">
                            <div class="icon-wrapper">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <h6>Laporan Pembayaran</h6>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <!-- Tab Content: Setting -->
    <div class="tab-content" id="setting">
        <div class="row g-4 justify-content-center">

            <div class="col-12 text-center text-white">
                <div class="menu-card card-setting" style="max-width: 400px; margin: 0 auto;">
                    <div class="card-body">
                        <div class="icon-wrapper">
                            <i class="fas fa-cog"></i>
                        </div>
                        <h6>Pengaturan Sistem</h6>
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
