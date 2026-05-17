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
        Schema::create('kartu_ujian_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kartu_ujian_id')->constrained('kartu_ujians')->onDelete('cascade');
            $table->integer('kode_siswa');
            $table->string('ruangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartu_ujian_details');
    }
};
