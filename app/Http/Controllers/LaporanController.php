<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SekolahAwareController;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\JawabanSiswa;
use App\Models\Ujian;
use Illuminate\Http\Request;
use App\Helpers\UserRoleHelper;

class LaporanController extends SekolahAwareController
{
    /**
     * Laporan Siswa
     */
    public function siswa(Request $request)
    {
        $query = $this->addSekolahFilter(Siswa::with('kelas', 'sekolah'), Siswa::class);
        
        // Search by name, NISN, or NIS
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }
        
        // Filter by kelas
        if ($request->filled('kelas')) {
            $query->where('kode_kelas', $request->kelas);
        }
        
        // Filter by jenis kelamin
        if ($request->filled('jk')) {
            $query->where('jk', $request->jk);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $siswa = $query->latest()->paginate(10);
        $kelas = $this->getSekolahOptions(Kelas::query(), Kelas::class)->get();
        
        return view('admin.laporan.siswa', compact('siswa', 'kelas'));
    }

    /**
     * Laporan Guru
     */
    public function guru(Request $request)
    {
        $query = $this->addSekolahFilter(Guru::with('sekolah'), Guru::class);
        
        // Search by name or NIP
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_guru', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }
        
        // Filter by jenis kelamin
        if ($request->filled('jk')) {
            $query->where('jk', $request->jk);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $guru = $query->latest()->paginate(10);
        
        return view('admin.laporan.guru', compact('guru'));
    }

    /**
     * Laporan Kelas
     */
    public function kelas(Request $request)
    {
        $query = $this->addSekolahFilter(Kelas::with('sekolah'), Kelas::class);
        
        // Search by nama kelas or kode kelas
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_kelas', 'like', "%{$search}%")
                  ->orWhere('kode_kelas', 'like', "%{$search}%");
            });
        }
        
        $kelas = $query->latest()->paginate(10);
        
        return view('admin.laporan.kelas', compact('kelas'));
    }

    /**
     * Laporan Siswa Per Kelas
     */
    public function siswaPerKelas(Request $request)
    {
        $kelas = $this->getSekolahOptions(Kelas::query(), Kelas::class)->get();
        $selectedKelas = null;
        $siswa = null;
        
        if ($request->filled('kelas')) {
            $selectedKelas = Kelas::where('kode_kelas', $request->kelas)->first();
            if ($selectedKelas) {
                $siswa = Siswa::where('kode_kelas', $request->kelas)
                    ->with('kelas')
                    ->latest()
                    ->get();
            }
        }
        
        return view('admin.laporan.siswa-per-kelas', compact('kelas', 'selectedKelas', 'siswa'));
    }

    /**
     * Laporan Ujian
     */
    public function ujian(Request $request)
    {
        $query = $this->addSekolahFilter(Ujian::with('mapel', 'sekolah'), Ujian::class);
        
        // Search by kode ujian or nama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_ujian', 'like', "%{$search}%")
                  ->orWhere('nama_ujian', 'like', "%{$search}%");
            });
        }
        
        // Filter by mapel
        if ($request->filled('mapel')) {
            $query->where('kode_mapel', $request->mapel);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $ujian = $query->latest()->paginate(10);
        
        return view('admin.laporan.ujian', compact('ujian'));
    }

    /**
     * Laporan Nilai
     */
    public function nilai(Request $request)
    {
        $query = $this->addSekolahFilter(JawabanSiswa::with('siswa.kelas', 'ujian.mapel'), JawabanSiswa::class);

        // Filter by ujian
        if ($request->filled('ujian')) {
            $query->where('kode_ujian', $request->ujian);
        }

        // Filter by kelas
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kode_kelas', $request->kelas);
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jawabanSiswa = $query->latest()->paginate(10);
        $ujian = $this->getSekolahOptions(Ujian::query(), Ujian::class)->get();
        $kelas = $this->getSekolahOptions(Kelas::query(), Kelas::class)->get();

        return view('admin.laporan.nilai', compact('jawabanSiswa', 'ujian', 'kelas'));
    }

    /**
     * Print Laporan Nilai
     */
    public function nilaiPrint(Request $request)
    {
        $query = $this->addSekolahFilter(JawabanSiswa::with('siswa.kelas', 'ujian.mapel'), JawabanSiswa::class);

        // Filter by ujian
        if ($request->filled('ujian')) {
            $query->where('kode_ujian', $request->ujian);
        }

        // Filter by kelas
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kode_kelas', $request->kelas);
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jawabanSiswa = $query->latest()->get();
        $selectedUjian = null;
        $selectedKelas = null;

        if ($request->filled('ujian')) {
            $selectedUjian = Ujian::where('kode_ujian', $request->ujian)->first();
        }

        if ($request->filled('kelas')) {
            $selectedKelas = Kelas::where('kode_kelas', $request->kelas)->first();
        }

        return view('admin.laporan.nilai-print', compact('jawabanSiswa', 'selectedUjian', 'selectedKelas'));
    }

    /**
     * Laporan Kehadiran
     */
    public function kehadiran(Request $request)
    {
        // Placeholder for kehadiran logic
        // You can implement attendance tracking here
        return view('admin.laporan.kehadiran');
    }

    /**
     * Laporan Pembayaran
     */
    public function pembayaran(Request $request)
    {
        // Placeholder for pembayaran logic
        // You can implement payment tracking here
        return view('admin.laporan.pembayaran');
    }

    /**
     * Laporan Kartu Ujian
     */
    public function kartuUjian(Request $request)
    {
        $query = $this->addSekolahFilter(Siswa::with('kelas', 'sekolah'), Siswa::class);

        // Filter by kelas
        if ($request->filled('kelas')) {
            $query->where('kode_kelas', $request->kelas);
        }

        // Filter by ujian
        if ($request->filled('ujian')) {
            $query->whereHas('kelas', function($q) use ($request) {
                $q->where('tingkat', Ujian::where('kode_ujian', $request->ujian)->value('tingkat'));
            });
        }

        $siswa = $query->latest()->get();
        $kelas = $this->getSekolahOptions(Kelas::query(), Kelas::class)->get();
        $ujian = $this->getSekolahOptions(Ujian::query(), Ujian::class)->get();

        $selectedKelas = null;
        $selectedUjian = null;

        if ($request->filled('kelas')) {
            $selectedKelas = Kelas::where('kode_kelas', $request->kelas)->first();
        }

        if ($request->filled('ujian')) {
            $selectedUjian = Ujian::where('kode_ujian', $request->ujian)->first();
        }

        return view('admin.laporan.kartu-ujian', compact('siswa', 'kelas', 'ujian', 'selectedKelas', 'selectedUjian'));
    }

    /**
     * Print Kartu Ujian
     */
    public function printKartuUjian(Request $request)
    {
        $query = $this->addSekolahFilter(Siswa::with('kelas', 'sekolah'), Siswa::class);

        // Filter by kelas
        if ($request->filled('kelas')) {
            $query->where('kode_kelas', $request->kelas);
        }

        // Filter by ujian
        if ($request->filled('ujian')) {
            $query->whereHas('kelas', function($q) use ($request) {
                $q->where('tingkat', Ujian::where('kode_ujian', $request->ujian)->value('tingkat'));
            });
        }

        $siswa = $query->latest()->get();
        $selectedKelas = null;
        $selectedUjian = null;

        if ($request->filled('kelas')) {
            $selectedKelas = Kelas::where('kode_kelas', $request->kelas)->first();
        }

        if ($request->filled('ujian')) {
            $selectedUjian = Ujian::where('kode_ujian', $request->ujian)->first();
        }

        return view('admin.laporan.kartu-ujian-print', compact('siswa', 'selectedKelas', 'selectedUjian'));
    }
}
