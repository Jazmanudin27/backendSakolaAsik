<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\SiswaUjianController;

// API Routes for Mobile Application
Route::prefix('v1')->group(function () {
    
    // Public routes
    Route::post('/login', [LoginController::class, 'login'])->name('api.login');
    Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('api.reset-password');
    Route::post('/confirm-reset-password', [LoginController::class, 'confirmPasswordReset'])->name('api.confirm-reset-password');
    Route::post('/logout-legacy', [LoginController::class, 'logout'])->name('api.logout.legacy');
    
    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        
        Route::post('/logout', [LoginController::class, 'logout'])->name('api.logout');
        Route::get('/profile', [LoginController::class, 'profile'])->name('api.profile');
        Route::post('/refresh', [LoginController::class, 'refresh'])->name('api.refresh');
        Route::post('/change-password', [LoginController::class, 'changePassword'])->name('api.change-password');
        
        // Admin specific API routes
        Route::prefix('admin')->middleware('auth:admin-api')->group(function () {
            Route::get('/dashboard', function () {
                return response()->json([
                    'success' => true,
                    'message' => 'Admin dashboard data',
                    'data' => []
                ]);
            });
        });
        
        // Guru specific API routes
        Route::prefix('guru')->middleware('auth:guru-api')->group(function () {
            Route::get('/dashboard', function () {
                return response()->json([
                    'success' => true,
                    'message' => 'Guru dashboard data',
                    'data' => []
                ]);
            });
        });
        
        // Siswa specific API routes
        Route::prefix('siswa')->middleware('auth:sanctum')->group(function () {
            Route::get('/info', [SiswaUjianController::class, 'infoSiswa']);
            
            // Ujian API routes
            Route::prefix('ujian')->group(function () {
                Route::get('/results', [SiswaUjianController::class, 'results']);
                Route::get('/results/{resultId}', [SiswaUjianController::class, 'detailResult']);
                Route::get('/', [SiswaUjianController::class, 'index']);
                Route::get('/{id}', [SiswaUjianController::class, 'show']);
                Route::post('/{id}/start', [SiswaUjianController::class, 'start']);
                Route::post('/{id}/save-answer', [SiswaUjianController::class, 'saveAnswer']);
                Route::post('/{id}/submit', [SiswaUjianController::class, 'submit']);
            });
        });
    });
});
