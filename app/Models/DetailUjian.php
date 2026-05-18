<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailUjian extends Model
{
    protected $fillable = [
        'id_ujian',
        'soal',
        'gambar_soal',
        'tipe_soal',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'opsi_e',
        'kunci_jawaban',
        'bobot',
        'pembahasan',
        'tingkat_kesulitan',
        'listening',
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'id_ujian');
    }

    public function detailJawabanSiswa()
    {
        return $this->hasMany(DetailJawabanSiswa::class, 'id_detail_ujian');
    }
}
