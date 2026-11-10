<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokMutasi extends Model
{
    protected $table = 'stok_mutasi';

    protected $fillable = [
        'stok_bantuan_id',
        'tipe',
        'jumlah',
        'keterangan',
        'user_id',
    ];

    public function stokBantuan(): BelongsTo
    {
        return $this->belongsTo(StokBantuan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

