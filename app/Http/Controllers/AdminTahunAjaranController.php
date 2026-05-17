<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Helpers\UserRoleHelper;

class AdminTahunAjaranController extends SekolahAwareController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahunAjarans = $this->addSekolahFilter(TahunAjaran::orderBy('tahun_ajaran', 'desc'), TahunAjaran::class)->paginate(10);
        return view('admin.tahun_ajaran.index', compact('tahunAjarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tahun_ajaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20|unique:tahun_ajarans,tahun_ajaran',
            'semester' => 'required|string|in:Ganjil,Genap',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|string|in:Aktif,Tidak Aktif',
            'keterangan' => 'nullable|string',
        ]);

        $tahunAjaranData = $request->all();
        // Untuk Admin: gunakan sekolah dari form
        // Untuk Guru: gunakan sekolahnya sendiri
        if ($this->isGuru()) {
            $tahunAjaranData['id_sekolah'] = $this->getCurrentSekolahId();
        }
        TahunAjaran::create($tahunAjaranData);

        return redirect()->route(UserRoleHelper::getCurrentUserRole().'.tahun_ajaran.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tahunAjaran = $this->addSekolahFilter(TahunAjaran::query(), TahunAjaran::class)->findOrFail($id);
        return view('admin.tahun_ajaran.show', compact('tahunAjaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tahunAjaran = $this->addSekolahFilter(TahunAjaran::query(), TahunAjaran::class)->findOrFail($id);
        return view('admin.tahun_ajaran.edit', compact('tahunAjaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tahunAjaran = $this->addSekolahFilter(TahunAjaran::query(), TahunAjaran::class)->findOrFail($id);

        $request->validate([
            'tahun_ajaran' => 'required|string|max:20|unique:tahun_ajarans,tahun_ajaran,' . $id,
            'semester' => 'required|string|in:Ganjil,Genap',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|string|in:Aktif,Tidak Aktif',
            'keterangan' => 'nullable|string',
        ]);

        $tahunAjaran->update($request->all());

        return redirect()->route(UserRoleHelper::getCurrentUserRole().'.tahun_ajaran.index')
            ->with('success', 'Tahun ajaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tahunAjaran = $this->addSekolahFilter(TahunAjaran::query(), TahunAjaran::class)->findOrFail($id);
        $tahunAjaran->delete();

        return redirect()->route(UserRoleHelper::getCurrentUserRole().'.tahun_ajaran.index')
            ->with('success', 'Tahun ajaran berhasil dihapus!');
    }
}
