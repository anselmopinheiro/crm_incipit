<?php

namespace App\Support;

class Uuid
{
    public static function v7(): string
    {
        $timestamp = (int) floor(microtime(true) * 1000);
        $timeBytes = '';
        for ($i = 5; $i >= 0; $i--) {
            $timeBytes = chr($timestamp & 0xff) . $timeBytes;
            $timestamp >>= 8;
        }

        $randomBytes = random_bytes(10);
        $bytes = $timeBytes . $randomBytes;
        $bytes[6] = chr((ord($bytes[6]) & 0x0f) | 0x70);
        $bytes[8] = chr((ord($bytes[8]) & 0x3f) | 0x80);

        $hex = bin2hex($bytes);

        return sprintf(
            '%s-%s-%s-%s-%s',
            substr($hex, 0, 8),
            substr($hex, 8, 4),
            substr($hex, 12, 4),
            substr($hex, 16, 4),
            substr($hex, 20, 12)
        );
    }
}
