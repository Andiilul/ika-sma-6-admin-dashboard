<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $appends = ['role'];

    public function getRoleAttribute(): ?string
    {
        return $this->getRoleNames()->first();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // TEMPORARY: allow all users (to confirm this is the blocker)
        // return true;

        // Recommended: restrict to admins
        return $this->hasAnyRole(['super_admin', 'admin']);
    }
}
