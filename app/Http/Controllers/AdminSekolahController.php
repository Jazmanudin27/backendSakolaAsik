<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SekolahAwareController;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminSekolahController extends SekolahAwareController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sekolah::query();
        
        // Search by name or kode_sekolah
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_sekolah', 'like', "%{$search}%")
                  ->orWhere('kode_sekolah', 'like', "%{$search}%")
                  ->orWhere('npsn', 'like', "%{$search}%");
            });
        }
        
        // Filter by jenjang
        if ($request->filled('jenjang')) {
            $query->where('jenjang', $request->jenjang);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $sekolahs = $query->latest()->paginate(10);
        
        return view('admin.sekolah.index', compact('sekolahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sekolah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_sekolah' => 'required|string|max:255',
            'alamat' => 'required|string',
            'npsn' => 'required|string|max:20|unique:sekolah,npsn',
            'kepala_sekolah' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'jenjang' => 'required|string|max:50',
            'status' => 'required|string|max:50',
            'kabupaten_kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Sekolah::create($request->all());

        return redirect()->route('admin.sekolah.index')
            ->with('success', 'Data sekolah berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        return view('admin.sekolah.show', compact('sekolah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        return view('admin.sekolah.edit', compact('sekolah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $sekolah = Sekolah::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_sekolah' => 'required|string|max:255',
            'alamat' => 'required|string',
            'npsn' => 'required|string|max:20|unique:sekolah,npsn,' . $id . ',kode_sekolah',
            'kepala_sekolah' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'jenjang' => 'required|string|max:50',
            'status' => 'required|string|max:50',
            'kabupaten_kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $sekolah->update($request->all());

        return redirect()->route('admin.sekolah.index')
            ->with('success', 'Data sekolah berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        $sekolah->delete();

        return redirect()->route('admin.sekolah.index')
            ->with('success', 'Data sekolah berhasil dihapus!');
    }
}
