<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('nik')->unique();

            $table->string('nama');

            $table->string('tempat_lahir');

            $table->date('tanggal_lahir');

            $table->enum('jenis_kelamin',['Laki-laki','Perempuan']);

            $table->string('jabatan');

            $table->decimal('basic_gaji',15,2)->default(0);

            $table->string('no_hp');

            $table->text('alamat');

            $table->string('foto')->nullable();

            $table->enum('status',['Aktif','Nonaktif'])->default('Aktif');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};