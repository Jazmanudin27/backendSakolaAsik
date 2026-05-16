<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UjianController;
use App\Http\Controllers\Api\SiswaUjianController;

/*
|--------------------------------------------------------------------------
| API Routes for Ujian (Exams)
|--------------------------------------------------------------------------
|
| These routes are for the mobile app to interact with the exam system.
| All routes require authentication.
|
*/

Route::middleware('auth:sanctum')->prefix('siswa')->group(function () {

    // Get list of available exams for the authenticated student
    Route::get('/ujian', [UjianController::class, 'index']);

    // Start an exam
    Route::post('/ujian/{ujianId}/start', [UjianController::class, 'start']);

    // Save exam answers (auto-save functionality)
    Route::post('/ujian/{ujianId}/save', [UjianController::class, 'saveAnswer']);

    // Submit final exam answers
    Route::post('/ujian/{ujianId}/submit', [UjianController::class, 'submit']);

    // Get exam results
    Route::get('/ujian/results', [SiswaUjianController::class, 'results']);

    // Get detailed exam result
    Route::get('/ujian/results/{resultId}', [SiswaUjianController::class, 'detailResult']);

});
