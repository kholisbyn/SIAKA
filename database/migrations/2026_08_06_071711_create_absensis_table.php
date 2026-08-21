<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('absensis', function (Blueprint $table) {
        $table->id();

        $table->foreignId('karyawan_id')->constrained()->cascadeOnDelete();

        $table->date('tanggal');

        $table->time('jam_masuk')->nullable();
        $table->string('foto_masuk')->nullable();
        $table->text('lokasi_masuk')->nullable();

        $table->time('jam_pulang')->nullable();
        $table->string('foto_pulang')->nullable();
        $table->text('lokasi_pulang')->nullable();

        $table->text('keterangan')->nullable();

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};