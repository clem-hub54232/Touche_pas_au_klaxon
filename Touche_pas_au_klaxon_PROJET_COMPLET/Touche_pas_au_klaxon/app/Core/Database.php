<?php
declare(strict_types=1);
namespace App\Core;
use PDO;
use PDOException;
use RuntimeException;

/** Fournit une connexion PDO MySQL unique avec requêtes préparées. */
final class Database
{
    private static ?PDO $pdo = null;
    public static function connection(): PDO
    {
        if (self::$pdo !== null) { return self::$pdo; }
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $port = getenv('DB_PORT') ?: '3306';
        $name = getenv('DB_NAME') ?: 'touche_pas_au_klaxon';
        $user = getenv('DB_USER') ?: 'root';
        $password = getenv('DB_PASSWORD') ?: '';
        if (!extension_loaded('pdo_mysql')) { throw new RuntimeException('Extension PHP pdo_mysql manquante.'); }
        try {
            self::$pdo = new PDO("mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4", $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            return self::$pdo;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new RuntimeException('Connexion à la base de données indisponible.');
        }
    }
}
