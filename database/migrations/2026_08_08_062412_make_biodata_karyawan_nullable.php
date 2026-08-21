<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->string('nik')->nullable()->change();
            $table->string('tempat_lahir')->nullable()->change();
            $table->date('tanggal_lahir')->nullable()->change();
            $table->string('jenis_kelamin')->nullable()->change();
            $table->decimal('basic_gaji', 15, 2)->nullable()->change();
            $table->string('no_hp')->nullable()->change();
            $table->text('alamat')->nullable()->change();
            $table->string('foto')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->string('nik')->nullable(false)->change();
            $table->string('tempat_lahir')->nullable(false)->change();
            $table->date('tanggal_lahir')->nullable(false)->change();
            $table->string('jenis_kelamin')->nullable(false)->change();
            $table->decimal('basic_gaji', 15, 2)->nullable(false)->change();
            $table->string('no_hp')->nullable(false)->change();
            $table->text('alamat')->nullable(false)->change();
            $table->string('foto')->nullable()->change();
        });
    }
};