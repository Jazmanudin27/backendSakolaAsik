<div class="container-fluid p-0">

    <!-- Header -->
    <div class="mb-4">
        <h1 class="h3 mb-1">Pendidikan</h1>
        <p class="text-muted">Kelola data pendidikan sekolah</p>
    </div>

    <!-- Menu Pendidikan -->
    <div class="row">

        <!-- Mata Pelajaran -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-4">
            <a href="{{ route('admin.mapel.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                    <div class="card-body py-4">
                        <div class="mb-3">
                            <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width:90px;height:90px;">
                                <i class="fas fa-book fa-3x text-info"></i>
                            </div>
                        </div>

                        <h6 class="mb-0 text-dark">Mata Pelajaran</h6>
                    </div>
                </div>
            </a>
        </div>

        <!-- Tahun Ajaran -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-4">
            <a href="{{ route('admin.tahun_ajaran.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                    <div class="card-body py-4">
                        <div class="mb-3">
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
