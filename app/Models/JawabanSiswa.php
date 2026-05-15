<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    protected $table = 'jawaban_siswa';
    protected $fillable = [
        'id_siswa',
        'id_ujian',
        'waktu_mulai',
        'waktu_selesai',
        'status',
        'status_nilai',
        'id_sekolah',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'id_ujian');
    }

    public function detailJawaban()
    {
        return $this->hasMany(DetailJawabanSiswa::class, 'id_jawaban_siswa');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'kode_sekolah');
    }
}
