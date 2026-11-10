<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerima extends Model
{
    protected $table = 'penerima';

    protected $fillable = [
        'nik',
        'nama',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'no_hp',
        'status',
    ];

    public function detailDistribusi()
    {
        return $this->hasMany(DistribusiDetail::class);
    }

    public function distribusi()
    {
        return $this->belongsToMany(Distribusi::class, 'distribusi_detail', 'penerima_id', 'distribusi_id')->withTimestamps();
    }
}

