<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaketBantuan extends Model
{
    protected $table = 'paket_bantuan';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    public function komponen(): HasMany
    {
        return $this->hasMany(KomponenBantuan::class);
    }

    public function distribusi(): HasMany
    {
        return $this->hasMany(Distribusi::class);
    }
}

