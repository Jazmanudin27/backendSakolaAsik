<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjianSoal extends Model
{
    use HasFactory;

    protected $table = 'ujian_soal';

    protected $fillable = [
        'id_ujian',
        'gambar_soal',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'id_ujian');
    }
}
