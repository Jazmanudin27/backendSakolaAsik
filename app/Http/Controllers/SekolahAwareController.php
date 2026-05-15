<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

abstract class SekolahAwareController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Get the current user's sekolah ID
     *
     * @return int|null
     */
    protected function getCurrentSekolahId()
    {
        if (Auth::guard('admin')->check()) {
            return Auth::guard('admin')->user()->id_sekolah ?? '1';
        } elseif (Auth::guard('guru')->check()) {
            return Auth::guard('guru')->user()->id_sekolah;
        } elseif (Auth::guard('siswa')->check()) {
            return Auth::guard('siswa')->user()->id_sekolah;
        }
        
        return null;
    }

    /**
     * Get sekolah column name for specific model
     *
     * @param string $model
     * @return string
     */
    protected function getSekolahColumnName($model)
    {
        $columnMap = [
            'Siswa' => 'id_sekolah',
            'Guru' => 'id_sekolah',
            'Sekolah' => 'kode_sekolah',
            'Kelas' => 'id_sekolah',
            'Jurusan' => 'id_sekolah',
            'Mapel' => 'id_sekolah',
            'TahunAjaran' => 'id_sekolah',
        ];
        
        return $columnMap[$model] ?? 'id_sekolah';
    }

    /**
     * Add sekolah filter to query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $modelClass
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function addSekolahFilter($query, $modelClass)
    {
        $sekolahId = $this->getCurrentSekolahId();
        
        if ($sekolahId) {
            $columnName = $this->getSekolahColumnName(class_basename($modelClass));
            // Use qualified column name for kelas table to avoid ambiguity
            if (class_basename($modelClass) === 'Kelas') {
                return $query->where('kelas.' . $columnName, $sekolahId);
            }
            return $query->where($columnName, $sekolahId);
        }
        
        return $query;
    }

    /**
     * Check if current user is Admin
     *
     * @return bool
     */
    protected function isAdmin()
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Check if current user is Guru
     *
     * @return bool
     */
    protected function isGuru()
    {
        return Auth::guard('guru')->check();
    }

    /**
     * Get sekolah options for dropdowns
     * Admin: semua sekolah
     * Guru: hanya sekolahnya sendiri
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $modelClass
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getSekolahOptions($query, $modelClass)
    {
        if ($this->isGuru()) {
            $sekolahId = $this->getCurrentSekolahId();
            if ($sekolahId) {
                // Untuk tabel sekolah, gunakan primary key 'kode_sekolah'
                if ($modelClass === 'App\Models\Sekolah') {
                    return $query->where('kode_sekolah', $sekolahId);
                } else {
                    $columnName = $this->getSekolahColumnName(class_basename($modelClass));
                    return $query->where($columnName, $sekolahId);
                }
            }
        }
        // Admin: tidak ada filter, tampilkan semua sekolah
        
        return $query;
    }
}
