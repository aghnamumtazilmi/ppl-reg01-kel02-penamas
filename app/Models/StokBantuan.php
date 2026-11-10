<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StokBantuan extends Model
{
    protected $table = 'stok_bantuan';

    protected $fillable = [
        'nama_barang',
        'satuan',
        'jumlah',
    ];

    public function mutasi(): HasMany
    {
        return $this->hasMany(StokMutasi::class);
    }
}

