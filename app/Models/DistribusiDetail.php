<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistribusiDetail extends Model
{
    protected $table = 'distribusi_detail';

    protected $fillable = [
        'distribusi_id',
        'penerima_id',
    ];

    public function distribusi(): BelongsTo
    {
        return $this->belongsTo(Distribusi::class);
    }

    public function penerima(): BelongsTo
    {
        return $this->belongsTo(Penerima::class);
    }
}

