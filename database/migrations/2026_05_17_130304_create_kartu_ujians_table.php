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
        Schema::create('kartu_ujians', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kartu_ujian')->unique();
            $table->string('nama_ujian');
            $table->string('tahun_ajaran');
            $table->unsignedBigInteger('id_kelas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartu_ujians');
    }
};
