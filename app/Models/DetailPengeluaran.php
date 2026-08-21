<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPengeluaran extends Model
{
    protected $table = 'detail_pengeluaran';

    protected $fillable = [
        'laporan_pengeluaran_id',
        'nama_barang',
        'nominal',
    ];

    public function laporanPengeluaran(): BelongsTo
    {
        return $this->belongsTo(LaporanPengeluaran::class);
    }
}