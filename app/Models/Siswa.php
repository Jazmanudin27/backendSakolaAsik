<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Siswa extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $table = 'siswa';
    
    protected $primaryKey = 'kode_siswa';
    
    public $incrementing = true;
    
    protected $keyType = 'int';

    protected $fillable = [
        'nisn',
        'nis',
        'nama_siswa',
        'jk',
        'alamat',
        'email',
        'no_hp',
        'tempat_lahir',
        'tgl_lahir',
        'agama',
        'status',
        'kode_kelas',
        'id_sekolah',
        'password',
        'username',
        'foto',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'kode_sekolah');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getAuthIdentifierName()
    {
        return 'kode_siswa';
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kode_kelas', 'id');
    }

    public function jawabanSiswas()
    {
        return $this->hasMany(JawabanSiswa::class, 'id_siswa', 'kode_siswa');
    }
}
