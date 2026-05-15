<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'singkatan',
        'kelompok',
        'jenis',
        'jam_per_minggu',
        'deskripsi',
        'status',
        'id_sekolah',
    ];

    public function ujians()
    {
        return $this->hasMany(Ujian::class, 'mapel_id');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'kode_sekolah');
    }

}
