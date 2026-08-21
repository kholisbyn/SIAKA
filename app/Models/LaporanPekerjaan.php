<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanPekerjaan extends Model
{
    protected $table = 'laporan_pekerjaan';

    protected $fillable = [
        'user_id',
        'isi_laporan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}