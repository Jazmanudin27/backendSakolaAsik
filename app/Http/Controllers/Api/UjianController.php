<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ujian;
use App\Models\DetailUjian;
use App\Models\UjianSoal;
use App\Models\JawabanSiswa;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UjianController extends Controller
{
    /**
     * Get list of available exams for the authenticated student
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user || !$user->siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak valid atau bukan siswa'
                ], 401);
            }

            $siswa = $user->siswa;
            
            // Get student's class info
            $kelas = Kelas::find($siswa->id_kelas);
            if (!$kelas) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kelas siswa tidak ditemukan'
                ], 404);
            }

            // Get available exams for student's level and class
            $ujians = Ujian::with(['mapel', 'tahunPelajaran'])
                ->where('tingkat', $kelas->tingkat)
                ->where('status', 'Aktif')
                ->where(function($query) use ($kelas) {
                    $query->whereNull('id_kelas')
                          ->orWhere('id_kelas', $kelas->id_kelas);
                })
                ->where('tanggal_ujian', '>=', Carbon::now()->format('Y-m-d'))
                ->orderBy('tanggal_ujian', 'asc')
                ->get();

            // Check if student has completed each exam
            $ujiansWithStatus = $ujians->map(function ($ujian) use ($siswa) {
                $hasCompleted = JawabanSiswa::where('id_ujian', $ujian->id)
                    ->where('id_siswa', $siswa->id_siswa)
                    ->where('status', 'submitted')
                    ->exists();

                $hasStarted = JawabanSiswa::where('id_ujian', $ujian->id)
                    ->where('id_siswa', $siswa->id_siswa)
                    ->exists();

                return [
                    'id' => $ujian->id,
                    'kode_ujian' => $ujian->kode_ujian,
                    'nama_ujian' => $ujian->nama_ujian ?? $ujian->jenis_ujian,
                    'jenis_ujian' => $ujian->jenis_ujian,
                    'mapel' => $ujian->mapel->nama_mapel,
                    'tanggal_ujian' => $ujian->tanggal_ujian,
                    'durasi' => $ujian->durasi,
                    'status' => $ujian->status,
                    'keterangan' => $ujian->keterangan,
                    'has_completed' => $hasCompleted,
                    'has_started' => $hasStarted,
                    'can_start' => !$hasCompleted && Carbon::now()->format('Y-m-d') === $ujian->tanggal_ujian,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Data ujian berhasil diambil',
                'data' => [
                    'ujians' => $ujiansWithStatus,
                    'student_info' => [
                        'nama' => $siswa->nama,
                        'nis' => $siswa->nis,
                        'kelas' => $kelas->nama_kelas,
                        'tingkat' => $kelas->tingkat,
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in API ujian index: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data ujian'
            ], 500);
        }
    }

    /**
     * Start an exam for the student
     */
    public function start(Request $request, $ujianId)
    {
        try {
            $user = Auth::user();
            
            if (!$user || !$user->siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak valid atau bukan siswa'
                ], 401);
            }

            $siswa = $user->siswa;
            
            // Validate exam exists and is active
            $ujian = Ujian::with(['mapel', 'detailUjians' => function($query) {
                return $query->orderBy('nomor_soal');
            }])->find($ujianId);

            if (!$ujian) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ujian tidak ditemukan'
                ], 404);
            }

            if ($ujian->status !== 'Aktif') {
                return response()->json([
                    'success' => false,
                    'message' => 'Ujian tidak aktif'
                ], 400);
            }

            // Check if exam is available today
            if (Carbon::now()->format('Y-m-d') !== $ujian->tanggal_ujian) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ujian hanya dapat diakses pada tanggal ' . $ujian->tanggal_ujian
                ], 400);
            }

            // Check if student has already completed
            $existingAnswer = JawabanSiswa::where('id_ujian', $ujian->id)
                ->where('id_siswa', $siswa->id_siswa)
                ->first();

            if ($existingAnswer && $existingAnswer->status === 'submitted') {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah menyelesaikan ujian ini'
                ], 400);
            }

            // Calculate remaining time based on scheduled exam start time
            $scheduledStartTime = Carbon::parse($ujian->tanggal_ujian . ' ' . $ujian->jam_mulai);
            $scheduledEndTime   = $scheduledStartTime->copy()->addMinutes($ujian->durasi);
            $currentTime        = Carbon::now();

            // 1. Belum mulai
            if ($currentTime->lt($scheduledStartTime)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ujian belum dimulai'
                ], 400);
            }

            // 2. Sudah habis (INI PALING PENTING)
            if ($currentTime->gte($scheduledEndTime)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Waktu ujian sudah habis'
                ], 400);
            }

            // 3. Remaining time (BENAR)
            $remainingTime = $scheduledEndTime->diffInSeconds($currentTime);

            if ($remainingTime <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Waktu ujian sudah habis'
                ], 400);
            }

            // Create or update answer record
            if (!$existingAnswer) {
                $jawabanSiswa = JawabanSiswa::create([
                    'id_ujian' => $ujian->id,
                    'id_siswa' => $siswa->id_siswa,
                    'start_time' => $currentTime,
                    'end_time' => $scheduledEndTime,
                    'status' => 'in_progress',
                    'jawaban' => json_encode([]),
                ]);
            } else {
                // Only update end_time if it's not already set or if current end_time is after scheduled end time
                $currentEndTime = $existingAnswer->end_time;
               if (is_null($existingAnswer->end_time)) {
                    $existingAnswer->update([
                        'end_time' => $scheduledEndTime,
                        'status' => 'in_progress',
                    ]);
                }
                $jawabanSiswa = $existingAnswer;
            }

            // Prepare exam data
            $examData = [
                'ujian' => [
                    'id' => $ujian->id,
                    'kode_ujian' => $ujian->kode_ujian,
                    'nama_ujian' => $ujian->nama_ujian ?? $ujian->jenis_ujian,
                    'jenis_ujian' => $ujian->jenis_ujian,
                    'mapel' => $ujian->mapel->nama_mapel,
                    'durasi' => $ujian->durasi,
                    'tanggal_ujian' => $ujian->tanggal_ujian,
                    'keterangan' => $ujian->keterangan,
                ],
                'detail_ujians' => $ujian->detailUjians->map(function ($detail) {
                    return [
                        'id' => $detail->id,
                        'nomor_soal' => $detail->nomor_soal,
                        'tipe_soal' => $detail->tipe_soal,
                        'pertanyaan' => $detail->pertanyaan,
                        'opsi_jawaban' => $detail->opsi_jawaban ? json_decode($detail->opsi_jawaban) : null,
                        'kunci_jawaban' => $detail->kunci_jawaban,
                        'tingkat_kesulitan' => $detail->tingkat_kesulitan,
                        'gambar_soal' => $detail->gambar_soal ? url('storage/gambar_soal/' . $detail->gambar_soal) : null,
                    ];
                }),
                'remaining_time' => $remainingTime,
                'existing_answers' => json_decode($jawabanSiswa->jawaban ?? '{}', true),
            ];

            
            return response()->json([
                'success' => true,
                'message' => 'Ujian berhasil dimulai',
                'data' => $examData
            ]);

        } catch (\Exception $e) {
            Log::error('Error in API ujian start: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memulai ujian'
            ], 500);
        }
    }

    /**
     * Save exam answers
     */
    public function saveAnswer(Request $request, $ujianId)
    {
        try {
            $user = Auth::user();
            
            if (!$user || !$user->siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak valid atau bukan siswa'
                ], 401);
            }

            $siswa = $user->siswa;

            $validator = Validator::make($request->all(), [
                'answers' => 'required|array',
                'answers.*.id_detail_ujian' => 'required|exists:detail_ujians,id',
                'answers.*.jawaban' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data jawaban tidak valid',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Find existing answer record
            $jawabanSiswa = JawabanSiswa::where('id_ujian', $ujianId)
                ->where('id_siswa', $siswa->id_siswa)
                ->first();

            if (!$jawabanSiswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum memulai ujian ini'
                ], 400);
            }

            if ($jawabanSiswa->status === 'submitted') {
                return response()->json([
                    'success' => false,
                    'message' => 'Ujian sudah disubmit'
                ], 400);
            }

            // Check if time is still valid
            if (Carbon::now()->greaterThan($jawabanSiswa->end_time)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Waktu ujian sudah habis'
                ], 400);
            }

            // Save answers
            $answers = [];
            foreach ($request->answers as $answer) {
                $answers[$answer['id_detail_ujian']] = $answer['jawaban'];
            }

            $jawabanSiswa->update([
                'jawaban' => json_encode($answers),
                'last_save_time' => Carbon::now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Jawaban berhasil disimpan'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in API save answer: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan jawaban'
            ], 500);
        }
    }

    /**
     * Submit exam
     */
    public function submit(Request $request, $ujianId)
    {
        try {
            $user = Auth::user();
            
            if (!$user || !$user->siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak valid atau bukan siswa'
                ], 401);
            }

            $siswa = $user->siswa;

            // Find existing answer record
            $jawabanSiswa = JawabanSiswa::where('id_ujian', $ujianId)
                ->where('id_siswa', $siswa->id_siswa)
                ->first();

            if (!$jawabanSiswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum memulai ujian ini'
                ], 400);
            }

            if ($jawabanSiswa->status === 'submitted') {
                return response()->json([
                    'success' => false,
                    'message' => 'Ujian sudah disubmit'
                ], 400);
            }

            // Save final answers if provided
            if ($request->has('answers')) {
                $answers = [];
                foreach ($request->answers as $answer) {
                    $answers[$answer['id_detail_ujian']] = $answer['jawaban'];
                }

                $jawabanSiswa->update([
                    'jawaban' => json_encode($answers),
                ]);
            }

            // Submit exam
            $jawabanSiswa->update([
                'status' => 'submitted',
                'submit_time' => Carbon::now(),
            ]);

            // Calculate score (optional)
            $score = $this->calculateScore($jawabanSiswa);

            return response()->json([
                'success' => true,
                'message' => 'Ujian berhasil disubmit',
                'data' => [
                    'submit_time' => $jawabanSiswa->submit_time,
                    'score' => $score,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in API submit exam: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat submit ujian'
            ], 500);
        }
    }

    /**
     * Calculate exam score
     */
    private function calculateScore($jawabanSiswa)
    {
        try {
            $answers = json_decode($jawabanSiswa->jawaban, true);
            $ujian = Ujian::with('detailUjians')->find($jawabanSiswa->id_ujian);
            
            if (!$ujian || !$answers) {
                return 0;
            }

            $correctAnswers = 0;
            $totalQuestions = $ujian->detailUjians->count();

            foreach ($ujian->detailUjians as $detail) {
                if (isset($answers[$detail->id]) && $answers[$detail->id] === $detail->kunci_jawaban) {
                    $correctAnswers++;
                }
            }

            $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;

            // Update score in database
            $jawabanSiswa->update(['score' => $score]);

            return $score;

        } catch (\Exception $e) {
            Log::error('Error calculating score: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get exam results for student
     */
    public function results(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user || !$user->siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak valid atau bukan siswa'
                ], 401);
            }

            $siswa = $user->siswa;

            $results = JawabanSiswa::with(['ujian.mapel'])
                ->where('id_siswa', $siswa->id_siswa)
                ->where('status', 'submitted')
                ->orderBy('submit_time', 'desc')
                ->get()
                ->map(function ($result) {
                    return [
                        'id' => $result->id,
                        'ujian' => [
                            'id' => $result->ujian->id,
                            'kode_ujian' => $result->ujian->kode_ujian,
                            'nama_ujian' => $result->ujian->nama_ujian ?? $result->ujian->jenis_ujian,
                            'mapel' => $result->ujian->mapel->nama_mapel,
                            'tanggal_ujian' => $result->ujian->tanggal_ujian,
                            'durasi' => $result->ujian->durasi,
                        ],
                        'start_time' => $result->start_time,
                        'submit_time' => $result->submit_time,
                        'score' => $result->score,
                        'status' => $result->status,
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Data hasil ujian berhasil diambil',
                'data' => [
                    'results' => $results,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in API ujian results: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data hasil ujian'
            ], 500);
        }
    }
}
