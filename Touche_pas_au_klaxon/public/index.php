<?php
declare(strict_types=1);
use App\Core\{Env,Router,Database};
use App\Controllers\{AuthController,TripController,AdminController};

spl_autoload_register(static function(string $class): void {
    if (!str_starts_with($class, 'App\\')) { return; }
    $path = dirname(__DIR__) . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (is_file($path)) { require $path; }
});
Env::load(dirname(__DIR__) . '/.env');
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
session_name('klaxon_session');
session_set_cookie_params(['lifetime'=>0, 'path'=>'/', 'secure'=>((getenv('SESSION_SECURE') === 'true') || $isHttps), 'httponly'=>true, 'samesite'=>'Lax']);
session_start();
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: same-origin');
header('Content-Security-Policy: default-src \'self\'; script-src \'self\'; style-src \'self\'; img-src \'self\' data:; object-src \'none\'; base-uri \'self\'; frame-ancestors \'none\'');
$router = new Router();
$auth = new AuthController();
$trips = new TripController();
$admin = new AdminController();
$router->get('/', fn()=> $trips->index());
$router->get('/connexion', fn()=> $auth->form());
$router->post('/connexion', fn()=> $auth->login());
$router->post('/deconnexion', fn()=> $auth->logout());
$router->get('/trajets/nouveau', fn()=> $trips->new());
$router->post('/trajets', fn()=> $trips->create());
$router->get('/trajets/{id}/modifier', fn($id)=> $trips->edit($id));
$router->post('/trajets/{id}/modifier', fn($id)=> $trips->update($id));
$router->post('/trajets/{id}/supprimer', fn($id)=> $trips->delete($id));
$router->get('/admin', fn()=> $admin->dashboard());
$router->get('/admin/utilisateurs', fn()=> $admin->users());
$router->get('/admin/trajets', fn()=> $admin->trips());
$router->get('/admin/agences', fn()=> $admin->agencies());
$router->post('/admin/agences', fn()=> $admin->addAgency());
$router->post('/admin/agences/{id}/modifier', fn($id)=> $admin->updateAgency($id));
$router->post('/admin/agences/{id}/supprimer', fn($id)=> $admin->deleteAgency($id));
try {
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $path = (string)(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
    $router->dispatch($method, $path);
} catch (Throwable $e) {
    error_log((string)$e);
    http_response_code(500);
    App\Core\View::render('error', ['title'=>'Erreur interne', 'code'=>500]);
}
