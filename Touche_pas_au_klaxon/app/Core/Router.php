<?php
declare(strict_types=1);
namespace App\Core;

/** Mini routeur HTTP : chemins fixes et paramètres numériques typés. */
final class Router
{
    /** @var array<int,array{method:string,regex:string,handler:callable}> */
    private array $routes = [];
    public function get(string $pattern, callable $handler): void { $this->add('GET', $pattern, $handler); }
    public function post(string $pattern, callable $handler): void { $this->add('POST', $pattern, $handler); }
    private function add(string $method, string $pattern, callable $handler): void
    {
        $regex = '#^' . preg_replace('#\{id\}#', '(?<id>[1-9][0-9]*)', $pattern) . '$#D';
        $this->routes[] = compact('method', 'regex', 'handler');
    }
    public function dispatch(string $method, string $path): void
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['regex'], $path, $matches)) {
                ($route['handler'])(isset($matches['id']) ? (int)$matches['id'] : null);
                return;
            }
        }
        http_response_code(404);
        View::render('not-found', ['title' => 'Page introuvable']);
    }
}
