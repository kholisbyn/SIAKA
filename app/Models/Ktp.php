<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ktp extends Model
{
    protected $table = 'ktps';

    protected $fillable = [
        'karyawan_id',
        'nomor_ktp',
        'foto_ktp',
        'status',
    ];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'id');
    }
}