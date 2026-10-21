<?php
declare(strict_types=1);
namespace App\Repositories;
use App\Core\Database;
use PDO;

/** Employés importés du SI RH : consultation et authentification uniquement. */
final class UserRepository
{
    private PDO $pdo;
    public function __construct(?PDO $pdo=null) { $this->pdo=$pdo ?? Database::connection(); }
    public function byEmail(string $email): ?array
    {
        $q=$this->pdo->prepare('SELECT id,last_name,first_name,phone,email,password_hash,role FROM users WHERE email=?');
        $q->execute([$email]); return $q->fetch() ?: null;
    }
    /** @return list<array<string,mixed>> */
    public function all(): array
    {
        return $this->pdo->query('SELECT id,last_name,first_name,phone,email,role FROM users ORDER BY last_name,first_name')->fetchAll();
    }
}
