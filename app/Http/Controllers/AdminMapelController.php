<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Helpers\UserRoleHelper;

class AdminMapelController extends SekolahAwareController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mapels = $this->addSekolahFilter(Mapel::orderBy('kelompok')->orderBy('nama_mapel'), Mapel::class)->paginate(10);
        return view('admin.mapel.index', ['mapels' => $mapels]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mapel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|string|max:10|unique:mapels,kode_mapel',
            'nama_mapel' => 'required|string|max:100',
            'singkatan' => 'required|string|max:20',
            'kelompok' => 'required|string|in:A,B,C,Muatan Lokal,Peminatan',
            'jenis' => 'required|string|in:Wajib,Pilihan',
            'jam_per_minggu' => 'required|integer|min:1|max:10',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string|in:Aktif,Tidak Aktif',
        ]);

        $mapelData = $request->all();
        // Untuk Admin: gunakan sekolah dari form
        // Untuk Guru: gunakan sekolahnya sendiri
        if ($this->isGuru()) {
            $mapelData['id_sekolah'] = $this->getCurrentSekolahId();
        }
        Mapel::create($mapelData);

        return redirect()->route(UserRoleHelper::getCurrentUserRole().'.mapel.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mapel = $this->addSekolahFilter(Mapel::query(), Mapel::class)->findOrFail($id);
        return view('admin.mapel.show', ['mapel' => $mapel]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mapel = $this->addSekolahFilter(Mapel::query(), Mapel::class)->findOrFail($id);
        return view('admin.mapel.edit', ['mapel' => $mapel]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mapel = $this->addSekolahFilter(Mapel::query(), Mapel::class)->findOrFail($id);

        $request->validate([
            'kode_mapel' => 'required|string|max:10|unique:mapels,kode_mapel,' . $id,
            'nama_mapel' => 'required|string|max:100',
            'singkatan' => 'required|string|max:20',
            'kelompok' => 'required|string|in:A,B,C,Muatan Lokal,Peminatan',
            'jenis' => 'required|string|in:Wajib,Pilihan',
            'jam_per_minggu' => 'required|integer|min:1|max:10',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string|in:Aktif,Tidak Aktif',
        ]);

        $mapel->update($request->all());

        return redirect()->route(UserRoleHelper::getCurrentUserRole().'.mapel.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mapel = $this->addSekolahFilter(Mapel::query(), Mapel::class)->findOrFail($id);
        $mapel->delete();

        return redirect()->route(UserRoleHelper::getCurrentUserRole().'.mapel.index')
            ->with('success', 'Mata pelajaran berhasil dihapus!');
    }
}
