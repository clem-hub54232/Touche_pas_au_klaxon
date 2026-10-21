<?php
declare(strict_types=1);
namespace App\Core;
final class Auth
{
    /** @return array<string,mixed>|null */
    public static function user(): ?array { return $_SESSION['user'] ?? null; }
    public static function id(): ?int { return isset($_SESSION['user']['id']) ? (int)$_SESSION['user']['id'] : null; }
    public static function isAdmin(): bool { return ($_SESSION['user']['role'] ?? '') === 'admin'; }
    public static function requireUser(): void { if (!self::user()) { Http::flash('warning', 'Veuillez vous connecter.'); Http::redirect('/connexion'); } }
    public static function requireAdmin(): void { self::requireUser(); if (!self::isAdmin()) { Http::abort(403); } }
}
