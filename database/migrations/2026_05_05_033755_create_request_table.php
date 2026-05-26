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
        
        Schema::create('request', function (Blueprint $table) {
            $table->id('id_request');
            $table->string('software');
            $table->bigInteger('no_hp');
            $table->dateTime('tanggal_mulai');
            $table->dateTime('perkiraan_selesai');
            $table->enum('enum', ['pending', 'setuju', 'tidak', 'selesai'])->default('pending');
            $table->text('catatan');
            $table->string('foto_bukti')->nullable();
            $table->unsignedBigInteger('id_mahasiswa');
            $table->unsignedBigInteger('id_komputer');
            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('mahasiswa')->cascadeOnDelete();
            $table->foreign('id_komputer')->references('id_komputer')->on('komputer')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request');
    }
};