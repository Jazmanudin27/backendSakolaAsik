<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\DetailUjian;
use App\Models\UjianSoal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\TahunAjaran;
use App\Models\Jurusan;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Laravel\Facades\Image;

class UjianController extends SekolahAwareController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ujians = $this->addSekolahFilter(Ujian::with(['kelas', 'mapel', 'tahunPelajaran', 'jawabanSiswas' => function($query) {
            $query->where('status', 'submitted');
        }]), Ujian::class)
            ->orderBy('tanggal_ujian', 'desc')
            ->get();
        return view('admin.ujian.index', compact('ujians'));
    }

    public function generateKode(Request $request) { 
        $jenis = $request->jenis; 
        $mapel = $request->mapel; 
        $tahun = $request->tahun; 
        $prefix = $jenis . '-' . $mapel . '-' . $tahun; 
        $lastUjian = Ujian::where('kode_ujian', 'LIKE', $prefix . '-%') 
            ->orderBy('kode_ujian', 'desc') 
            ->first(); 
        $nomor = 1; 
        if ($lastUjian) { 
            $explode = explode('-', $lastUjian->kode_ujian); 
            $lastNumber = end($explode); 
            $nomor = intval($lastNumber) + 1; 
        } 
        return response()->json([ 'nomor' => $nomor ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = $this->addSekolahFilter(Kelas::query(), Kelas::class)->get();
        $mapels = $this->addSekolahFilter(Mapel::query(), Mapel::class)->get();
        $tahunAjarans = $this->addSekolahFilter(TahunAjaran::where('status', 'Aktif'), TahunAjaran::class)->get();
        $jurusans = $this->addSekolahFilter(Jurusan::where('status', 'Aktif')->orderBy('nama_jurusan'), Jurusan::class)->get();
        $sekolahs = \App\Models\Sekolah::orderBy('nama_sekolah')->get();
        return view('admin.ujian.create', compact('kelas', 'mapels', 'tahunAjarans', 'jurusans', 'sekolahs'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'kode_ujian' => 'required|string|unique:ujians,kode_ujian',
            'id_sekolah' => 'required|exists:sekolah,kode_sekolah',
            'tingkat' => 'required',
            'id_mapel' => 'required|exists:mapels,id',
            'id_tahun_ajaran' => 'required|exists:tahun_ajarans,id',
            'tanggal_ujian' => 'required|date',
            'durasi' => 'required|integer|min:1',
            'jenis_ujian' => 'required|in:Ujian Tengah Semester,Ujian Akhir Semester,Ujian Tengah Tahun,Ujian Akhir Tahun,Ujian Nasional',
            'status' => 'required|in:Draft,Aktif,Selesai,Dibatalkan',
            'keterangan' => 'nullable|string',

            'file_soal' => 'nullable|mimes:docx,pdf|max:10240',

            'gambar_soal.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'id_jurusan' => 'nullable|array',
            'id_jurusan.*' => 'exists:jurusans,id',
        ]);

        $ujianData = $request->all();

        $ujianData['id_sekolah'] = $this->getCurrentSekolahId();

        // Handle jurusan
        $ujianData['id_jurusan'] = $request->has('id_jurusan')
            ? $request->id_jurusan
            : null;

        // Upload file soal
        if ($request->hasFile('file_soal')) {

            $file = $request->file('file_soal');

            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            if (!is_dir(public_path('storage/soal_documents'))) {
                mkdir(public_path('storage/soal_documents'), 0755, true);
            }

            $file->move(public_path('storage/soal_documents'), $fileName);

            $ujianData['file_soal'] = $fileName;
        }

        // Simpan ujian
        $ujian = Ujian::create($ujianData);

        // Upload multiple gambar soal
        if ($request->hasFile('gambar_soal')) {
            $file = $request->file('gambar_soal');
            $fileName = time() . '_' . uniqid() . '.webp';
            if (!is_dir(public_path('storage/gambar_soal'))) {
                mkdir(public_path('storage/gambar_soal'), 0755, true);
            }
            foreach ($request->file('gambar_soal') as $file) {

                $fileName = time() . '_' . uniqid() . '.webp';

                $image = Image::read($file)
                    ->scale(width: 1200)
                    ->toWebp(75);

                $image->save(public_path('storage/gambar_soal/' . $fileName));

                UjianSoal::create([
                    'id_ujian' => $ujian->id,
                    'gambar_soal' => $fileName
                ]);
            }
        }

        return redirect()->route('admin.ujian.show', $ujian->id)
            ->with('success', 'Ujian berhasil dibuat.');
    }
    /**
     * Display cetak soal page.
     */
    public function cetakSoal(string $id)
    {
        $ujian = $this->addSekolahFilter(Ujian::with(['kelas', 'mapel', 'tahunPelajaran', 'detailUjians' => function($query) {
            return $query->orderByRaw("FIELD(tipe_soal, 'pilihan_ganda', 'essay', 'benar_salah', 'isian_singkat')")
                      ->orderByRaw("FIELD(tingkat_kesulitan, 'mudah', 'sedang', 'sulit', 'tinggi')");
        }]), Ujian::class)->findOrFail($id);
        
        return view('admin.ujian.cetak-preview', compact('ujian'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ujian = $this->addSekolahFilter(
            Ujian::with([
                'kelas',
                'mapel',
                'tahunPelajaran',
                'gambarSoals:id,id_ujian,gambar_soal',
                'detailUjians' => function ($query) {

                    return $query
                        ->select(
                            'id',
                            'id_ujian',
                            'soal',
                            'tipe_soal',
                            'kunci_jawaban',
                            'opsi_a',
                            'opsi_b',
                            'opsi_c',
                            'opsi_d',
                            'opsi_e'
                        )
                        ->orderByRaw("FIELD(tipe_soal, 'pilihan_ganda', 'benar_salah', 'isian_singkat','essay')")
                        ->orderByRaw("FIELD(tingkat_kesulitan, 'mudah', 'sedang', 'sulit', 'tinggi')");
                }

            ]),
            Ujian::class
        )->findOrFail($id);

        return view('admin.ujian.show', compact('ujian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ujian = $this->addSekolahFilter(
            Ujian::with(['gambarSoals:id,id_ujian,gambar_soal']),
            Ujian::class
        )->findOrFail($id);
        $sekolahs = $this->addSekolahFilter(\App\Models\Sekolah::query(), \App\Models\Sekolah::class)->get();
        $mapels = $this->addSekolahFilter(Mapel::query(), Mapel::class)->get();
        $tahunAjarans = $this->addSekolahFilter(TahunAjaran::where('status', 'Aktif'), TahunAjaran::class)->get();
        $jurusans = $this->addSekolahFilter(Jurusan::where('status', 'Aktif')->orderBy('nama_jurusan'), Jurusan::class)->get();
        return view('admin.ujian.edit', compact('ujian', 'sekolahs', 'mapels', 'tahunAjarans', 'jurusans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ujian = $this->addSekolahFilter(Ujian::query(), Ujian::class)->findOrFail($id);

        $request->validate([
            'kode_ujian' => 'required|string|unique:ujians,kode_ujian,' . $ujian->id,
            'id_sekolah' => 'required|exists:sekolah,kode_sekolah',
            'tingkat' => 'required',
            'id_mapel' => 'required|exists:mapels,id',
            'id_tahun_ajaran' => 'required|exists:tahun_ajarans,id',
            'tanggal_ujian' => 'required|date',
            'durasi' => 'required|integer|min:1',
            'jenis_ujian' => 'required|in:Ujian Tengah Semester,Ujian Akhir Semester,Ujian Tengah Tahun,Ujian Akhir Tahun,Ujian Nasional',
            'status' => 'required|in:Draft,Aktif,Selesai,Dibatalkan',
            'keterangan' => 'nullable|string',
            'file_soal' => 'nullable|mimes:docx,pdf|max:10240',
            'gambar_soal.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'id_jurusan' => 'nullable|array',
            'id_jurusan.*' => 'exists:jurusans,id',
        ]);

        $ujianData = $request->all();
        $ujianData['id_sekolah'] = $this->getCurrentSekolahId();

        // Handle jurusan
        $ujianData['id_jurusan'] = $request->has('id_jurusan')
            ? $request->id_jurusan
            : null;

        // Upload file soal
        if ($request->hasFile('file_soal')) {
            $file = $request->file('file_soal');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            if (!is_dir(public_path('storage/soal_documents'))) {
                mkdir(public_path('storage/soal_documents'), 0755, true);
            }
            $file->move(public_path('storage/soal_documents'), $fileName);
            $ujianData['file_soal'] = $fileName;
        }

        // Update ujian
        $ujian->update($ujianData);

        // Upload multiple gambar soal
        if ($request->hasFile('gambar_soal')) {
            if (!is_dir(public_path('storage/gambar_soal'))) {
                mkdir(public_path('storage/gambar_soal'), 0755, true);
            }
            foreach ($request->file('gambar_soal') as $file) {
                $fileName = time() . '_' . uniqid() . '.webp';
                $image = Image::read($file)
                    ->scale(width: 1200)
                    ->toWebp(75);
                $image->save(public_path('storage/gambar_soal/' . $fileName));
                UjianSoal::create([
                    'id_ujian' => $ujian->id,
                    'gambar_soal' => $fileName
                ]);
            }
        }

        return redirect()->route('admin.ujian.show', $ujian->id)
            ->with('success', 'Ujian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ujian = $this->addSekolahFilter(Ujian::query(), Ujian::class)->findOrFail($id);
        $ujian->delete();

        return redirect()->route('admin.ujian.index')
            ->with('success', 'Ujian berhasil dihapus.');
    }

    /**
     * Delete gambar soal
     */
    public function deleteGambar(Request $request)
    {
        $gambar = UjianSoal::findOrFail($request->id);
        
        // Delete file from storage
        $filePath = public_path('storage/gambar_soal/' . $gambar->gambar_soal);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        
        // Delete record from database
        $gambar->delete();
        
        return response()->json(['success' => true]);
    }

    /**
     * Show the form for creating soal for ujian.
     */
    public function createSoal(string $id)
    {
        $ujian = $this->addSekolahFilter(Ujian::query(), Ujian::class)->findOrFail($id);
        return view('admin.ujian.create-soal', compact('ujian'));
    }

    /**
     * Store soal for ujian.
     */
    public function storeSoal(Request $request, string $id)
    {
        $request->validate([
            'soal' => 'required|string',
            'soal_editor' => 'nullable|string',
            'gambar_soal' => 'sometimes|file|max:2048',
            'tipe_soal' => 'required|in:pilihan_ganda,essay,benar_salah,isian_singkat',
            'opsi_a' => 'required_if:tipe_soal,pilihan_ganda|string',
            'opsi_b' => 'required_if:tipe_soal,pilihan_ganda|string',
            'opsi_c' => 'nullable|string',
            'opsi_d' => 'nullable|string',
            'opsi_e' => 'nullable|string',
            'kunci_jawaban' => 'required|string',
            'bobot' => 'required|integer|min:1',
            'pembahasan' => 'nullable|string',
            'tingkat_kesulitan' => 'required|in:mudah,sedang,sulit',
        ]);

        $data = $request->all();
        $data['id_ujian'] = $id;

        // Handle image upload
        if ($request->hasFile('gambar_soal')) {
            $image = $request->file('gambar_soal');
            
            // Manual validation for file type
            $allowedTypes = ['jpeg', 'jpg', 'png', 'gif'];
            $extension = strtolower($image->getClientOriginalExtension());
            
            if (!in_array($extension, $allowedTypes)) {
                return redirect()->back()
                    ->withErrors(['gambar_soal' => 'File harus berupa gambar dengan format: jpeg, jpg, png, gif'])
                    ->withInput();
            }
            
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/gambar_soal'), $imageName);
            $data['gambar_soal'] = 'gambar_soal/' . $imageName;
        }

        // Merge editor content if available
        if (!empty($request->soal_editor)) {
            $data['soal'] = $request->soal_editor;
        }

        DetailUjian::create($data);

        return redirect()->route('admin.ujian.show', $id)
            ->with('success', 'Soal berhasil ditambahkan.');
    }

    /**
     * Show the form for editing soal.
     */
    public function editSoal(string $id, string $soalId)
    {
        $ujian = $this->addSekolahFilter(Ujian::query(), Ujian::class)->findOrFail($id);
        $soal = DetailUjian::findOrFail($soalId);
        return view('admin.ujian.edit-soal', compact('ujian', 'soal'));
    }

    /**
     * Update soal.
     */
    public function updateSoal(Request $request, string $id, string $soalId)
    {
        $soal = DetailUjian::findOrFail($soalId);

        $request->validate([
            'soal' => 'required|string',
            'soal_editor' => 'nullable|string',
            'gambar_soal' => 'sometimes|file|max:2048',
            'tipe_soal' => 'required|in:pilihan_ganda,essay,benar_salah,isian_singkat',
            'opsi_a' => 'required_if:tipe_soal,pilihan_ganda|string',
            'opsi_b' => 'required_if:tipe_soal,pilihan_ganda|string',
            'opsi_c' => 'nullable|string',
            'opsi_d' => 'nullable|string',
            'opsi_e' => 'nullable|string',
            'kunci_jawaban' => 'required|string',
            'bobot' => 'required|integer|min:1',
            'pembahasan' => 'nullable|string',
            'tingkat_kesulitan' => 'required|in:mudah,sedang,sulit',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('gambar_soal')) {
            $image = $request->file('gambar_soal');
            
            // Manual validation for file type
            $allowedTypes = ['jpeg', 'jpg', 'png', 'gif'];
            $extension = strtolower($image->getClientOriginalExtension());
            
            if (!in_array($extension, $allowedTypes)) {
                return redirect()->back()
                    ->withErrors(['gambar_soal' => 'File harus berupa gambar dengan format: jpeg, jpg, png, gif'])
                    ->withInput();
            }
            
            // Delete old image if exists
            if ($soal->gambar_soal && file_exists(public_path('storage/' . $soal->gambar_soal))) {
                unlink(public_path('storage/' . $soal->gambar_soal));
            }
            
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/gambar_soal'), $imageName);
            $data['gambar_soal'] = 'gambar_soal/' . $imageName;
        }

        // Merge editor content if available
        if (!empty($request->soal_editor)) {
            $data['soal'] = $request->soal_editor;
        }

        $soal->update($data);

        return redirect()->route('admin.ujian.show', $id)
            ->with('success', 'Soal berhasil diperbarui.');
    }

    /**
     * Update kunci jawaban.
     */
    public function updateKunci(Request $request, string $id, string $soalId)
    {
        $soal = DetailUjian::findOrFail($soalId);

        $request->validate([
            'kunci_jawaban' => 'required|string|max:255',
        ]);

        $soal->update([
            'kunci_jawaban' => $request->kunci_jawaban
        ]);

        // Always return JSON response to prevent page reload
        return response()->json([
            'success' => true,
            'message' => 'Kunci jawaban berhasil diperbarui.',
            'kunci_jawaban' => $request->kunci_jawaban
        ]);
    }

    /**
     * Activate exam.
     */
    public function activate(Request $request, string $id)
    {
        $ujian = $this->addSekolahFilter(Ujian::query(), Ujian::class)->findOrFail($id);

        // Check if exam can be activated
        if ($ujian->status == 'Aktif') {
            return response()->json([
                'success' => false,
                'message' => 'Ujian sudah aktif.'
            ]);
        }

        // Update exam status to active
        $ujian->update(['status' => 'Aktif']);

        // Return JSON response
        return response()->json([
            'success' => true,
            'message' => 'Ujian berhasil diaktifkan.',
            'status' => 'Aktif'
        ]);
    }

    /**
     * Upload image for TinyMCE editor.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/gambar_soal'), $imageName);
            
            return response()->json([
                'location' => asset('storage/gambar_soal/' . $imageName)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    /**
     * Destroy soal.
     */
    public function destroySoal(string $id, string $soalId)
    {
        $soal = DetailUjian::findOrFail($soalId);
        
        // Delete associated image if exists
        if ($soal->gambar_soal && file_exists(public_path('storage/' . $soal->gambar_soal))) {
            unlink(public_path('storage/' . $soal->gambar_soal));
        }
        
        $soal->delete();

        return redirect()->route('admin.ujian.show', $id)
            ->with('success', 'Soal berhasil dihapus.');
    }

    /**
     * Upload soal document (Word/PDF)
     */
    public function uploadSoalDocument(Request $request, string $id)
    {
        $request->validate([
            'file_soal' => 'required|mimes:docx,pdf|max:10240'
        ]);

        $ujian = $this->addSekolahFilter(Ujian::query(), Ujian::class)->findOrFail($id);
        
        // Delete old file if exists
        if ($ujian->file_soal && file_exists(public_path('storage/soal_documents/' . $ujian->file_soal))) {
            unlink(public_path('storage/soal_documents/' . $ujian->file_soal));
        }

        $file = $request->file('file_soal');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        Log::info('Moving file: ' . $fileName . ' to storage/soal_documents');
        $file->move(public_path('storage/soal_documents'), $fileName);
        
        Log::info('File moved successfully. Updating ujian ID: ' . $ujian->id . ' with file: ' . $fileName);
        Log::info('Current ujian file_soal value: ' . ($ujian->file_soal ?? 'null'));

        try {
            // Get original data before update
            $originalFile = $ujian->file_soal;
            Log::info('Original file_soal: ' . $originalFile);
            
            // Update the record
            $result = $ujian->update([
                'file_soal' => $fileName
            ]);
            
            // Check if update was successful
            $updatedUjian = $ujian->fresh();
            Log::info('Update result: ' . ($result ? 'success' : 'failed'));
            Log::info('Expected file: ' . $fileName);
            Log::info('Actual file in DB: ' . $updatedUjian->file_soal);
            
            // Verify file exists in storage
            $filePath = public_path('storage/soal_documents/' . $fileName);
            Log::info('File exists in storage: ' . (file_exists($filePath) ? 'yes' : 'no'));
            Log::info('File path: ' . $filePath);

            if ($result && $updatedUjian->file_soal === $fileName) {
                return redirect()->route('admin.ujian.show', $ujian->id)
                    ->with('success', 'File soal berhasil diupload.');
            } else {
                return redirect()->route('admin.ujian.show', $ujian->id)
                    ->with('error', 'File berhasil diupload ke storage tapi gagal tersimpan di database.');
            }
        } catch (\Exception $e) {
            Log::error('Error uploading soal document: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->route('admin.ujian.show', $ujian->id)
                ->with('error', 'Gagal mengupload file soal: ' . $e->getMessage());
        }
    }

    /**
     * View soal document
     */
    public function viewSoalDocument(string $id)
    {
        $ujian = $this->addSekolahFilter(Ujian::query(), Ujian::class)->findOrFail($id);
        
        if (!$ujian->file_soal) {
            return redirect()->back()->with('error', 'File soal tidak ditemukan.');
        }

        $filePath = public_path('storage/soal_documents/' . $ujian->file_soal);
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File soal tidak ditemukan.');
        }

        $fileExtension = strtolower(pathinfo($ujian->file_soal, PATHINFO_EXTENSION));
        
        if ($fileExtension === 'pdf') {
            $headers = [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $ujian->file_soal . '"',
                'Content-Length' => filesize($filePath),
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ];
            return response()->file($filePath, $headers);
        } else {
            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'Content-Disposition' => 'inline; filename="' . $ujian->file_soal . '"',
                'Content-Length' => filesize($filePath),
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ];
            return response()->file($filePath, $headers);
        }
    }

    /**
     * Generate questions for ujian
     */
    public function generateQuestions(Request $request, $id)
    {
        $request->validate([
            'questionCount' => 'required|integer|min:1|max:100'
        ]);

        $ujian = Ujian::findOrFail($id);
        $questionCount = $request->questionCount;

        // DB::beginTransaction();

        // try {
            for ($i = 1; $i <= $questionCount; $i++) {
                DetailUjian::create([
                    'id_ujian' => $ujian->id,
                    'soal' => 'Soal Pilihan Ganda ' . $i,
                    'tipe_soal' => 'pilihan_ganda',
                    'bobot' => 1,
                    'tingkat_kesulitan' => 'mudah',
                    'kunci_jawaban' => 'A',
                    'opsi_a' => 'Pilihan A ' . $i,
                    'opsi_b' => 'Pilihan B ' . $i,
                    'opsi_c' => 'Pilihan C ' . $i,
                    'opsi_d' => 'Pilihan D ' . $i,
                    'opsi_e' => 'Pilihan E ' . $i
                ]);
            }

            DB::commit();

            return back()->with('success', "Berhasil generate {$questionCount} soal.");

        // } catch (\Exception $e) {
        //     DB::rollBack();

        //     return back()->with('error', 'Gagal generate soal');
        // }
    }

    /**
     * Delete all questions for ujian
     */
    public function deleteAllQuestions(Request $request, $id)
    {
        try {
            $ujian = $this->addSekolahFilter(Ujian::findOrFail($id), Ujian::class);
            
            // Get all questions for this ujian
            $questions = DetailUjian::where('id_ujian', $ujian->id)->get();
            $questionCount = $questions->count();
            
            if ($questionCount === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada soal untuk dihapus.'
                ], 400);
            }

            // Begin transaction for data integrity
            DB::beginTransaction();

            try {
                // Delete associated images first
                foreach ($questions as $question) {
                    if ($question->gambar_soal && file_exists(public_path('storage/' . $question->gambar_soal))) {
                        unlink(public_path('storage/' . $question->gambar_soal));
                    }
                }

                // Delete all questions
                $deletedCount = DetailUjian::where('id_ujian', $ujian->id)->delete();

                // Update ujian totals
                $ujian->update([
                    'jumlah_soal' => 0,
                    'total_bobot' => 0
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => "Berhasil menghapus {$deletedCount} soal dari ujian ini.",
                    'deleted' => $deletedCount
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'error' => $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    public function uploadGambarSoal(Request $request, $id)
    {
        $request->validate([
            'gambar_soal' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        try {
            $ujian = Ujian::findOrFail($id);

            if ($request->hasFile('gambar_soal')) {
                $file = $request->file('gambar_soal');
                $fileName = time() . '_' . $file->getClientOriginalName();
                
                // Store the file properly
                $path = $file->storeAs('soal_ujian', $fileName, 'public');
                
                // Create record in database
                UjianSoal::create([
                    'id_ujian' => $ujian->id,
                    'gambar_soal' => $fileName,
                ]);

                return redirect()->route('admin.ujian.show', $ujian->id)
                    ->with('success', 'Gambar soal berhasil diupload!');
            }

            return redirect()->back()
                ->with('error', 'Tidak ada file yang diupload.');

        } catch (\Exception $e) {
            Log::error('Error uploading gambar soal: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengupload gambar soal.');
        }
    }
}
