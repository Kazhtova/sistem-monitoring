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
        
        Schema::create('komputer', function (Blueprint $table) {
            $table->id('id_komputer');
            $table->string('nama_komputer');
            $table->unsignedBigInteger('id_laboratorium');
            $table->foreign('id_laboratorium')->references('id_laboratorium')->on('laboratorium')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komputer');
    }
};