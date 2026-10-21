<?php
declare(strict_types=1);
namespace App\Core;
final class Http
{
    public static function redirect(string $path): never { header('Location: ' . $path, true, 303); exit; }
    public static function flash(string $kind, string $message): void { $_SESSION['flash'] = ['kind' => $kind, 'message' => $message]; }
    public static function abort(int $code = 403): never { http_response_code($code); View::render('error', ['title' => 'Accès refusé', 'code' => $code]); exit; }
    public static function csrf(): string
    {
        if (!isset($_SESSION['csrf'])) { $_SESSION['csrf'] = bin2hex(random_bytes(32)); }
        return (string)$_SESSION['csrf'];
    }
    public static function verifyCsrf(): void
    {
        if (!hash_equals(self::csrf(), (string)($_POST['_csrf'] ?? ''))) { self::abort(419); }
    }
    public static function esc(mixed $value): string { return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
}
