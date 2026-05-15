<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $fillable = [
        'nama_jurusan',
        'singkatan',
        'deskripsi',
        'kepala_jurusan',
        'jenis',
        'status',
        'id_sekolah',
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jurusan_id');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'kode_sekolah');
    }

}
