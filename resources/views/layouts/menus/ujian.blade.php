<div class="container-fluid p-0">

    <!-- Header -->
    <div class="mb-4">
        <h1 class="h3 mb-1">Ujian</h1>
        <p class="text-muted">Kelola ujian online</p>
    </div>

    <!-- Menu Ujian -->
    <div class="row">

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
