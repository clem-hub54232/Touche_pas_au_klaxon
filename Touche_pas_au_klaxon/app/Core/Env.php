<?php
declare(strict_types=1);
namespace App\Core;

/** Charge une configuration locale sans exposer les secrets dans Git. */
final class Env
{
    public static function load(string $file): void
    {
        if (!is_readable($file)) { return; }
        foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) { continue; }
            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            if ($key !== '' && getenv($key) === false) {
                putenv($key . '=' . trim($value, " \t\n\r\0\x0B\"'"));
            }
        }
    }
}
