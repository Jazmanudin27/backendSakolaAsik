<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\UserRoleHelper;
use App\Models\DetailKartuUjian;
use App\Models\KartuUjian;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminKartuUjianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KartuUjian::with('kelas');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_ujian', 'like', "%{$search}%")
                  ->orWhere('tahun_ajaran', 'like', "%{$search}%");
            });
        }
        
        // Filter by kelas
        if ($request->filled('id_kelas')) {
            $query->where('id_kelas', $request->id_kelas);
        }
        
        $kartuUjians = $query->latest()->paginate(10);
        $kelasList = Kelas::all();
        
        return view('admin.kartu-ujian.index', compact('kartuUjians', 'kelasList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelasList = Kelas::all();
        $tahunAjaranList = TahunAjaran::all();
        return view('admin.kartu-ujian.create', compact('kelasList', 'tahunAjaranList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_ujian' => 'required|string|max:255',
            'id_tahun_ajaran' => 'required|exists:tahun_ajarans,id',
            'id_kelas' => 'required|exists:kelas,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan kartu ujian
        $kartuUjian = KartuUjian::create([
            'nama_ujian' => $request->nama_ujian,
            'id_tahun_ajaran' => $request->id_tahun_ajaran,
            'id_kelas' => $request->id_kelas,
            'id_sekolah' => Auth::user()->id_sekolah,
        ]);

        // Ambil siswa berdasarkan kelas
        $siswas = Siswa::where('kode_kelas', $request->id_kelas)
            ->where('status', 'Aktif')
            ->get();

        // Simpan detail kartu ujian
        foreach ($siswas as $siswa) {
            DetailKartuUjian::create([
                'kartu_ujian_id' => $kartuUjian->id,
                'id_siswa' => $siswa->kode_siswa,
                'ruangan' => null,
            ]);
        }

        return redirect()->route(UserRoleHelper::getCurrentUserRole().'.kartu-ujian.index')
            ->with('success', 'Kartu Ujian berhasil ditambahkan!');
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kartuUjian = KartuUjian::with('kelas', 'detailKartuUjian.siswa')->findOrFail($id);
        return view('admin.kartu-ujian.show', compact('kartuUjian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kartuUjian = KartuUjian::findOrFail($id);
        $kelasList = Kelas::all();
        $tahunAjaranList = TahunAjaran::all();
        return view('admin.kartu-ujian.edit', compact('kartuUjian', 'kelasList', 'tahunAjaranList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kartuUjian = KartuUjian::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_ujian' => 'required|string|max:255',
            'id_tahun_ajaran' => 'required|exists:tahun_ajarans,id',
            'id_kelas' => 'required|exists:kelas,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kartuUjian->update($request->all());

        return redirect()->route(UserRoleHelper::getCurrentUserRole().'.kartu-ujian.index')
            ->with('success', 'Kartu Ujian berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kartuUjian = KartuUjian::findOrFail($id);
        $kartuUjian->delete();

        return redirect()->route(UserRoleHelper::getCurrentUserRole().'.kartu-ujian.index')
            ->with('success', 'Kartu Ujian berhasil dihapus!');
    }

    /**
     * Print Kartu Ujian
     */
    public function print($id)
    {
        $kartuUjian = KartuUjian::with('kelas', 'detailKartuUjian')->findOrFail($id);
        $detailKartuUjian = DetailKartuUjian::where('kartu_ujian_id', $kartuUjian->id)
            ->with('siswa.kelas', 'siswa.sekolah')
            ->latest()
            ->get();
        
        $selectedUjian = $kartuUjian;
        
        return view('admin.kartu-ujian.kartu-ujian-print', compact('detailKartuUjian', 'selectedUjian'));
    }

    /**
     * Update Ruangan for Detail Kartu Ujian
     */
    public function updateRuangan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ruangan' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $detailKartuUjian = DetailKartuUjian::findOrFail($id);
        $detailKartuUjian->update([
            'ruangan' => $request->ruangan,
        ]);

        return redirect()->back()->with('success', 'Ruangan berhasil diperbarui!');
    }
}
