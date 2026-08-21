<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatans';

    protected $fillable = [
        'nama',
        'jabatan',
        'nama_pt',
    ];

    public function karyawans()
    {
        return $this->hasMany(Karyawan::class, 'jabatan_id', 'id');
    }
}