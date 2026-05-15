<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $table = 'sekolah';
    
    protected $primaryKey = 'kode_sekolah';
    
    public $incrementing = true;
    
    protected $keyType = 'int';

    protected $fillable = [
        'nama_sekolah',
        'alamat',
        'npsn',
        'kepala_sekolah',
        'no_telp',
        'email',
        'id_sekolah',
        'website',
        'jenjang',
        'status',
        'kabupaten_kota',
        'provinsi',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kode_sekolah', 'kode_sekolah');
    }

    public function admins()
    {
        return $this->hasMany(Admin::class, 'id_sekolah', 'kode_sekolah');
    }

    public function gurus()
    {
        return $this->hasMany(Guru::class, 'id_sekolah', 'kode_sekolah');
    }

    public function tahunAjarans()
    {
        return $this->hasMany(TahunAjaran::class, 'id_sekolah', 'kode_sekolah');
    }

    public function mapels()
    {
        return $this->hasMany(Mapel::class, 'id_sekolah', 'kode_sekolah');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id_sekolah', 'kode_sekolah');
    }

    public function jurusans()
    {
        return $this->hasMany(Jurusan::class, 'id_sekolah', 'kode_sekolah');
    }

    public function ujians()
    {
        return $this->hasMany(Ujian::class, 'id_sekolah', 'kode_sekolah');
    }

    public function jawabanSiswas()
    {
        return $this->hasMany(JawabanSiswa::class, 'id_sekolah', 'kode_sekolah');
    }
}
