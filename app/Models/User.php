<?php

namespace App\Models;

use App\Enums\UserRole;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',        // auto-hash
        'role' => UserRole::class,     // enum cast (int <-> enum)
        'is_active' => 'boolean',
    ];

    public function isSuperAdmin(): bool
    {
        return $this->role === UserRole::SuperAdmin;
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    /**
     * Siapa yang boleh login ke Filament panel.
     * Superadmin & admin boleh, asal akun aktif.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_active && ($this->isSuperAdmin() || $this->isAdmin());
    }

    /**
     * Opsional: nama yang tampil di UI Filament.
     */
    public function getFilamentName(): string
    {
        return $this->name;
    }
}
