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

    protected function isExamTimeExpired($jawabanSiswa, $ujian)
    {
        if (!$jawabanSiswa || !$jawabanSiswa->waktu_mulai) {
            return false;
        }

        $waktuMulai = Carbon::parse($jawabanSiswa->waktu_mulai);

        $waktuHabis = $waktuMulai->copy()->addMinutes($ujian->durasi);

        return now()->greaterThanOrEqualTo($waktuHabis);
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
                    'nama_ujian' => $ujian->kode_ujian
                ]);

                $jawaban = JawabanSiswa::where('id_siswa', $siswa->kode_siswa)
                    ->where('id_ujian', $ujian->id)
                    ->first();

                if ($jawaban && $jawaban->status == 'in_progress') {

                    $elapsed = Carbon::parse($jawaban->waktu_mulai)
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

            $ujian = Ujian::with(['detailUjians' => function ($query) {
                $query->orderByRaw("FIELD(tipe_soal, 'pilihan_ganda', 'benar_salah', 'isian_singkat','essay')")
                    ->orderByRaw("FIELD(tingkat_kesulitan, 'mudah', 'sedang', 'sulit', 'tinggi')");
            }])->findOrFail($id);

            // =========================
            // GET CLASS INFO
            // =========================
            $kelas = \App\Models\Kelas::find($siswa->kode_kelas);

            $studentTingkat = $kelas?->tingkat;
            $studentJurusan = $kelas?->id_jurusan;
            $studentSekolah = $kelas?->id_sekolah;

            // =========================
            // VALIDATION
            // =========================
            if ($ujian->tingkat != $studentTingkat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak berhak mengakses ujian ini'
                ], 403);
            }

            if ($ujian->id_jurusan && !in_array($studentJurusan, (array) $ujian->id_jurusan)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak berhak mengakses ujian ini'
                ], 403);
            }

            if ($ujian->status != 'Aktif') {
                return response()->json([
                    'success' => false,
                    'message' => 'Ujian tidak aktif'
                ], 403);
            }

            // =========================
            // CHECK SUBMIT
            // =========================
            $hasSubmitted = JawabanSiswa::where('id_siswa', $siswa->kode_siswa)
                ->where('id_ujian', $ujian->id)
                ->where('status', 'submitted')
                ->exists();

            if ($hasSubmitted) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah menyelesaikan ujian ini'
                ], 400);
            }

            // =========================
            // SESSION
            // =========================
            $jawabanSiswa = JawabanSiswa::where('id_siswa', $siswa->kode_siswa)
                ->where('id_ujian', $ujian->id)
                ->where('status', 'in_progress')
                ->first();

            if (!$jawabanSiswa) {
                Log::info('Creating JawabanSiswa with sekolah_id: ' . $studentSekolah);
                $jawabanSiswa = JawabanSiswa::create([
                    'id_siswa' => $siswa->kode_siswa,
                    'id_ujian' => $ujian->id,
                    'id_sekolah' => $studentSekolah,
                    'waktu_mulai' => now(),
                    'status' => 'in_progress'
                ]);

                Log::info('JawabanSiswa created with id_sekolah: ' . $jawabanSiswa->id_sekolah);
            }

            // =========================
            // EXISTING ANSWERS
            // =========================
            $existingAnswers = DB::table('detail_jawaban_siswa')
                ->where('id_jawaban_siswa', $jawabanSiswa->id)
                ->pluck('jawaban', 'id_detail_ujian')
                ->toArray();

            // =========================
            // TIME CALCULATION
            // =========================
            $totalDuration = $ujian->durasi * 60;

            $elapsedTime = $jawabanSiswa->waktu_mulai
                ? \Carbon\Carbon::parse($jawabanSiswa->waktu_mulai)->diffInSeconds(now())
                : 0;

            $remainingTime = max(0, $totalDuration - $elapsedTime);
            if ($remainingTime <= 0) {

                $jawabanSiswa->update([
                    'status' => 'submitted',
                    'waktu_selesai' => now()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Waktu ujian sudah habis',
                    'data' => '1'
                ]);
            }
            // =========================
            // RESPONSE
            // =========================
            return response()->json([
                'success' => true,
                'message' => 'Ujian dimulai',
                'data' => [
                    'ujian' => $ujian,
                    'jawaban_siswa_id' => $jawabanSiswa->id,
                    'existing_answers' => $existingAnswers,
                    'remaining_time' => $remainingTime,
                    'total_duration' => $totalDuration,
                    'waktu_mulai' => $jawabanSiswa->waktu_mulai,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Start exam error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memulai ujian',
                'error' => $e->getMessage()
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

            if (!$jawabanSiswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sesi ujian tidak ditemukan'
                ], 404);
            }

            if ($this->isExamTimeExpired($jawabanSiswa, $ujian)) {

                $jawabanSiswa->update([
                    'status' => 'submitted',
                    'waktu_selesai' => now()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Waktu ujian habis, ujian otomatis disubmit'
                ]);
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
                
            if ($this->isExamTimeExpired($jawabanSiswa, $ujian)) {

                $jawabanSiswa->update([
                    'status' => 'submitted',
                    'waktu_selesai' => now()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Waktu ujian habis, ujian otomatis disubmit'
                ]);
            }
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
                        'kode_ujian' => $result->ujian->kode_ujian,
                        'nama_ujian' => $result->ujian->kode_ujian,
                        'mapel' => [
                            'nama_mapel' => $result->ujian->mapel->nama_mapel ?? null,
                        ],
                        'tahunPelajaran' => [
                            'nama_tahun' => $result->ujian->tahunPelajaran->nama_tahun ?? null,
                        ],
                        'tanggal_ujian' => $result->ujian->tanggal_ujian,
                        'durasi' => $result->ujian->durasi
                    ],
                    'nilai' => $result->nilai ?? 0,
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

    /**
     * Get detailed exam result for a specific exam
     */
    public function detailResult($resultId)
    {
        try {
            $siswa = Auth::user();

            $jawabanSiswa = JawabanSiswa::with(['ujian.mapel', 'ujian.tahunPelajaran'])
                ->where('id', $resultId)
                ->where('id_siswa', $siswa->kode_siswa)
                ->first();

            if (!$jawabanSiswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data hasil ujian tidak ditemukan'
                ], 404);
            }

            // Get exam questions with correct answers
            $soals = UjianSoal::where('id_ujian', $jawabanSiswa->id_ujian)
                ->with(['pilihanGanda'])
                ->get();

            // Get student's answers
            $jawabanDetail = DB::table('detail_jawaban_siswa')
                ->where('id_jawaban_siswa', $jawabanSiswa->id)
                ->get();

            // Format the response
            $formattedSoals = $soals->map(function($soal) use ($jawabanDetail) {
                $studentAnswer = $jawabanDetail->firstWhere('id_soal', $soal->id);
                $isCorrect = false;
                $studentAnswerText = null;

                if ($studentAnswer) {
                    $studentAnswerText = $studentAnswer->jawaban;
                    // Check if answer is correct
                    $correctAnswer = $soal->pilihanGanda->firstWhere('is_benar', true);
                    if ($correctAnswer && $studentAnswerText === $correctAnswer->id) {
                        $isCorrect = true;
                    }
                }

                return [
                    'id' => $soal->id,
                    'pertanyaan' => $soal->pertanyaan,
                    'tipe_soal' => $soal->tipe_soal,
                    'pilihan_ganda' => $soal->pilihanGanda->map(function($pilihan) {
                        return [
                            'id' => $pilihan->id,
                            'teks_pilihan' => $pilihan->teks_pilihan,
                            'is_benar' => $pilihan->is_benar
                        ];
                    }),
                    'jawaban_siswa' => $studentAnswerText,
                    'is_correct' => $isCorrect
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Data detail hasil ujian berhasil diambil',
                'data' => [
                    'ujian' => [
                        'id' => $jawabanSiswa->ujian->id,
                        'kode_ujian' => $jawabanSiswa->ujian->kode_ujian,
                        'nama_ujian' => $jawabanSiswa->ujian->kode_ujian,
                        'mapel' => [
                            'nama_mapel' => $jawabanSiswa->ujian->mapel->nama_mapel ?? null,
                        ],
                        'tanggal_ujian' => $jawabanSiswa->ujian->tanggal_ujian,
                        'durasi' => $jawabanSiswa->ujian->durasi
                    ],
                    'nilai' => $jawabanSiswa->nilai ?? 0,
                    'waktu_mulai' => $jawabanSiswa->waktu_mulai,
                    'waktu_selesai' => $jawabanSiswa->waktu_selesai,
                    'soals' => $formattedSoals,
                    'total_soal' => $formattedSoals->count(),
                    'benar' => $formattedSoals->where('is_correct', true)->count(),
                    'salah' => $formattedSoals->where('is_correct', false)->count()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in SiswaUjianController@detailResult: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data detail hasil ujian',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get student information for home/profile screen
     */
    public function infoSiswa()
    {
        try {
            $siswa = Auth::user();
            
            // Get student's class information
            $kelas = Kelas::find($siswa->kode_kelas);
            
            // Get exam statistics
            $totalExams = JawabanSiswa::where('id_siswa', $siswa->kode_siswa)
                ->where('status', 'submitted')
                ->count();
            
            // Get upcoming exams
            $upcomingExams = Ujian::with(['mapel'])
                ->where('tingkat', $kelas?->tingkat)
                ->where('status', 'Aktif')
                ->where('tanggal_ujian', '>=', now()->format('Y-m-d'))
                ->orderBy('tanggal_ujian', 'asc')
                ->count();
            
            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil diambil',
                'data' => [
                    'siswa' => [
                        'kode_siswa' => $siswa->kode_siswa,
                        'nama_siswa' => $siswa->nama_siswa,
                        'nis' => $siswa->nis ?? null,
                        'email' => $siswa->email ?? null,
                        'no_hp' => $siswa->no_hp ?? null,
                        'jenis_kelamin' => $siswa->jenis_kelamin ?? null,
                        'tempat_lahir' => $siswa->tempat_lahir ?? null,
                        'tanggal_lahir' => $siswa->tanggal_lahir ?? null,
                        'alamat' => $siswa->alamat ?? null,
                        'foto' => $siswa->foto ?? null,
                    ],
                    'kelas' => [
                        'kode_kelas' => $kelas?->kode_kelas,
                        'nama_kelas' => $kelas?->nama_kelas,
                        'tingkat' => $kelas?->tingkat,
                        'jurusan_id' => $kelas?->jurusan_id,
                        'wali_kelas' => $kelas?->wali_kelas ?? null,
                    ],
                    'statistik' => [
                        'total_ujian_selesai' => $totalExams,
                        'ujian_sedang_berlangsung' => $upcomingExams,
                    ]
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in SiswaUjianController@infoSiswa: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data siswa',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
