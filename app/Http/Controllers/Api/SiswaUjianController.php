<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ujian;
use App\Models\DetailUjian;
use App\Models\UjianSoal;
use App\Models\JawabanSiswa;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SiswaUjianController extends Controller
{
    /**
     * Get the current user's sekolah ID
     *
     * @return int|null
     */
    protected function getCurrentSekolahId()
    {
        if (Auth::guard('admin')->check()) {
            return Auth::guard('admin')->user()->id_sekolah ?? '1';
        } elseif (Auth::guard('guru')->check()) {
            return Auth::guard('guru')->user()->id_sekolah;
        } elseif (Auth::guard('siswa')->check()) {
            return Auth::guard('siswa')->user()->id_sekolah;
        }
        
        return null;
    }

    /**
     * Display list of available exams for the student.
     */
    public function index()
    {
        try {
            $siswa = Auth::user();
            // Get student's class information
            $kelas = Kelas::find($siswa->kode_kelas);
            $studentTingkat = $kelas ? $kelas->tingkat : null;
            $studentJurusan = $kelas ? $kelas->jurusan_id : null;
            
            // Check if student has already completed any exam
            $hasCompletedExam = JawabanSiswa::where('id_siswa', $siswa->kode_siswa)
                ->where('status', 'submitted')
                ->exists();
            
            $query = Ujian::with(['mapel', 'tahunPelajaran'])
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
                
                // Add nama_ujian field for mobile app
                $ujian->nama_ujian = $ujian->kode_ujian;
                
                // Format dates for mobile
                $ujian->tanggal_ujian_formatted = \Carbon\Carbon::parse($ujian->tanggal_ujian)->format('d F Y');
                $ujian->jam_mulai_formatted = \Carbon\Carbon::parse($ujian->jam_mulai)->format('H:i');
                $ujian->jam_selesai_formatted = \Carbon\Carbon::parse($ujian->jam_selesai)->format('H:i');
                
                // Debug logging
                Log::info('Ujian data for mobile:', [
                    'id' => $ujian->id,
                    'kode_ujian' => $ujian->kode_ujian,
                    'nama_ujian' => $ujian->nama_ujian
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Data ujian berhasil diambil',
                'data' => [
                    'ujians' => $ujians,
                    'has_completed_exam' => $hasCompletedExam,
                    'student_info' => [
                        'nama' => $siswa->nama_siswa,
                        'kelas' => $kelas ? $kelas->nama_kelas : null,
                        'tingkat' => $studentTingkat
                    ]
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in SiswaUjianController@index: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data ujian',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show exam details.
     */
    public function show($id)
    {
        try {
            $siswa = Auth::user();
            $ujian = Ujian::with(['mapel', 'tahunPelajaran'])->findOrFail($id);
            
            // Get student's class information
            $kelas = Kelas::find($siswa->kode_kelas);
            $studentTingkat = $kelas ? $kelas->tingkat : null;
            $studentJurusan = $kelas ? $kelas->jurusan_id : null;
            
            // Check if student can take this exam based on tingkat and jurusan
            if ($ujian->tingkat != $studentTingkat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak berhak mengakses ujian ini'
                ], 403);
            }
            
            // Check jurusan access
            if ($ujian->id_jurusan && !in_array($studentJurusan, $ujian->id_jurusan)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak berhak mengakses ujian ini'
                ], 403);
            }
            
            // Check if student has already submitted
            $hasSubmitted = JawabanSiswa::where('id_siswa', $siswa->kode_siswa)
                ->where('id_ujian', $ujian->id)
                ->where('status', 'submitted')
                ->exists();
            
            // Format for mobile
            $ujian->tanggal_ujian_formatted = \Carbon\Carbon::parse($ujian->tanggal_ujian)->format('d F Y');
            $ujian->jam_mulai_formatted = \Carbon\Carbon::parse($ujian->jam_mulai)->format('H:i');
            $ujian->jam_selesai_formatted = \Carbon\Carbon::parse($ujian->jam_selesai)->format('H:i');
            
            return response()->json([
                'success' => true,
                'message' => 'Detail ujian berhasil diambil',
                'data' => [
                    'ujian' => $ujian,
                    'has_submitted' => $hasSubmitted,
                    'student_info' => [
                        'nama' => $siswa->nama_siswa,
                        'kelas' => $kelas ? $kelas->nama_kelas : null
                    ]
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in SiswaUjianController@show: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail ujian',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Start the exam.
     */
    public function start($id)
    {
        try {
            $siswa = Auth::user();

            if (!$siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            Log::info('Starting exam ID: ' . $id);

            $ujian = Ujian::with([
                'detailUjians' => function ($query) {
                    $query->orderByRaw("FIELD(tipe_soal, 'pilihan_ganda', 'benar_salah', 'isian_singkat','essay')")
                        ->orderByRaw("FIELD(tingkat_kesulitan, 'mudah', 'sedang', 'sulit', 'tinggi')");
                }
            ])->find($id);

            if (!$ujian) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ujian tidak ditemukan'
                ], 404);
            }

            // ==============================
            // FIX UTAMA TIME HANDLING
            // ==============================

            $now = Carbon::now('Asia/Jakarta');


            // ==============================
            // CEK / CREATE SESSION
            // ==============================

            $jawabanSiswa = JawabanSiswa::where('id_siswa', $siswa->kode_siswa)
                ->where('id_ujian', $ujian->id)
                ->where('status', 'in_progress')
                ->first();

            if (!$jawabanSiswa) {
                $jawabanSiswa = JawabanSiswa::create([
                    'id_siswa' => $siswa->kode_siswa,
                    'id_ujian' => $ujian->id,
                    'waktu_mulai' => $now,
                    'status' => 'in_progress',
                    'id_sekolah' => $this->getCurrentSekolahId()
                ]);
            }

            // AMAN: pakai formatted kalau jam_mulai NULL
            $jamMulai = $ujian->jam_mulai
                ?? $ujian->jam_mulai_formatted
                ?? null;

            if (!$jamMulai) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jam mulai ujian belum diatur'
                ], 400);
            }

            $startTime = Carbon::parse($ujian->tanggal_ujian . ' ' . $jamMulai, 'Asia/Jakarta');

            $endTime = $startTime->copy()->addMinutes($ujian->durasi);

            // ==============================
            // VALIDASI WAKTU
            // ==============================

            if ($now->lt($startTime)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ujian belum dimulai'
                ], 403);
            }

            if ($now->gte($endTime)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Waktu ujian sudah habis',
                    'data' => '1'
                ], 403);
            }

            // ==============================
            // GET EXISTING ANSWERS
            // ==============================

            $existingAnswers = DB::table('detail_jawaban_siswa')
                ->where('id_jawaban_siswa', $jawabanSiswa->id)
                ->pluck('jawaban', 'id_detail_ujian')
                ->toArray();

            // ==============================
            // REMAINING TIME
            // ==============================

            $remainingTime = $endTime->diffInSeconds($now);

            return response()->json([
                'success' => true,
                'message' => 'Ujian dimulai',
                'data' => [
                    'ujian' => $ujian,
                    'jawaban_siswa_id' => $jawabanSiswa->id,
                    'existing_answers' => $existingAnswers,
                    'remaining_time' => max(0, $remainingTime),
                    'total_duration' => $ujian->durasi * 60,
                    'waktu_mulai' => $startTime->toISOString(),
                    'waktu_selesai' => $endTime->toISOString(),
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Start exam error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memulai ujian',
                'debug' => $e->getMessage() // sementara debug
            ], 500);
        }
    }

    /**
     * Save answer for a question.
     */
    public function saveAnswer(Request $request, $id)
    {
        try {
            $siswa = Auth::user();
            $ujian = Ujian::findOrFail($id);
            
            // Validate request
            $request->validate([
                'id_soal' => 'required|exists:detail_ujians,id',
                'jawaban' => 'required|string'
            ]);
            
            // Get student's class information
            $kelas = Kelas::find($siswa->kode_kelas);
            $studentTingkat = $kelas ? $kelas->tingkat : null;
            $studentJurusan = $kelas ? $kelas->jurusan_id : null;
            
            // Check if student can take this exam based on tingkat and jurusan
            if ($ujian->tingkat != $studentTingkat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
            
            // Check jurusan access
            if ($ujian->id_jurusan && !in_array($studentJurusan, $ujian->id_jurusan)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
            
            // Get or create answer session
            $jawabanSiswa = JawabanSiswa::firstOrCreate([
                'id_siswa' => $siswa->kode_siswa,
                'id_ujian' => $ujian->id,
                'status' => 'in_progress'
            ], [
                'waktu_mulai' => now()
            ]);
            
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
            
            return response()->json([
                'success' => true,
                'message' => 'Jawaban disimpan'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in SiswaUjianController@saveAnswer: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan jawaban',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Submit the exam.
     */
    public function submit(Request $request, $id)
    {
        try {
            $siswa = Auth::user();
            $ujian = Ujian::findOrFail($id);
            
            // Get student's class information
            $kelas = Kelas::find($siswa->kode_kelas);
            $studentTingkat = $kelas ? $kelas->tingkat : null;
            $studentJurusan = $kelas ? $kelas->jurusan_id : null;
            
            // Check if student can take this exam based on tingkat and jurusan
            if ($ujian->tingkat != $studentTingkat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak berhak mengakses ujian ini'
                ], 403);
            }
            
            // Check jurusan access
            if ($ujian->id_jurusan && !in_array($studentJurusan, $ujian->id_jurusan)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak berhak mengakses ujian ini'
                ], 403);
            }
            
            // Get answer session
            $jawabanSiswa = JawabanSiswa::where('id_siswa', $siswa->kode_siswa)
                ->where('id_ujian', $ujian->id)
                ->where('status', 'in_progress')
                ->first();
                
            if (!$jawabanSiswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sesi ujian tidak ditemukan'
                ], 404);
            }
            
            // Check if already submitted
            if ($jawabanSiswa->status == 'submitted') {
                return response()->json([
                    'success' => false,
                    'message' => 'Ujian sudah disubmit'
                ], 400);
            }
            
            // Update submission time and status
            $jawabanSiswa->update([
                'waktu_selesai' => now(),
                'status' => 'submitted'
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Ujian berhasil disubmit!',
                'data' => [
                    'submission_time' => $jawabanSiswa->waktu_selesai->toISOString(),
                    'exam_id' => $ujian->id,
                    'student_id' => $siswa->kode_siswa
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in SiswaUjianController@submit: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal submit ujian',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get exam results for student
     */
    public function results()
    {
        try {
            $siswa = Auth::user();
            
            $results = JawabanSiswa::with(['ujian.mapel', 'ujian.tahunPelajaran'])
                ->where('id_siswa', $siswa->kode_siswa)
                ->where('status', 'submitted')
                ->orderBy('created_at', 'desc')
                ->get();
            
            $formattedResults = $results->map(function($result) {
                return [
                    'id' => $result->id,
                    'ujian' => [
                        'id' => $result->ujian->id,
                        'nama_ujian' => $result->ujian->nama_ujian,
                        'mapel' => $result->ujian->mapel->nama_mapel ?? null,
                        'tahun_pelajaran' => $result->ujian->tahunPelajaran->nama_tahun ?? null,
                        'tanggal_ujian' => $result->ujian->tanggal_ujian,
                        'durasi' => $result->ujian->durasi
                    ],
                    'waktu_mulai' => $result->waktu_mulai,
                    'waktu_selesai' => $result->waktu_selesai,
                    'status' => $result->status,
                    'submission_time' => $result->waktu_selesai ? $result->waktu_selesai->format('d F Y H:i') : null
                ];
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Data hasil ujian berhasil diambil',
                'data' => [
                    'results' => $formattedResults,
                    'total_exams' => $formattedResults->count()
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in SiswaUjianController@results: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data hasil ujian',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
