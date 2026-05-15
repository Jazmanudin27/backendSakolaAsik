<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'wali_kelas',
        'kapasitas',
        'jumlah_siswa',
        'ruangan',
        'status',
        'keterangan',
        'id_sekolah',
        'jurusan_id',
    ];

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'kode_kelas');
    }

    public function ujians()
    {
        return $this->hasMany(Ujian::class, 'id_kelas');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'kode_sekolah');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

}
