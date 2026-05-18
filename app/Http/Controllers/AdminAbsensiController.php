<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SekolahAwareController;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\UserRoleHelper;

class AdminAbsensiController extends SekolahAwareController
{
    public function index(Request $request)
    {
        $query = $this->addSekolahFilter(Absensi::with('siswa', 'sekolah'), Absensi::class);
        
        // Search by student name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date
        if ($request->filled('tanggal')) {
            $query->where('tanggal_absensi', $request->tanggal);
        }
        
        // Filter by kelas
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kode_kelas', $request->kelas);
            });
        }
        
        $absensi = $query->latest()->paginate(10);
        $siswa = $this->getSekolahOptions(Siswa::query(), Siswa::class)->get();
        
        return view('admin.absensi.index', compact('absensi', 'siswa'));
    }

    public function create()
    {
        $siswa = $this->getSekolahOptions(Siswa::with('kelas'), Siswa::class)->get();
        return view('admin.absensi.create', compact('siswa'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_siswa' => 'required|exists:siswa,kode_siswa',
            'tanggal_absensi' => 'required|date',
            'status' => 'required|in:Hadir,Sakit,Izin,Alpha',
            'keterangan' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        // Get student's school
        $siswa = Siswa::find($request->kode_siswa);
        $data['id_sekolah'] = $siswa->id_sekolah;

        Absensi::create($data);

        return redirect()->route(UserRoleHelper::getCurrentUserRole().'.absensi.index')
            ->with('success', 'Data absensi berhasil ditambahkan!');
    }

    public function show($id)
    {
        $absensi = $this->addSekolahFilter(Absensi::with('siswa', 'sekolah'), Absensi::class)->findOrFail($id);
        return view('admin.absensi.show', compact('absensi'));
    }

    public function edit($id)
    {
        $absensi = $this->addSekolahFilter(Absensi::query(), Absensi::class)->findOrFail($id);
        $siswa = $this->getSekolahOptions(Siswa::with('kelas'), Siswa::class)->get();
        return view('admin.absensi.edit', compact('absensi', 'siswa'));
    }

    public function update(Request $request, $id)
    {
        $absensi = $this->addSekolahFilter(Absensi::query(), Absensi::class)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'kode_siswa' => 'required|exists:siswa,kode_siswa',
            'tanggal_absensi' => 'required|date',
            'status' => 'required|in:Hadir,Sakit,Izin,Alpha',
            'keterangan' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        // Get student's school
        $siswa = Siswa::find($request->kode_siswa);
        $data['id_sekolah'] = $siswa->id_sekolah;

        $absensi->update($data);

        return redirect()->route(UserRoleHelper::getCurrentUserRole().'.absensi.index')
            ->with('success', 'Data absensi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $absensi = $this->addSekolahFilter(Absensi::query(), Absensi::class)->findOrFail($id);
        $absensi->delete();

        return redirect()->route(UserRoleHelper::getCurrentUserRole().'.absensi.index')
            ->with('success', 'Data absensi berhasil dihapus!');
    }
}
