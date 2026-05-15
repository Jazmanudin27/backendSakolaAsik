@extends('layouts.app')
@section('titlepage', 'Menu Siswa')
@section('content')

    <div class="menu-header text-center mb-4">
        <h1>🎓 Sakola Digital</h1>
        <p>Smart School Management System</p>
    </div>

    <!-- Tab Navigation -->
    <div class="tab-navigation text-center mb-4">
        <button class="tab-btn active" data-tab="ujian">📚 Ujian</button>
        <button class="tab-btn" data-tab="profil">👤 Profil</button>
    </div>

    <!-- Tab Content: Ujian -->
    <div class="tab-content active" id="ujian">
        <div class="row g-4 justify-content-center">

            <!-- Daftar Ujian -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-4">
                <a href="{{ route('siswa.ujian.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                        <div class="card-body py-4">

                            <div class="mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width:90px;height:90px;">
                                    <i class="fas fa-list fa-3x text-primary"></i>
                                </div>
                            </div>

                            <h6 class="mb-0 text-dark">Daftar Ujian</h6>

                        </div>
                    </div>
                </a>
            </div>

            <!-- Hasil Ujian -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-4">
                <a href="{{ route('siswa.hasil-ujian.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                        <div class="card-body py-4">

                            <div class="mb-3">
                                <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width:90px;height:90px;">
                                    <i class="fas fa-chart-line fa-3x text-info"></i>
                                </div>
                            </div>

                            <h6 class="mb-0 text-dark">Hasil Ujian</h6>

                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <!-- Tab Content: Profil -->
    <div class="tab-content" id="profil">
        <div class="row g-4 justify-content-center">

            <div class="col-12 col-md-8 col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">

                        <div class="mb-3">
                            <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width:90px;height:90px;">
                                <i class="fas fa-user fa-3x text-secondary"></i>
                            </div>
                        </div>

                        <h6 class="mb-0 text-dark">Profil Siswa</h6>
                        <p class="text-muted small mt-2">Fitur profil akan segera hadir</p>

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
