<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SekolahAwareController;
use App\Models\Guru;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class AdminGuruController extends SekolahAwareController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gurus = $this->addSekolahFilter(Guru::with('sekolah'), Guru::class)->orderBy('nama_guru')->paginate(10);
        return view('admin.guru.index', compact('gurus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sekolah = $this->getSekolahOptions(Sekolah::query(), Sekolah::class)->get();
        return view('admin.guru.create', compact('sekolah'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:20|unique:gurus,nip',
            'nama_guru' => 'required|string|max:100',
            'jk' => 'required|string|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string|max:50',
            'tgl_lahir' => 'nullable|date',
            'alamat' => 'required|string',
            'no_hp' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:100|unique:gurus,email',
            'pendidikan_terakhir' => 'required|string|max:50',
            'jurusan' => 'required|string|max:100',
            'status' => 'required|string|in:Aktif,Tidak Aktif,Cuti',
            'jabatan' => 'required|string|max:50',
            'id_sekolah' => 'required|exists:sekolah,kode_sekolah',
        ]);

        $guruData = $request->all();
        // Untuk Admin: gunakan sekolah dari form
        // Untuk Guru: gunakan sekolahnya sendiri
        if ($this->isGuru()) {
            $guruData['id_sekolah'] = $this->getCurrentSekolahId();
        }
        Guru::create($guruData);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $guru = $this->addSekolahFilter(Guru::with('sekolah'), Guru::class)->findOrFail($id);
        return view('admin.guru.show', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $guru = $this->addSekolahFilter(Guru::query(), Guru::class)->findOrFail($id);
        $sekolah = $this->getSekolahOptions(Sekolah::query(), Sekolah::class)->get();
        return view('admin.guru.edit', compact('guru', 'sekolah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $guru = $this->addSekolahFilter(Guru::query(), Guru::class)->findOrFail($id);

        $request->validate([
            'nip' => 'required|string|max:20|unique:gurus,nip,' . $id,
            'nama_guru' => 'required|string|max:100',
            'jk' => 'required|string|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string|max:50',
            'tgl_lahir' => 'nullable|date',
            'alamat' => 'required|string',
            'no_hp' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:100|unique:gurus,email,' . $id,
            'pendidikan_terakhir' => 'required|string|max:50',
            'jurusan' => 'required|string|max:100',
            'status' => 'required|string|in:Aktif,Tidak Aktif,Cuti',
            'jabatan' => 'required|string|max:50',
            'id_sekolah' => 'required|exists:sekolah,kode_sekolah',
        ]);

        $guru->update($request->all());

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guru = $this->addSekolahFilter(Guru::query(), Guru::class)->findOrFail($id);
        $guru->delete();

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil dihapus!');
    }
}
