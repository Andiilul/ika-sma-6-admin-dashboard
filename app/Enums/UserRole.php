<?php

namespace App\Enums;

enum UserRole: int
{
    case SuperAdmin = 1;
    case Admin = 2;

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::Admin => 'Admin',
        };
    }
}