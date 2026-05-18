<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensis';
    
    protected $fillable = [
        'kode_siswa',
        'tanggal_absensi',
        'status',
        'keterangan',
        'id_sekolah',
    ];

    protected $casts = [
        'tanggal_absensi' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'kode_siswa', 'kode_siswa');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'kode_sekolah');
    }
}
