@extends('layouts.app')
@section('titlepage', 'Data Siswa')
@section('content')
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Data Siswa</h1>
                        <p class="text-muted mb-0">Kelola data siswa sekolah</p>
                    </div>
                    <a href="{{ route($userRole . '.siswa.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Siswa
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">{{ $siswa->total() }}</h4>
                                <p class="mb-0">Total Siswa</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-users fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">
                                    {{ $siswa->where('status', 'Aktif')->count() }}
                                </h4>
                                <p class="mb-0">Siswa Aktif</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-user-check fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">
                                    {{ $siswa->where('jk', 'Laki-laki')->count() }}
                                </h4>
                                <p class="mb-0">Laki-laki</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-mars fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">
                                    {{ $siswa->where('jk', 'Perempuan')->count() }}
                                </h4>
                                <p class="mb-0">Perempuan</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-venus fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route($userRole . '.siswa.index') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Cari Siswa</label>
                                <input type="text" name="search" class="form-control form-control-sm"
                                    placeholder="Nama, NISN, atau NIS..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jk" class="form-select select2">
                                    <option value="">Semua</option>
                                    <option value="Laki-laki" {{ request('jk') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan" {{ request('jk') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select select2">
                                    <option value="">Semua</option>
                                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="Keluar/Pindah"
                                        {{ request('status') == 'Keluar/Pindah' ? 'selected' : '' }}>
                                        Keluar/Pindah</option>
                                    <option value="Lulus" {{ request('status') == 'Lulus' ? 'selected' : '' }}>
                                        Lulus</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Kelas</label>
                                <select name="kode_kelas" class="form-select select2">
                                    <option value="">Semua Kelas</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->kode_kelas }}"
                                            {{ request('kode_kelas') == $k->kode_kelas ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label><br>
                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-filter me-2"></i>Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Daftar Siswa</h5>
                            <div class="text-muted">
                                <small>Menampilkan {{ $siswa->count() }} dari {{ $siswa->total() }} data</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">No</th>
                                        <th>Foto</th>
                                        <th>Nama Siswa</th>
                                        <th>NISN</th>
                                        <th>NIS</th>
                                        <th class="text-center">JK</th>
                                        <th>Kelas</th>
                                        <th>Email</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($siswa as $item)
                                        <tr>
                                            <td class="text-center">
                                                <button
                                                    class="btn btn-sm btn-secondary">{{ $loop->iteration + ($siswa->currentPage() - 1) * $siswa->perPage() }}</button>
                                            </td>
                                            <td class="text-center">
                                                @if ($item->foto)
                                                    <img src="{{ asset('storage/siswa/' . $item->foto) }}"
                                                        alt="Foto {{ $item->nama_siswa }}" class="rounded-circle"
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="avatar avatar-sm">
                                                        <div class="avatar-title rounded-circle bg-primary text-white">
                                                            {{ strtoupper(substr($item->nama_siswa, 0, 1)) }}
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-semibold">{{ $item->nama_siswa }}</div>
                                                        <small class="text-muted">{{ $item->username }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><code>{{ $item->nisn }}</code></td>
                                            <td><code>{{ $item->nis }}</code></td>
                                            <td class="text-center">
                                                <button
                                                    class="btn btn-sm btn-{{ $item->jk == 'Laki-laki' ? 'info' : 'danger' }}">
                                                    {{ $item->jk == 'Laki-laki' ? 'L' : 'P' }}
                                                </button>
                                            </td>
                                            <td>
                                                <button
                                                    class="btn btn-sm btn-light text-dark">{{ $item->kelas->nama_kelas ?? $item->kode_kelas }}</button>
                                            </td>
                                            <td>
                                                @if ($item->email)
                                                    {{ $item->email }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button
                                                    class="btn btn-sm btn-{{ $item->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                    {{ $item->status }}
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route($userRole . '.siswa.show', $item->kode_siswa) }}"
                                                        class="btn btn-sm btn-info" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route($userRole . '.siswa.edit', $item->kode_siswa) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route($userRole . '.siswa.destroy', $item->kode_siswa) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger delete"
                                                            title="Hapus"
                                                            data-href="{{ route($userRole . '.siswa.destroy', $item->kode_siswa) }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                                    <h5>Tidak ada data siswa</h5>
                                                    <p>Belum ada data siswa yang tersedia</p>
                                                    <a href="{{ route($userRole . '.siswa.create') }}"
                                                        class="btn btn-primary">
                                                        <i class="fas fa-plus me-2"></i>Tambah Siswa
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($siswa->hasPages())
                        <div class="card-footer bg-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="text-muted">
                                        <small>
                                            Menampilkan {{ $siswa->firstItem() }} - {{ $siswa->lastItem() }}
                                            dari {{ $siswa->total() }} data
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    {!! $siswa->appends(request()->query())->links('pagination::bootstrap-5') !!}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
