<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuUjian extends Model
{
    protected $fillable = [
        'nama_ujian',
        'id_tahun_ajaran',
        'id_kelas',
        'id_sekolah',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran');
    }

    public function detailKartuUjians()
    {
        return $this->hasMany(DetailKartuUjian::class, 'kartu_ujian_id');
    }

    public function detailKartuUjian()
    {
        return $this->hasMany(DetailKartuUjian::class, 'kartu_ujian_id');
    }
}
