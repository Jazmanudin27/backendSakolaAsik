<div class="container-fluid p-0">

    <!-- Header -->
    <div class="mb-4">
        <h1 class="h3 mb-1">Data Master</h1>
        <p class="text-muted">Kelola seluruh data master sekolah</p>
    </div>

    <!-- Menu Data Master -->
    <div class="row">
            <!-- Guru -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-4">
                <a href="{{ route('admin.guru.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                        <div class="card-body py-4">
                            <div class="mb-3">
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

            <!-- Siswa -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-4">
                <a href="{{ route('admin.siswa.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                        <div class="card-body py-4">
                            <div class="mb-3">
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

            <!-- Kelas -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-4">
                <a href="{{ route('admin.kelas.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                        <div class="card-body py-4">
                            <div class="mb-3">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width:90px;height:90px;">
                                    <i class="fas fa-school fa-3x text-warning"></i>
                                </div>
                            </div>

                            <h6 class="mb-0 text-dark">Data Kelas</h6>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Jurusan -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-4">
                <a href="{{ route('admin.jurusan.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center h-100 rounded-4">
                        <div class="card-body py-4">
                            <div class="mb-3">
                                <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width:90px;height:90px;">
                                    <i class="fas fa-layer-group fa-3x text-danger"></i>
                                </div>
                            </div>

                            <h6 class="mb-0 text-dark">Jurusan</h6>
                        </div>
                    </div>
                </a>
            </div>

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
</div>
