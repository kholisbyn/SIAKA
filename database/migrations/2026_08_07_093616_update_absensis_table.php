<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            if (!Schema::hasColumn('absensis', 'tanggal')) {
                $table->date('tanggal')->after('karyawan_id');
            }

            if (!Schema::hasColumn('absensis', 'jam_masuk')) {
                $table->time('jam_masuk')->nullable();
            }

            if (!Schema::hasColumn('absensis', 'foto_masuk')) {
                $table->string('foto_masuk')->nullable();
            }

            if (!Schema::hasColumn('absensis', 'lokasi_masuk')) {
                $table->text('lokasi_masuk')->nullable();
            }

            if (!Schema::hasColumn('absensis', 'jam_pulang')) {
                $table->time('jam_pulang')->nullable();
            }

            if (!Schema::hasColumn('absensis', 'foto_pulang')) {
                $table->string('foto_pulang')->nullable();
            }

            if (!Schema::hasColumn('absensis', 'lokasi_pulang')) {
                $table->text('lokasi_pulang')->nullable();
            }

            if (!Schema::hasColumn('absensis', 'keterangan')) {
                $table->text('keterangan')->nullable();
            }
        });
    }

    public function down(): void
    {
    }
};