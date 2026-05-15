<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $table = 'admins';
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_sekolah',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'kode_sekolah');
    }
}
