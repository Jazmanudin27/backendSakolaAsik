<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\DetailUjian;
use App\Models\JawabanSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SiswaUjianController extends SekolahAwareController
{
   protected function isExamTimeExpired($jawabanSiswa, $ujian)
    {
        if (!$jawabanSiswa || !$jawabanSiswa->waktu_mulai) {
            return false;
        }
        $waktuMulai = \Carbon\Carbon::parse($jawabanSiswa->waktu_mulai);
        $waktuHabis = $waktuMulai->copy()->addMinutes($ujian->durasi);
        return now()->greaterThanOrEqualTo($waktuHabis);
    }


    public function index()
    {
        $siswa = Auth::guard('siswa')->user();
        
        // Get student's class information
        $kelas = \App\Models\Kelas::find($siswa->kode_kelas);
        $studentTingkat = $kelas ? $kelas->tingkat : null;
        $studentJurusan = $kelas ? $kelas->jurusan_id : null;
        // Check if student has already completed any exam
        $hasCompletedExam = JawabanSiswa::where('id_siswa', $siswa->kode_siswa)
            ->where('status', 'submitted')
            ->exists();
        
        $query = $this->addSekolahFilter(Ujian::with(['mapel', 'tahunPelajaran']), Ujian::class)
            ->where('tingkat', $studentTingkat)
            ->where(function($query) use ($studentJurusan) {
                    $query->where('id_jurusan', 'like', '%"' . $studentJurusan . '"%')
                          ->orWhereNull('id_jurusan');
                })
            ->where('status', 'Aktif')
            ->where('tanggal_ujian', '>=', now()->format('Y-m-d'))
            ->orderBy('tanggal_ujian', 'asc');
        
        $ujians = $query->get();
        foreach ($ujians as $ujian) {
            $ujian->has_completed = $ujian->jawabanSiswas->contains(function($jawaban) use ($siswa) {
                return $jawaban->id_siswa == $siswa->kode_siswa && $jawaban->status == 'submitted';
            });

            $jawaban = JawabanSiswa::where('id_siswa', $siswa->kode_siswa)
                ->where('id_ujian', $ujian->id)
                ->first();

            if ($jawaban && $jawaban->status == 'in_progress') {

                $elapsed = \Carbon\Carbon::parse($jawaban->waktu_mulai)
                    ->diffInSeconds(now());

                $remaining = ($ujian->durasi * 60) - $elapsed;

                if ($remaining <= 0) {

                    $jawaban->update([
                        'status' => 'submitted',
                        'waktu_selesai' => now()
                    ]);
                }
            }
        }
        
        return view('siswa.ujian.index', compact('ujians', 'siswa', 'hasCompletedExam'));
    }

    /**
     * Show exam details.
     */
    public function show($id)
    {
        $siswa = Auth::guard('siswa')->user();
        $ujian = $this->addSekolahFilter(Ujian::with(['mapel', 'tahunPelajaran']), Ujian::class)->findOrFail($id);
        
        // Get student's class information
        $kelas = \App\Models\Kelas::find($siswa->kode_kelas);
        $studentTingkat = $kelas ? $kelas->tingkat : null;
        $studentJurusan = $kelas ? $kelas->id_jurusan : null;
        
        // Check if student can take this exam based on tingkat and jurusan
        if ($ujian->tingkat != $studentTingkat) {
            abort(403, 'Anda tidak berhak mengakses ujian ini');
        }
        // Check if student has already submitted
        $hasSubmitted = JawabanSiswa::where('id_siswa', $siswa->kode_siswa)
            ->where('id_ujian', $ujian->id)
            ->where('status', 'submitted')
            ->exists();
            
        return view('siswa.ujian.show', compact('ujian', 'siswa', 'hasSubmitted'));
    }

    /**
     * Start the exam.
     */
    public function start($id)
    {
        $siswa = Auth::guard('siswa')->user();
        $ujian = $this->addSekolahFilter(Ujian::with(['detailUjians' => function($query) {
            return $query->orderByRaw("FIELD(tipe_soal, 'pilihan_ganda', 'benar_salah', 'isian_singkat','essay')")
                      ->orderByRaw("FIELD(tingkat_kesulitan, 'mudah', 'sedang', 'sulit', 'tinggi')");
        }]), Ujian::class)->findOrFail($id);
        
        // Get student's class information
        $kelas = \App\Models\Kelas::find($siswa->kode_kelas);
        $studentTingkat = $kelas ? $kelas->tingkat : null;
        $studentJurusan = $kelas ? $kelas->id_jurusan : null;
        
        // Check if student can take this exam based on tingkat and jurusan
        if ($ujian->tingkat != $studentTingkat) {
            abort(403, 'Anda tidak berhak mengakses ujian ini');
        }
        
        // Check if exam is still active
        if ($ujian->status != 'Aktif') {
            abort(403, 'Ujian tidak aktif');
        }
        
        // Check if student has already submitted
        $hasSubmitted = JawabanSiswa::where('id_siswa', $siswa->kode_siswa)
            ->where('id_ujian', $ujian->id)
            ->where('status', 'submitted')
            ->exists();
            
        if ($hasSubmitted) {
            return redirect()->route('siswa.ujian.show', $id)
                ->with('error', 'Anda sudah menyelesaikan ujian ini');
        }
        
        // Get existing answers or create new session
        $jawabanSiswa = JawabanSiswa::where('id_siswa', $siswa->kode_siswa)
            ->where('id_ujian', $ujian->id)
            ->where('status', 'in_progress')
            ->first();
            
        if (!$jawabanSiswa) {
            // Create new answer session
            $jawabanSiswa = JawabanSiswa::create([
                'id_siswa' => $siswa->kode_siswa,
                'id_ujian' => $ujian->id,
                'id_sekolah' => $this->getCurrentSekolahId(),
                'waktu_mulai' => now(),
                'status' => 'in_progress'
            ]);
        }
        
        // Load existing answers
        $existingAnswers = DB::table('detail_jawaban_siswa')
            ->where('id_jawaban_siswa', $jawabanSiswa->id)
            ->pluck('jawaban', 'id_detail_ujian')
            ->toArray();
        
        // Calculate remaining time
        $totalDuration = $ujian->durasi * 60; // Convert to seconds
        $elapsedTime = $jawabanSiswa->waktu_mulai->diffInSeconds(now());
        $remainingTime = max(0, round($totalDuration - $elapsedTime));
        if ($remainingTime <= 0) {

            $jawabanSiswa->update([
                'status' => 'submitted',
                'waktu_selesai' => now()
            ]);

            return redirect()->route('siswa.ujian.index')
                ->with('error', 'Waktu ujian sudah habis');
        }
        return view('siswa.ujian.start', compact('ujian', 'siswa', 'jawabanSiswa', 'existingAnswers', 'remainingTime'));
    }

    /**
     * Save answer for a question.
     */
    public function saveAnswer(Request $request, $id)
    {
        $siswa = Auth::guard('siswa')->user();
        $ujian = $this->addSekolahFilter(Ujian::with([]), Ujian::class)->findOrFail($id);
        
        // Validate request
        $request->validate([
            'id_soal' => 'required|exists:detail_ujians,id',
            'jawaban' => 'required|string'
        ]);
        
        // Get student's class information
        $kelas = \App\Models\Kelas::find($siswa->kode_kelas);
   
        // Get or create answer session
        $jawabanSiswa = JawabanSiswa::where('id_siswa', $siswa->kode_siswa)
            ->where('id_ujian', $ujian->id)
            ->where('status', 'in_progress')
            ->first();

        if (!$jawabanSiswa) {
            return response()->json([
                'error' => 'Sesi ujian tidak ditemukan'
            ], 404);
        }

        if ($this->isExamTimeExpired($jawabanSiswa, $ujian)) {

            $jawabanSiswa->update([
                'status' => 'submitted',
                'waktu_selesai' => now()
            ]);

            return response()->json([
                'error' => 'Waktu ujian sudah habis'
            ], 403);
        }
        
        // Save the answer
        DB::table('detail_jawaban_siswa')->updateOrInsert(
            [
                'id_jawaban_siswa' => $jawabanSiswa->id,
                'id_detail_ujian' => $request->id_soal
            ],
            [
                'jawaban' => $request->jawaban,
                'updated_at' => now()
            ]
        );
        
        return response()->json(['success' => true, 'message' => 'Jawaban disimpan']);
    }

    /**
     * Submit the exam.
     */
    public function submit(Request $request, $id)
    {
        $siswa = Auth::guard('siswa')->user();
        $ujian = $this->addSekolahFilter(Ujian::with(['mapel', 'tahunPelajaran']), Ujian::class)->findOrFail($id);
        
        // Get student's class information
        $kelas = \App\Models\Kelas::find($siswa->kode_kelas);
        // Get answer session
        $jawabanSiswa = JawabanSiswa::where('id_siswa', $siswa->kode_siswa)
            ->where('id_ujian', $ujian->id)
            ->where('status', 'in_progress')
            ->firstOrFail();
     
        if ($this->isExamTimeExpired($jawabanSiswa, $ujian)) {

            $jawabanSiswa->update([
                'status' => 'submitted',
                'waktu_selesai' => now()
            ]);

            return redirect()->route('siswa.ujian.index')
                ->with('success', 'Waktu ujian habis, ujian otomatis disubmit');
        }
        // Save all current answers to detail_jawaban_siswa table
        $currentAnswers = DB::table('detail_jawaban_siswa')
            ->where('id_jawaban_siswa', $jawabanSiswa->id)
            ->get();
            
        if ($currentAnswers->isEmpty()) {
            // Get answers from session/form data
            $answers = $request->except(['_token', '_method']);
            
            foreach ($answers as $key => $value) {
                if (str_starts_with($key, 'jawaban_')) {
                    $idDetailUjian = str_replace('jawaban_', '', $key);
                    if (!empty($value)) {
                        DB::table('detail_jawaban_siswa')->insert([
                            'id_jawaban_siswa' => $jawabanSiswa->id,
                            'id_detail_ujian' => $idDetailUjian,
                            'jawaban' => $value,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }
        }
        
        // Update submission time and status
        $jawabanSiswa->update([
            'waktu_selesai' => now(),
            'status' => 'submitted'
        ]);
        return redirect()->route('siswa.ujian.index')
            ->with('success', 'Ujian berhasil disubmit!');
    }

}
