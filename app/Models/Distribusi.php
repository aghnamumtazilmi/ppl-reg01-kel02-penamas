<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Distribusi extends Model
{
    protected $table = 'distribusi';

    protected $fillable = [
        'kode',
        'periode',
        'wilayah',
        'paket_bantuan_id',
        'jumlah_penerima',
        'status',
        'catatan',
        'catatan_persetujuan',
        'dibuat_oleh',
        'disetujui_oleh',
        'tanggal_pengajuan',
        'tanggal_persetujuan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pengajuan' => 'datetime',
            'tanggal_persetujuan' => 'datetime',
        ];
    }

    public function paketBantuan(): BelongsTo
    {
        return $this->belongsTo(PaketBantuan::class);
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function penyetuju(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(DistribusiDetail::class);
    }

    public function penerima(): BelongsToMany
    {
        return $this->belongsToMany(Penerima::class, 'distribusi_detail', 'distribusi_id', 'penerima_id')->withTimestamps();
    }

    public function penyaluran(): HasMany
    {
        return $this->hasMany(Penyaluran::class);
    }

    public function realisasi(): HasOne
    {
        return $this->hasOne(Penyaluran::class)->latestOfMany();
    }

    public function petugas(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'distribusi_petugas', 'distribusi_id', 'user_id')->withTimestamps();
    }

    public static function generateKode(): string
    {
        $prefix = 'DIST-' . date('Ymd');
        $lastDist = static::where('kode', 'like', $prefix . '%')->orderBy('kode', 'desc')->first();
        if ($lastDist) {
            $lastNum = (int) substr($lastDist->kode, -4);
            return $prefix . '-' . str_pad($lastNum + 1, 4, '0', STR_PAD_LEFT);
        }
        return $prefix . '-0001';
    }
}

