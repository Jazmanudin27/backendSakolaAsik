<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {

            $table->id();

            // SAMAKAN DENGAN siswa.kode_siswa
            $table->unsignedInteger('kode_siswa');

            $table->date('tanggal_absensi');

            $table->enum('status', [
                'Hadir',
                'Sakit',
                'Izin',
                'Alpha'
            ])->default('Hadir');

            $table->text('keterangan')->nullable();

            // SAMAKAN DENGAN sekolah.kode_sekolah
            $table->unsignedBigInteger('id_sekolah')->nullable();

            $table->timestamps();

            // FOREIGN KEY SISWA
            $table->foreign('kode_siswa')
                ->references('kode_siswa')
                ->on('siswa')
                ->onDelete('cascade');

            // FOREIGN KEY SEKOLAH
            $table->foreign('id_sekolah')
                ->references('kode_sekolah')
                ->on('sekolah')
                ->onDelete('cascade');

            $table->index(['kode_siswa', 'tanggal_absensi']);
            $table->index('id_sekolah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
