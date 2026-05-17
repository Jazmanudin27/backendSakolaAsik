<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SekolahAwareController;
use App\Models\Siswa;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Helpers\UserRoleHelper;

class AdminSiswaController extends SekolahAwareController
{

    public function index(Request $request)
    {
        $query = $this->addSekolahFilter(Siswa::with('sekolah', 'kelas'), Siswa::class);
        
        // Search by name, NISN, or NIS
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
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
        
        $siswa = $query->latest()->paginate(10);
        
        return view('admin.siswa.index', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sekolah = $this->getSekolahOptions(\App\Models\Sekolah::query(), \App\Models\Sekolah::class)->get();
        $kelas = $this->getSekolahOptions(\App\Models\Kelas::query(), \App\Models\Kelas::class)->get();
        return view('admin.siswa.create', compact('sekolah', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nisn' => 'required|string|max:35|unique:siswa,nisn',
            'nis' => 'required|string|max:35|unique:siswa,nis',
            'nama_siswa' => 'required|string|max:100',
            'jk' => 'required|string|max:15',
            'alamat' => 'required|string|max:100',
            'email' => 'nullable|email|max:150|unique:siswa,email',
            'no_hp' => 'nullable|string|max:15',
            'tempat_lahir' => 'nullable|string|max:45',
            'tgl_lahir' => 'required|date',
            'agama' => 'nullable|string|max:45',
            'status' => 'nullable|string|max:30',
            'kode_kelas' => 'required|string|max:20',
            'id_sekolah' => 'required|exists:sekolah,kode_sekolah',
            'password' => 'required|string|min:6',
            'username' => 'required|string|max:100|unique:siswa,username',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $data['username'] = Str::lower($data['username']);

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            if ($foto->isValid()) {
                $fotoName = time() . '_' . Str::random(10) . '.' . $foto->getClientOriginalExtension();
                $destinationPath = public_path('storage/siswa');
                
                // Create directory if not exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                
                if ($foto->move($destinationPath, $fotoName)) {
                    $data['foto'] = $fotoName;
                }
            }
        }

        // Untuk Admin: gunakan sekolah dari form
        // Untuk Guru: gunakan sekolahnya sendiri
        if ($this->isGuru()) {
            $data['id_sekolah'] = $this->getCurrentSekolahId();
        }
        Siswa::create($data);

        return redirect()->route(UserRoleHelper::getCurrentUserRole().'.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $siswa = $this->addSekolahFilter(Siswa::with('sekolah'), Siswa::class)->findOrFail($id);
        return view('admin.siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $siswa = $this->addSekolahFilter(Siswa::query(), Siswa::class)->findOrFail($id);
        $sekolah = $this->getSekolahOptions(\App\Models\Sekolah::query(), \App\Models\Sekolah::class)->get();
        $kelas = $this->getSekolahOptions(\App\Models\Kelas::query(), \App\Models\Kelas::class)->get();
        return view('admin.siswa.edit', compact('siswa', 'sekolah', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $siswa = $this->addSekolahFilter(Siswa::query(), Siswa::class)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nisn' => 'required|string|max:35|unique:siswa,nisn,' . $id . ',kode_siswa',
            'nis' => 'required|string|max:35|unique:siswa,nis,' . $id . ',kode_siswa',
            'nama_siswa' => 'required|string|max:100',
            'jk' => 'required|string|max:15',
            'alamat' => 'required|string|max:100',
            'email' => 'nullable|email|max:150|unique:siswa,email,' . $id . ',kode_siswa',
            'no_hp' => 'nullable|string|max:15',
            'tempat_lahir' => 'nullable|string|max:45',
            'tgl_lahir' => 'required|date',
            'agama' => 'nullable|string|max:45',
            'status' => 'nullable|string|max:30',
            'kode_kelas' => 'required|string|max:20',
            'id_sekolah' => 'required|exists:sekolah,kode_sekolah',
            'username' => 'required|string|max:100|unique:siswa,username,' . $id . ',kode_siswa',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['password']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        $data['username'] = Str::lower($data['username']);

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            if ($foto->isValid()) {
                // Delete old photo if exists
                if ($siswa->foto && file_exists(public_path('storage/siswa/' . $siswa->foto))) {
                    unlink(public_path('storage/siswa/' . $siswa->foto));
                }
                
                $fotoName = time() . '_' . Str::random(10) . '.' . $foto->getClientOriginalExtension();
                $destinationPath = public_path('storage/siswa');
                
                // Create directory if not exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                
                if ($foto->move($destinationPath, $fotoName)) {
                    $data['foto'] = $fotoName;
                }
            }
        }

        $siswa->update($data);

        return redirect()->route(userRole().'.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $siswa = $this->addSekolahFilter(Siswa::query(), Siswa::class)->findOrFail($id);
        $siswa->delete();

        return redirect()->route(UserRoleHelper::getCurrentUserRole().'.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus!');
    }
}
