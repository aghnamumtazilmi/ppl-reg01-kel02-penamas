<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ─── Role Helpers ──────────────────────────────────────────

    public function isPimpinan(): bool
    {
        return $this->role === 'pimpinan';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function canManage(): bool
    {
        return $this->hasRole('pimpinan', 'admin');
    }

    // ─── Relationships ─────────────────────────────────────────

    public function distribusiBuatan()
    {
        return $this->hasMany(Distribusi::class, 'dibuat_oleh');
    }

    public function distribusiDisetujui()
    {
        return $this->hasMany(Distribusi::class, 'disetujui_oleh');
    }

    public function penyaluran()
    {
        return $this->hasMany(Penyaluran::class);
    }

    public function stokMutasi()
    {
        return $this->hasMany(StokMutasi::class);
    }

    public function distribusiDitugaskan()
    {
        return $this->belongsToMany(Distribusi::class, 'distribusi_petugas', 'user_id', 'distribusi_id')->withTimestamps();
    }
}
