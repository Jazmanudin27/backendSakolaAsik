<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Helpers\UserRoleHelper;

class AdminKelasController extends SekolahAwareController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Kelas::select('kelas.*', 'jurusans.nama_jurusan as jurusan_nama')
            ->leftJoin('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas');
        
        $kelas = $this->addSekolahFilter($query, 'Kelas')->paginate(10);
        return view('admin.kelas.index', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusans = $this->getSekolahOptions(Jurusan::orderBy('nama_jurusan'), Jurusan::class)->get();
        return view('admin.kelas.create', compact('jurusans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:20|unique:kelas,nama_kelas',
            'tingkat' => 'required|string|max:10',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'wali_kelas' => 'nullable|string|max:100',
            'kapasitas' => 'required|integer|min:1|max:100',
            'jumlah_siswa' => 'required|integer|min:0|max:100',
            'ruangan' => 'nullable|string|max:20',
            'status' => 'required|string|in:Aktif,Tidak Aktif',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->all();
        // Untuk Admin: gunakan sekolah dari form
        // Untuk Guru: gunakan sekolahnya sendiri
        if ($this->isGuru()) {
            $data['id_sekolah'] = $this->getCurrentSekolahId();
        }
        Kelas::create($data);

        return redirect()->route(UserRoleHelper::getCurrentUserRole().'.kelas.index')
            ->with('success', 'Data kelas berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kelas = $this->addSekolahFilter(Kelas::with(['jurusan', 'siswas']), Kelas::class)->findOrFail($id);
        return view('admin.kelas.show', compact('kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kelas = $this->addSekolahFilter(Kelas::with('jurusan'), Kelas::class)->findOrFail($id);
        $jurusans = $this->getSekolahOptions(Jurusan::orderBy('nama_jurusan'), Jurusan::class)->get();
        return view('admin.kelas.edit', compact('kelas', 'jurusans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kelas = $this->addSekolahFilter(Kelas::findOrFail($id), Kelas::class);

        $request->validate([
            'nama_kelas' => 'required|string|max:20|unique:kelas,nama_kelas,' . $id,
            'tingkat' => 'required|string|max:10',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'wali_kelas' => 'nullable|string|max:100',
            'kapasitas' => 'required|integer|min:1|max:100',
            'jumlah_siswa' => 'required|integer|min:0|max:100',
            'ruangan' => 'nullable|string|max:20',
            'status' => 'required|string|in:Aktif,Tidak Aktif',
            'keterangan' => 'nullable|string',
        ]);

        $kelas->update($request->all());

        return redirect()->route(UserRoleHelper::getCurrentUserRole().'.kelas.index')
            ->with('success', 'Data kelas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelas = $this->addSekolahFilter(Kelas::findOrFail($id), Kelas::class);
        $kelas->delete();

        return redirect()->route(UserRoleHelper::getCurrentUserRole().'.kelas.index')
            ->with('success', 'Data kelas berhasil dihapus!');
    }
}
