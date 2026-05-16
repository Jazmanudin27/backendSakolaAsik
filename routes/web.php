<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminSiswaController;
use App\Http\Controllers\AdminAdminController;
use App\Http\Controllers\AdminSekolahController;
use App\Http\Controllers\AdminTahunAjaranController;
use App\Http\Controllers\AdminMapelController;
use App\Http\Controllers\AdminGuruController;
use App\Http\Controllers\AdminKelasController;
use App\Http\Controllers\AdminJurusanController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\SiswaUjianController;
use App\Http\Controllers\SiswaHasilUjianController;
use App\Http\Controllers\HasilUjianSiswaController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::prefix('siswa')->name('siswa.')->group(function () {
    Route::middleware(['auth:siswa', 'check.sekolah'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'siswaDashboard'])->name('dashboard');

        // Ujian Routes for Students
        Route::get('/ujian', [SiswaUjianController::class, 'index'])->name('ujian.index');
        Route::get('/ujian/{id}', [SiswaUjianController::class, 'show'])->name('ujian.show');
        Route::get('/ujian/{id}/mulai', [SiswaUjianController::class, 'start'])->name('ujian.start');
        Route::post('/ujian/{id}/submit', [SiswaUjianController::class, 'submit'])->name('ujian.selesai');
        Route::post('/ujian/{id}/save-answer', [SiswaUjianController::class, 'saveAnswer'])->name('ujian.save-answer');
        Route::get('ujian/{id}/view-soal-document', [UjianController::class, 'viewSoalDocument'])->name('ujian.view-soal-document');
        // Hasil Ujian Routes for Students
        Route::get('/hasil-ujian', [SiswaHasilUjianController::class, 'index'])->name('hasil-ujian.index');
        Route::get('/hasil-ujian/{id}', [SiswaHasilUjianController::class, 'show'])->name('hasil-ujian.show');

         });
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['auth:admin', 'check.sekolah'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('dashboard');
        
        // Admin Routes
        Route::resource('admin', AdminAdminController::class)->names([
            'index' => 'admin.index',
            'create' => 'admin.create',
            'store' => 'admin.store',
            'show' => 'admin.show',
            'edit' => 'admin.edit',
            'update' => 'admin.update',
            'destroy' => 'admin.destroy'
        ]);
        
        // Sekolah Routes
        Route::resource('sekolah', AdminSekolahController::class)->names([
            'index' => 'sekolah.index',
            'create' => 'sekolah.create',
            'store' => 'sekolah.store',
            'show' => 'sekolah.show',
            'edit' => 'sekolah.edit',
            'update' => 'sekolah.update',
            'destroy' => 'sekolah.destroy'
        ]);

        // Siswa Routes
        Route::resource('siswa', AdminSiswaController::class)->names([
            'index' => 'siswa.index',
            'create' => 'siswa.create',
            'store' => 'siswa.store',
            'show' => 'siswa.show',
            'edit' => 'siswa.edit',
            'update' => 'siswa.update',
            'destroy' => 'siswa.destroy'
        ]);
        
        // Ujian Routes for teachers (admin access)
        Route::resource('ujian', UjianController::class)->names([
            'index' => 'ujian.index',
            'create' => 'ujian.create',
            'store' => 'ujian.store',
            'show' => 'ujian.show',
            'edit' => 'ujian.edit',
            'update' => 'ujian.update',
            'destroy' => 'ujian.destroy'
        ]);
        
        // Ujian Detail Routes
        Route::get('ujian/{id}/create-soal', [UjianController::class, 'createSoal'])->name('ujian.create-soal');
        Route::post('ujian/{id}/store-soal', [UjianController::class, 'storeSoal'])->name('ujian.store-soal');
        Route::get('ujian/{id}/edit-soal/{soalId}', [UjianController::class, 'editSoal'])->name('ujian.edit-soal');
        Route::put('ujian/{id}/update-soal/{soalId}', [UjianController::class, 'updateSoal'])->name('ujian.update-soal');
        Route::put('ujian/{id}/update-kunci/{soalId}', [UjianController::class, 'updateKunci'])->name('ujian.update-kunci');
        Route::put('ujian/{id}/activate', [UjianController::class, 'activate'])->name('ujian.activate');
        Route::delete('ujian/{id}/destroy-soal/{soalId}', [UjianController::class, 'destroySoal'])->name('ujian.destroy-soal');
        Route::post('ujian/upload-image', [UjianController::class, 'uploadImage'])->name('ujian.upload-image');
        Route::get('ujian/{id}/cetak-soal', [UjianController::class, 'cetakSoal'])->name('ujian.cetak-soal');
        // Soal Document Routes
        Route::post('ujian/{id}/upload-soal-document', [UjianController::class, 'uploadSoalDocument'])->name('ujian.upload-soal-document');
        Route::get('ujian/{id}/view-soal-document', [UjianController::class, 'viewSoalDocument'])->name('ujian.view-soal-document');
        // Gambar Soal Routes
        Route::post('ujian/{id}/upload-gambar-soal', [UjianController::class, 'uploadGambarSoal'])->name('ujian.upload-gambar-soal');
        
        // Hasil Ujian Siswa Routes
        Route::get('hasil-ujian', [HasilUjianSiswaController::class, 'index'])->name('hasil-ujian.index');
        Route::get('hasil-ujian/{id}', [HasilUjianSiswaController::class, 'show'])->name('hasil-ujian.show');
        Route::get('hasil-ujian/{id}/grade', [HasilUjianSiswaController::class, 'grade'])->name('hasil-ujian.grade');
        Route::post('hasil-ujian/{id}/save-grades', [HasilUjianSiswaController::class, 'saveGrades'])->name('hasil-ujian.save-grades');
        Route::get('hasil-ujian/{id}/print', [HasilUjianSiswaController::class, 'print'])->name('hasil-ujian.print');
        Route::get('hasil-ujian/export', [HasilUjianSiswaController::class, 'export'])->name('hasil-ujian.export');
        Route::post('hasil-ujian/{id}/open-results', [HasilUjianSiswaController::class, 'openResults'])->name('hasil-ujian.open-results');
        Route::post('hasil-ujian/{id}/close-results', [HasilUjianSiswaController::class, 'closeResults'])->name('hasil-ujian.close-results');
        Route::post('ujian/{id}/generate-questions', [UjianController::class, 'generateQuestions'])->name('ujian.generate-questions');
        Route::post('ujian/{id}/delete-all-questions', [UjianController::class, 'deleteAllQuestions'])->name('ujian.delete-all-questions');
        Route::get('/generate-kode-ujian', [UjianController::class, 'generateKode']) ->name('ujian.generate-kode');
        Route::post('ujian/delete-gambar', [UjianController::class, 'deleteGambar'])->name('ujian.delete-gambar');
        
       // Tahun Ajaran Routes
        Route::resource('tahun_ajaran', AdminTahunAjaranController::class)->names([
            'index' => 'tahun_ajaran.index',
            'create' => 'tahun_ajaran.create',
            'store' => 'tahun_ajaran.store',
            'show' => 'tahun_ajaran.show',
            'edit' => 'tahun_ajaran.edit',
            'update' => 'tahun_ajaran.update',
            'destroy' => 'tahun_ajaran.destroy'
        ]);
        
        // Mapel Routes
        Route::resource('mapel', AdminMapelController::class)->names([
            'index' => 'mapel.index',
            'create' => 'mapel.create',
            'store' => 'mapel.store',
            'show' => 'mapel.show',
            'edit' => 'mapel.edit',
            'update' => 'mapel.update',
            'destroy' => 'mapel.destroy'
        ]);
        
        // Guru Routes
        Route::resource('guru', AdminGuruController::class)->names([
            'index' => 'guru.index',
            'create' => 'guru.create',
            'store' => 'guru.store',
            'show' => 'guru.show',
            'edit' => 'guru.edit',
            'update' => 'guru.update',
            'destroy' => 'guru.destroy'
        ]);
        
        // Kelas Routes
        Route::resource('kelas', AdminKelasController::class)->names([
            'index' => 'kelas.index',
            'create' => 'kelas.create',
            'store' => 'kelas.store',
            'show' => 'kelas.show',
            'edit' => 'kelas.edit',
            'update' => 'kelas.update',
            'destroy' => 'kelas.destroy'
        ]);
        
        // Jurusan Routes
        Route::resource('jurusan', AdminJurusanController::class)->names([
            'index' => 'jurusan.index',
            'create' => 'jurusan.create',
            'store' => 'jurusan.store',
            'show' => 'jurusan.show',
            'edit' => 'jurusan.edit',
            'update' => 'jurusan.update',
            'destroy' => 'jurusan.destroy'
        ]);

        // Laporan Routes
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('siswa', [LaporanController::class, 'siswa'])->name('siswa');
            Route::get('guru', [LaporanController::class, 'guru'])->name('guru');
            Route::get('kelas', [LaporanController::class, 'kelas'])->name('kelas');
            Route::get('siswa-per-kelas', [LaporanController::class, 'siswaPerKelas'])->name('siswa-per-kelas');
            Route::get('ujian', [LaporanController::class, 'ujian'])->name('ujian');
            Route::get('nilai', [LaporanController::class, 'nilai'])->name('nilai');
            Route::get('nilai/print', [LaporanController::class, 'nilaiPrint'])->name('nilai.print');
            Route::get('kehadiran', [LaporanController::class, 'kehadiran'])->name('kehadiran');
            Route::get('pembayaran', [LaporanController::class, 'pembayaran'])->name('pembayaran');
        });
    });
});

