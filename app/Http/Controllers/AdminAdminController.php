<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SekolahAwareController;
use App\Models\Admin;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAdminController extends SekolahAwareController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $this->addSekolahFilter(Admin::with('sekolah'), Admin::class);
        
        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $admins = $query->latest()->paginate(10);
        
        return view('admin.admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sekolah = $this->getSekolahOptions(\App\Models\Sekolah::query(), \App\Models\Sekolah::class)->get();
        return view('admin.admin.create', compact('sekolah'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
            'password' => 'required|string|min:6',
            'id_sekolah' => 'nullable|exists:sekolah,kode_sekolah',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        // Untuk Admin: gunakan sekolah dari form
        // Untuk Guru: gunakan sekolahnya sendiri
        if ($this->isGuru()) {
            $data['id_sekolah'] = $this->getCurrentSekolahId();
        }

        Admin::create($data);

        return redirect()->route('admin.admin.index')
            ->with('success', 'Data admin berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $admin = $this->addSekolahFilter(Admin::with('sekolah'), Admin::class)->findOrFail($id);
        return view('admin.admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $admin = $this->addSekolahFilter(Admin::query(), Admin::class)->findOrFail($id);
        $sekolah = $this->getSekolahOptions(\App\Models\Sekolah::query(), \App\Models\Sekolah::class)->get();
        return view('admin.admin.edit', compact('admin', 'sekolah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $admin = $this->addSekolahFilter(Admin::query(), Admin::class)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $id,
            'password' => 'nullable|string|min:6',
            'id_sekolah' => 'nullable|exists:sekolah,kode_sekolah',
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

        // Untuk Admin: gunakan sekolah dari form
        // Untuk Guru: gunakan sekolahnya sendiri
        if ($this->isGuru()) {
            $data['id_sekolah'] = $this->getCurrentSekolahId();
        }

        $admin->update($data);

        return redirect()->route('admin.admin.index')
            ->with('success', 'Data admin berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $admin = $this->addSekolahFilter(Admin::query(), Admin::class)->findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.admin.index')
            ->with('success', 'Data admin berhasil dihapus!');
    }
}
