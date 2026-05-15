<div class="container-fluid p-0">

    <!-- Header -->
    <div class="mb-4">
        <h1 class="h3 mb-1">Laporan</h1>
        <p class="text-muted">Lihat laporan dan hasil ujian</p>
    </div>

    <!-- Menu Laporan -->
    <div class="row">

        <!-- Data Ujian -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-4">
            <a href="{{ route('admin.ujian.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                    <div class="card-body py-4">
                        <div class="mb-3">
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

        <!-- Hasil Ujian -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-4">
            <a href="{{ route('admin.hasil-ujian.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                    <div class="card-body py-4">
                        <div class="mb-3">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width:90px;height:90px;">
                                <i class="fas fa-chart-bar fa-3x text-success"></i>
                            </div>
                        </div>

                        <h6 class="mb-0 text-dark">Hasil Ujian</h6>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>