Route::prefix('guru')->name('guru.')->group(function () {
    Route::middleware(['auth:guru', 'check.sekolah'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'guruDashboard'])->name('dashboard');
        
        // Sekolah Routes
        Route::resource('sekolah', AdminSekolahController::class)->names([
            'index' => 'sekolah.index',
            'create' => 'sekolah.create',
            'store' => 'sekolah.store',
            'show' => 'sekolah.show',
            'edit' => 'sekolah.edit',
            'update' => 'sekolah.update',
            'destroy' => 'sekolah.destroy'
        ]);

        Route::resource('siswa', AdminSiswaController::class)->names([
            'index' => 'siswa.index',
            'create' => 'siswa.create',
            'store' => 'siswa.store',
            'show' => 'siswa.show',
            'edit' => 'siswa.edit',
            'update' => 'siswa.update',
            'destroy' => 'siswa.destroy'
        ]);
        
        // Guru Routes
        Route::resource('guru', AdminGuruController::class)->names([
            'index' => 'guru.index',
            'create' => 'guru.create',
            'store' => 'guru.store',
            'show' => 'guru.show',
            'edit' => 'guru.edit',
            'update' => 'guru.update',
            'destroy' => 'guru.destroy'
        ]);
        
        // Ujian Routes for teachers
        Route::resource('ujian', UjianController::class)->names([
            'index' => 'ujian.index',
            'create' => 'ujian.create',
            'store' => 'ujian.store',
            'show' => 'ujian.show',
            'edit' => 'ujian.edit',
            'update' => 'ujian.update',
            'destroy' => 'ujian.destroy'
        ]);
        
        // Ujian Detail Routes
        Route::get('ujian/{id}/create-soal', [UjianController::class, 'createSoal'])->name('ujian.create-soal');
        Route::post('ujian/{id}/store-soal', [UjianController::class, 'storeSoal'])->name('ujian.store-soal');
        Route::get('ujian/{id}/edit-soal/{soalId}', [UjianController::class, 'editSoal'])->name('ujian.edit-soal');
        Route::put('ujian/{id}/update-soal/{soalId}', [UjianController::class, 'updateSoal'])->name('ujian.update-soal');
        Route::put('ujian/{id}/update-kunci/{soalId}', [UjianController::class, 'updateKunci'])->name('ujian.update-kunci');
        Route::put('ujian/{id}/activate', [UjianController::class, 'activate'])->name('ujian.activate');
        Route::delete('ujian/{id}/destroy-soal/{soalId}', [UjianController::class, 'destroySoal'])->name('ujian.destroy-soal');
        Route::post('ujian/upload-image', [UjianController::class, 'uploadImage'])->name('ujian.upload-image');
        Route::get('ujian/{id}/cetak-soal', [UjianController::class, 'cetakSoal'])->name('ujian.cetak-soal');
        // Soal Document Routes
        Route::post('ujian/{id}/upload-soal-document', [UjianController::class, 'uploadSoalDocument'])->name('ujian.upload-soal-document');
        Route::get('ujian/{id}/view-soal-document', [UjianController::class, 'viewSoalDocument'])->name('ujian.view-soal-document');
        // Gambar Soal Routes
        Route::post('ujian/{id}/upload-gambar-soal', [UjianController::class, 'uploadGambarSoal'])->name('ujian.upload-gambar-soal');
         
        // Hasil Ujian Siswa Routes
        Route::get('hasil-ujian', [HasilUjianSiswaController::class, 'index'])->name('hasil-ujian.index');
        Route::get('hasil-ujian/{id}', [HasilUjianSiswaController::class, 'show'])->name('hasil-ujian.show');
        Route::get('hasil-ujian/{id}/grade', [HasilUjianSiswaController::class, 'grade'])->name('hasil-ujian.grade');
        Route::post('hasil-ujian/{id}/save-grades', [HasilUjianSiswaController::class, 'saveGrades'])->name('hasil-ujian.save-grades');
        Route::get('hasil-ujian/{id}/print', [HasilUjianSiswaController::class, 'print'])->name('hasil-ujian.print');
        Route::get('hasil-ujian/export', [HasilUjianSiswaController::class, 'export'])->name('hasil-ujian.export');
        Route::post('hasil-ujian/{id}/open-results', [HasilUjianSiswaController::class, 'openResults'])->name('hasil-ujian.open-results');
        Route::post('hasil-ujian/{id}/close-results', [HasilUjianSiswaController::class, 'closeResults'])->name('hasil-ujian.close-results');
        Route::post('ujian/{id}/generate-questions', [UjianController::class, 'generateQuestions'])->name('ujian.generate-questions');
        Route::post('ujian/{id}/delete-all-questions', [UjianController::class, 'deleteAllQuestions'])->name('ujian.delete-all-questions');
        Route::get('/generate-kode-ujian', [UjianController::class, 'generateKode']) ->name('ujian.generate-kode');
        Route::post('ujian/delete-gambar', [UjianController::class, 'deleteGambar'])->name('ujian.delete-gambar');
        
        // Tahun Ajaran Routes
        Route::resource('tahun_ajaran', AdminTahunAjaranController::class)->names([
            'index' => 'tahun_ajaran.index',
            'create' => 'tahun_ajaran.create',
            'store' => 'tahun_ajaran.store',
            'show' => 'tahun_ajaran.show',
            'edit' => 'tahun_ajaran.edit',
            'update' => 'tahun_ajaran.update',
            'destroy' => 'tahun_ajaran.destroy'
        ]);
        
        // Mapel Routes
        Route::resource('mapel', AdminMapelController::class)->names([
            'index' => 'mapel.index',
            'create' => 'mapel.create',
            'store' => 'mapel.store',
            'show' => 'mapel.show',
            'edit' => 'mapel.edit',
            'update' => 'mapel.update',
            'destroy' => 'mapel.destroy'
        ]);
        
        // Kelas Routes
        Route::resource('kelas', AdminKelasController::class)->names([
            'index' => 'kelas.index',
            'create' => 'kelas.create',
            'store' => 'kelas.store',
            'show' => 'kelas.show',
            'edit' => 'kelas.edit',
            'update' => 'kelas.update',
            'destroy' => 'kelas.destroy'
        ]);
        
        // Jurusan Routes
        Route::resource('jurusan', AdminJurusanController::class)->names([
            'index' => 'jurusan.index',
            'create' => 'jurusan.create',
            'store' => 'jurusan.store',
            'show' => 'jurusan.show',
            'edit' => 'jurusan.edit',
            'update' => 'jurusan.update',
            'destroy' => 'jurusan.destroy'
        ]);
    });
});
