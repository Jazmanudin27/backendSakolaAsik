<?php

namespace App\Http\Controllers;

use App\Models\JawabanSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaHasilUjianController extends SekolahAwareController
{
    public function index()
    {
        $siswa = Auth::guard('siswa')->user();
        
        // Get all submitted exams for this student where results are opened
        $hasilUjians = $this->addSekolahFilter(JawabanSiswa::with(['ujian.kelas', 'ujian.mapel', 'ujian.tahunPelajaran']), JawabanSiswa::class)
            ->where('id_siswa', $siswa->kode_siswa)
            ->where('status', 'submitted')
            ->where('status_nilai', 'dibuka')
            ->orderBy('waktu_selesai', 'desc')
            ->get();

        return view('siswa.hasil-ujian.index', compact('hasilUjians', 'siswa'));
    }

    public function show($id)
    {
        $siswa = Auth::guard('siswa')->user();
        
        $jawabanSiswa = $this->addSekolahFilter(JawabanSiswa::with([
            'siswa',
            'ujian.kelas',
            'ujian.mapel',
            'ujian.tahunPelajaran',
            'ujian.detailUjians',
            'detailJawaban.detailUjian'
        ]), JawabanSiswa::class)->where('id_siswa', $siswa->kode_siswa)
            ->where('id', $id)
            ->where('status', 'submitted')
            ->where('status_nilai', 'dibuka')
            ->firstOrFail();

        // Calculate total score
        $totalScore = 0;
        $maxScore = 0;
        $correctAnswers = 0;
        $totalQuestions = 0;

        foreach ($jawabanSiswa->detailJawaban as $detailJawaban) {
            if ($detailJawaban->detailUjian) {
                $totalQuestions++;
                $maxScore += $detailJawaban->detailUjian->bobot ?? 1;
                
                if ($detailJawaban->benar) {
                    $totalScore += $detailJawaban->detailUjian->bobot ?? 1;
                    $correctAnswers++;
                }
            }
        }

        $percentage = $totalQuestions > 0 ? round(($totalScore / $totalQuestions), 2) : 0;

        return view('siswa.hasil-ujian.show', compact('jawabanSiswa', 'totalScore', 'maxScore', 'correctAnswers', 'totalQuestions', 'percentage'));
    }
}
