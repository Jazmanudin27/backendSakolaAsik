<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    protected $fillable = [
        'kode_ujian',
        'tingkat',
        'id_mapel',
        'id_tahun_ajaran',
        'tanggal_ujian',
        'durasi',
        'jenis_ujian',
        'status',
        'keterangan',
        'total_bobot',
        'id_sekolah',
        'id_kelas',
        'file_soal',
        'id_jurusan',
    ];

    protected $casts = [
        'tanggal_ujian' => 'date',
        'id_jurusan' => 'array',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }

    public function tahunPelajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran');
    }

    public function detailUjians()
    {
        return $this->hasMany(DetailUjian::class, 'id_ujian');
    }

    public function jawabanSiswas()
    {
        return $this->hasMany(JawabanSiswa::class, 'id_ujian');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'kode_sekolah');
    }

    public function gambarSoals() { 
        
        return $this->hasMany(UjianSoal::class, 'id_ujian');
    }
}
