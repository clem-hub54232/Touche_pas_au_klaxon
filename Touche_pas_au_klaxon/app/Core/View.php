<?php
declare(strict_types=1);
namespace App\Core;
final class View
{
    /** @param array<string,mixed> $data */
    public static function render(string $name, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $path = dirname(__DIR__) . '/Views/' . $name . '.php';
        if (!is_file($path)) { throw new \RuntimeException('Vue inexistante.'); }
        ob_start();
        include $path;
        $content = (string)ob_get_clean();
        include dirname(__DIR__) . '/Views/partials/layout.php';
    }
}
