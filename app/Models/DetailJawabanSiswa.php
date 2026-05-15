<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailJawabanSiswa extends Model
{
    protected $table = 'detail_jawaban_siswa';
    
    protected $fillable = [
        'id_jawaban_siswa',
        'id_detail_ujian',
        'jawaban',
        'manual_score',
        'admin_notes',
        'is_graded',
        'graded_at',
        'graded_by',
    ];

    public function jawabanSiswa()
    {
        return $this->belongsTo(JawabanSiswa::class, 'id_jawaban_siswa');
    }

    public function detailUjian()
    {
        return $this->belongsTo(DetailUjian::class, 'id_detail_ujian');
    }

    public function getGradedByNameAttribute()
    {
        if ($this->graded_by) {
            // Try to find in Admin first
            $admin = \App\Models\Admin::find($this->graded_by);
            if ($admin) {
                return $admin->name;
            }
            
            // Try to find in Guru
            $guru = \App\Models\Guru::find($this->graded_by);
            if ($guru) {
                return $guru->nama_guru;
            }
        }
        
        return 'Unknown';
    }

    public function gradedByAdmin()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'graded_by');
    }

    /**
     * Check if the answer is correct
     */
    public function getBenarAttribute()
    {
        if (!$this->detailUjian) {
            return false;
        }

        $correctAnswer = strtolower(trim($this->detailUjian->kunci_jawaban));
        $answer = strtolower(trim($this->jawaban));

        switch ($this->detailUjian->tipe_soal) {
            case 'pilihan_ganda':
            case 'benar_salah':
                return $answer === $correctAnswer;
            
            case 'isian_singkat':
                // For short answers, allow some flexibility
                return $answer === $correctAnswer || 
                       str_replace(' ', '', $answer) === str_replace(' ', '', $correctAnswer);
            
            case 'essay':
                // Essay questions need manual grading
                if ($this->is_graded && $this->manual_score !== null) {
                    return $this->manual_score > 0;
                }
                return false;
            
            default:
                return false;
        }
    }

    protected $casts = [
        'manual_score' => 'decimal:2',
        'is_graded' => 'boolean',
        'graded_at' => 'datetime',
    ];
}
