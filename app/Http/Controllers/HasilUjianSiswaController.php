<?php

namespace App\Http\Controllers;

use App\Models\JawabanSiswa;
use App\Models\Ujian;
use App\Models\DetailUjian;
use App\Models\DetailJawabanSiswa;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HasilUjianSiswaController extends SekolahAwareController
{
    public function index(Request $request)
    {
        $query = $this->addSekolahFilter(JawabanSiswa::with(['siswa', 'ujian.kelas', 'ujian.mapel', 'ujian.tahunPelajaran']), JawabanSiswa::class)
            ->where('status', 'submitted')
            ->orderBy('waktu_selesai', 'desc');

        if ($request->has('id_ujian') && $request->id_ujian) {
            $query->where('id_ujian', $request->id_ujian);
        }

        if ($request->has('id_kelas') && $request->id_kelas) {
            $query->whereHas('ujian', function($q) use ($request) {
                $q->where('id_kelas', $request->id_kelas);
            });
        }
        if ($request->has('id_mapel') && $request->id_mapel) {
            $query->whereHas('ujian', function($q) use ($request) {
                $q->where('id_mapel', $request->id_mapel);
            });
        }

        $hasilUjians = $query->get();
        foreach ($hasilUjians as $hasil) {
            $hasil->score = $this->calculateScore($hasil);
        }
        $ujians = Ujian::with(['kelas', 'mapel'])->orderBy('tanggal_ujian', 'desc')->get();
        $kelasList = \App\Models\Kelas::all();
        $mapelList = \App\Models\Mapel::all();

        return view('admin.hasil-ujian.index', compact('hasilUjians', 'ujians', 'kelasList', 'mapelList'));
    }

    public function show($id)
    {
        $jawabanSiswa = $this->addSekolahFilter(JawabanSiswa::with([
            'siswa', 
            'ujian.kelas', 
            'ujian.mapel', 
            'ujian.tahunPelajaran',
            'ujian.detailUjians',
            'detailJawaban.detailUjian'
        ]), JawabanSiswa::class)->findOrFail($id);

        // Get all questions for this exam
        $detailUjians = DetailUjian::where('id_ujian', $jawabanSiswa->id_ujian)
            ->orderByRaw("FIELD(tipe_soal, 'pilihan_ganda', 'benar_salah', 'isian_singkat','essay')")
            ->orderByRaw("FIELD(tingkat_kesulitan, 'mudah', 'sedang', 'sulit', 'tinggi')")
            ->get();

        // Load existing answers
        $existingAnswers = DB::table('detail_jawaban_siswa')
            ->where('id_jawaban_siswa', $jawabanSiswa->id)
            ->pluck('jawaban', 'id_detail_ujian')
            ->toArray();

        // Get student answers
        $studentAnswers = DetailJawabanSiswa::where('id_jawaban_siswa', $jawabanSiswa->id)
            ->with('detailUjian')
            ->get()
            ->keyBy('id_detail_ujian');

        // Calculate detailed scores
        $scoreDetails = $this->calculateDetailedScore($detailUjians, $studentAnswers);

        return view('admin.hasil-ujian.show', compact('jawabanSiswa', 'detailUjians', 'studentAnswers', 'scoreDetails'));
    }

    /**
     * Calculate total score for a student exam
     */
    private function calculateScore($jawabanSiswa)
    {
        $detailUjians = DetailUjian::where('id_ujian', $jawabanSiswa->id_ujian)->get();
        $studentAnswers = DetailJawabanSiswa::where('id_jawaban_siswa', $jawabanSiswa->id)
            ->get()
            ->keyBy('id_detail_ujian');

        $totalScore = 0;
        $totalMaxScore = 0;

        foreach ($detailUjians as $soal) {
            $totalMaxScore += $soal->bobot;
            
            if (isset($studentAnswers[$soal->id])) {
                $studentAnswer = $studentAnswers[$soal->id];
                $totalScore += $this->getAnswerScore($soal, $studentAnswer->jawaban, $studentAnswer);
            }
        }

        return [
            'score' => $totalScore,
            'max_score' => $totalMaxScore,
            'percentage' => $totalMaxScore > 0 ? round(($totalScore / $totalMaxScore) * 100, 2) : 0
        ];
    }

    /**
     * Calculate detailed score breakdown
     */
    private function calculateDetailedScore($detailUjians, $studentAnswers)
    {
        $scoreDetails = [
            'total_score' => 0,
            'total_max_score' => 0,
            'correct_count' => 0,
            'wrong_count' => 0,
            'unanswered_count' => 0,
            'by_difficulty' => [
                'mudah' => ['score' => 0, 'max' => 0, 'count' => 0],
                'sedang' => ['score' => 0, 'max' => 0, 'count' => 0],
                'sulit' => ['score' => 0, 'max' => 0, 'count' => 0],
            ],
            'by_type' => [
                'pilihan_ganda' => ['score' => 0, 'max' => 0, 'count' => 0],
                'essay' => ['score' => 0, 'max' => 0, 'count' => 0],
                'benar_salah' => ['score' => 0, 'max' => 0, 'count' => 0],
                'isian_singkat' => ['score' => 0, 'max' => 0, 'count' => 0],
            ]
        ];

        foreach ($detailUjians as $soal) {
            $scoreDetails['total_max_score'] += $soal->bobot;
            
            // By difficulty
            if (isset($scoreDetails['by_difficulty'][$soal->tingkat_kesulitan])) {
                $scoreDetails['by_difficulty'][$soal->tingkat_kesulitan]['max'] += $soal->bobot;
                $scoreDetails['by_difficulty'][$soal->tingkat_kesulitan]['count']++;
            }
            
            // By type
            if (isset($scoreDetails['by_type'][$soal->tipe_soal])) {
                $scoreDetails['by_type'][$soal->tipe_soal]['max'] += $soal->bobot;
                $scoreDetails['by_type'][$soal->tipe_soal]['count']++;
            }

            if (isset($studentAnswers[$soal->id])) {
                $studentAnswer = $studentAnswers[$soal->id];
                $answerScore = $this->getAnswerScore($soal, $studentAnswer->jawaban, $studentAnswer);
                $scoreDetails['total_score'] += $answerScore;
                
                if ($answerScore > 0) {
                    $scoreDetails['correct_count']++;
                    
                    // Update difficulty breakdown
                    if (isset($scoreDetails['by_difficulty'][$soal->tingkat_kesulitan])) {
                        $scoreDetails['by_difficulty'][$soal->tingkat_kesulitan]['score'] += $answerScore;
                    }
                    
                    // Update type breakdown
                    if (isset($scoreDetails['by_type'][$soal->tipe_soal])) {
                        $scoreDetails['by_type'][$soal->tipe_soal]['score'] += $answerScore;
                    }
                } else {
                    $scoreDetails['wrong_count']++;
                }
            } else {
                $scoreDetails['unanswered_count']++;
            }
        }

        return $scoreDetails;
    }

    /**
     * Check if student answer is correct
     */
    private function isCorrectAnswer($soal, $studentAnswer, $studentAnswerRecord = null)
    {
        $correctAnswer = strtolower(trim($soal->kunci_jawaban));
        $answer = strtolower(trim($studentAnswer));

        switch ($soal->tipe_soal) {
            case 'pilihan_ganda':
            case 'benar_salah':
                return $answer === $correctAnswer;
            
            case 'isian_singkat':
                // For short answers, allow some flexibility
                return $answer === $correctAnswer || 
                       str_replace(' ', '', $answer) === str_replace(' ', '', $correctAnswer);
            
            case 'essay':
                // Essay questions need manual grading
                if ($studentAnswerRecord && $studentAnswerRecord->is_graded && $studentAnswerRecord->manual_score !== null) {
                    return $studentAnswerRecord->manual_score > 0;
                }
                return false;
            
            default:
                return false;
        }
    }

    /**
     * Get score for a specific answer
     */
    private function getAnswerScore($soal, $studentAnswer, $studentAnswerRecord = null)
    {
        if ($soal->tipe_soal === 'essay') {
            if ($studentAnswerRecord && $studentAnswerRecord->is_graded && $studentAnswerRecord->manual_score !== null) {
                return $studentAnswerRecord->manual_score;
            }
            return 0;
        } else {
            return $this->isCorrectAnswer($soal, $studentAnswer, $studentAnswerRecord) ? $soal->bobot : 0;
        }
    }

    /**
     * Export results to Excel (placeholder for future implementation)
     */
    public function export(Request $request)
    {
        // TODO: Implement Excel export functionality
        return redirect()->back()->with('info', 'Fitur export akan segera tersedia');
    }

    /**
     * Show grading interface for essay questions
     */
    public function grade($id)
    {
        $jawabanSiswa = $this->addSekolahFilter(JawabanSiswa::with([
            'siswa', 
            'ujian.kelas', 
            'ujian.mapel', 
            'ujian.tahunPelajaran'
        ]), JawabanSiswa::class)->findOrFail($id);

        // Get only essay questions that have been answered
        $essayQuestions = DetailUjian::where('id_ujian', $jawabanSiswa->id_ujian)
            ->where('tipe_soal', 'essay')
            ->with(['detailJawabanSiswa' => function($query) use ($jawabanSiswa) {
                $query->where('id_jawaban_siswa', $jawabanSiswa->id);
            }])
            ->get();

        return view('admin.hasil-ujian.grade', compact('jawabanSiswa', 'essayQuestions'));
    }

    /**
     * Save essay grades
     */
    public function saveGrades(Request $request, $id)
    {
        $jawabanSiswa = $this->addSekolahFilter(JawabanSiswa::query(), JawabanSiswa::class)->findOrFail($id);
        // Get current user ID based on guard
        $userId = null;
        if (Auth::guard('admin')->check()) {
            $userId = Auth::guard('admin')->user()->id;
        } elseif (Auth::guard('guru')->check()) {
            $userId = Auth::guard('guru')->user()->id;
        }

        $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'required|numeric|min:0',
            'notes' => 'nullable|array',
            'notes.*' => 'nullable|string|max:1000'
        ]);

        foreach ($request->scores as $questionId => $score) {
            $detailJawaban = DetailJawabanSiswa::where('id_jawaban_siswa', $jawabanSiswa->id)
                ->where('id_detail_ujian', $questionId)
                ->firstOrFail();

            $maxScore = DetailUjian::findOrFail($questionId)->bobot;

            if ($score > $maxScore) {
                return redirect()->back()
                    ->with('error', "Skor untuk soal tidak boleh melebihi {$maxScore} poin");
            }

            $detailJawaban->update([
                'manual_score' => $score,
                'admin_notes' => $request->notes[$questionId] ?? null,
                'is_graded' => true,
                'graded_at' => now(),
                'graded_by' => $userId
            ]);
        }

        return redirect()->route('admin.hasil-ujian.show', $id)
            ->with('success', 'Nilai esai berhasil disimpan!');
    }

    /**
     * Print results (placeholder for future implementation)
     */
    public function print($id)
    {
        $jawabanSiswa = $this->addSekolahFilter(JawabanSiswa::with([
            'siswa', 
            'ujian.kelas', 
            'ujian.mapel', 
            'ujian.tahunPelajaran'
        ]), JawabanSiswa::class)->findOrFail($id);

        $scoreDetails = $this->calculateDetailedScore(
            DetailUjian::where('id_ujian', $jawabanSiswa->id_ujian)->get(),
            DetailJawabanSiswa::where('id_jawaban_siswa', $jawabanSiswa->id)->get()->keyBy('id_detail_ujian')
        );

        return view('admin.hasil-ujian.print', compact('jawabanSiswa', 'scoreDetails'));
    }
    /**
     * Close exam results (hide from students)
     */
    public function closeResults($id)
    {
        // Check if this is a ujian ID or jawaban_siswa ID
        $ujian = \App\Models\Ujian::find($id);
        
        if ($ujian) {
            // This is a ujian ID - update all student results for this exam
            $jawabanSiswaList = $this->addSekolahFilter(JawabanSiswa::where('id_ujian', $id), JawabanSiswa::class)->get();
            
            foreach ($jawabanSiswaList as $jawabanSiswa) {
                $jawabanSiswa->update([
                    'status_nilai' => 'belum_dibuka'
                ]);
            }
            
            return redirect()->back()->with('success', 'Hasil ujian berhasil ditutup dari semua siswa.');
        } else {
            // This is a jawaban_siswa ID - update individual result
            $jawabanSiswa = $this->addSekolahFilter(JawabanSiswa::query(), JawabanSiswa::class)->findOrFail($id);
            
            $jawabanSiswa->update([
                'status_nilai' => 'belum_dibuka'
            ]);

            return redirect()->back()->with('success', 'Hasil ujian berhasil ditutup dari siswa.');
        }
    }

    /**
     * Open exam results (make visible to students)
     */
    public function openResults($id)
    {
        // Check if this is a ujian ID or jawaban_siswa ID
        $ujian = \App\Models\Ujian::find($id);
        
        if ($ujian) {
            // This is a ujian ID - update all student results for this exam
            $jawabanSiswaList = $this->addSekolahFilter(JawabanSiswa::where('id_ujian', $id), JawabanSiswa::class)->get();
            
            foreach ($jawabanSiswaList as $jawabanSiswa) {
                $jawabanSiswa->update([
                    'status_nilai' => 'dibuka'
                ]);
            }
            
            return redirect()->back()->with('success', 'Hasil ujian berhasil dibuka untuk semua siswa.');
        } else {
            // This is a jawaban_siswa ID - update individual result
            $jawabanSiswa = $this->addSekolahFilter(JawabanSiswa::query(), JawabanSiswa::class)->findOrFail($id);
            
            $jawabanSiswa->update([
                'status_nilai' => 'dibuka'
            ]);

            return redirect()->back()->with('success', 'Hasil ujian berhasil dibuka untuk siswa.');
        }
    }
}
