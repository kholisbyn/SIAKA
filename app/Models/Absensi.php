<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'jam_masuk',
        'foto_masuk',
        'lokasi_masuk',
        'latitude_masuk',
        'longitude_masuk',
        'jam_pulang',
        'foto_pulang',
        'lokasi_pulang',
        'latitude_pulang',
        'longitude_pulang',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}