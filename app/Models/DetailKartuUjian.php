<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailKartuUjian extends Model
{
    protected $table = 'kartu_ujian_details';

    protected $fillable = [
        'id',
        'kartu_ujian_id',
        'id_siswa',
        'ruangan',
        'created_at',
        'updated_at',
    ];

    public function kartuUjian()
    {
        return $this->belongsTo(KartuUjian::class, 'kartu_ujian_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
}
