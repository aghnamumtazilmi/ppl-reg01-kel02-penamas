<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penyaluran extends Model
{
    protected $table = 'penyaluran';

    protected $fillable = [
        'distribusi_id',
        'tanggal_penyaluran',
        'jumlah_disalurkan',
        'keterangan',
        'foto_bukti',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_penyaluran' => 'date',
        ];
    }

    public function distribusi(): BelongsTo
    {
        return $this->belongsTo(Distribusi::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

