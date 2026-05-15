<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;

class AdminJurusanController extends SekolahAwareController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurusans = $this->addSekolahFilter(Jurusan::orderBy('nama_jurusan'), Jurusan::class)->paginate(10);
        return view('admin.jurusan.index', compact('jurusans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jurusan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:100|unique:jurusans,nama_jurusan',
            'singkatan' => 'required|string|max:20|unique:jurusans,singkatan',
            'deskripsi' => 'nullable|string',
            'kepala_jurusan' => 'nullable|string|max:100',
            'jenis' => 'required|string|in:Akademik,Vokasi',
            'status' => 'required|string|in:Aktif,Tidak Aktif',
        ]);

        $jurusanData = $request->all();
        // Untuk Admin: gunakan sekolah dari form
        // Untuk Guru: gunakan sekolahnya sendiri
        if ($this->isGuru()) {
            $jurusanData['id_sekolah'] = $this->getCurrentSekolahId();
        }
        Jurusan::create($jurusanData);

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Data jurusan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jurusan = $this->addSekolahFilter(Jurusan::with(['kelas', 'soalUjians']), Jurusan::class)->findOrFail($id);
        return view('admin.jurusan.show', compact('jurusan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jurusan = $this->addSekolahFilter(Jurusan::query(), Jurusan::class)->findOrFail($id);
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jurusan = $this->addSekolahFilter(Jurusan::query(), Jurusan::class)->findOrFail($id);

        $request->validate([
            'nama_jurusan' => 'required|string|max:100|unique:jurusans,nama_jurusan,' . $id,
            'singkatan' => 'required|string|max:20|unique:jurusans,singkatan,' . $id,
            'deskripsi' => 'nullable|string',
            'kepala_jurusan' => 'nullable|string|max:100',
            'jenis' => 'required|string|in:Akademik,Vokasi',
            'status' => 'required|string|in:Aktif,Tidak Aktif',
        ]);

        $jurusan->update($request->all());

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Data jurusan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jurusan = $this->addSekolahFilter(Jurusan::query(), Jurusan::class)->findOrFail($id);
        $jurusan->delete();

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Data jurusan berhasil dihapus!');
    }
}
