<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Guru extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $fillable = [
        'nip',
        'nama_guru',
        'jk',
        'alamat',
        'email',
        'no_hp',
        'tempat_lahir',
        'tgl_lahir',
        'agama',
        'jurusan',
        'status',
        'jabatan',
        'id_sekolah',
        'password',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'password' => 'hashed',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'kode_sekolah');
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

}
