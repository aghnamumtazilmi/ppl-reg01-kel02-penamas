<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KomponenBantuan extends Model
{
    protected $table = 'komponen_bantuan';

    protected $fillable = [
        'paket_bantuan_id',
        'nama_barang',
        'satuan',
        'jumlah',
    ];

    public function paketBantuan(): BelongsTo
    {
        return $this->belongsTo(PaketBantuan::class);
    }
}

