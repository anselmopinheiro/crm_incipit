<?php

namespace App\Support;

class Role
{
    public const ADMIN = 'admin';
    public const MANAGER = 'manager';
    public const RESELLER = 'reseller';
    public const CLIENT = 'client';

    public static function all(): array
    {
        return [
            self::ADMIN,
            self::MANAGER,
            self::RESELLER,
            self::CLIENT,
        ];
    }
}
