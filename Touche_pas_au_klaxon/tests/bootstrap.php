<?php
declare(strict_types=1);
spl_autoload_register(static function(string $class): void {
    if (!str_starts_with($class,'App\\')) { return; }
    $path=dirname(__DIR__).'/app/'.str_replace('\\','/',substr($class,4)).'.php';
    if (is_file($path)) { require $path; }
});
