<?php
// Réécriture des URL pour le serveur de développement PHP intégré.
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $path;
if ($path !== '/' && is_file($file)) { return false; }
require __DIR__ . '/index.php';
