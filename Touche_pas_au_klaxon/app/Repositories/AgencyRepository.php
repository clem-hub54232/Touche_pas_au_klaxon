<?php
declare(strict_types=1);
namespace App\Repositories;
use App\Core\Database;
use PDO;

/** Requêtes CRUD des agences, réservées à l'administrateur côté contrôleur. */
final class AgencyRepository implements AgencyStorage
{
    private PDO $pdo;
    public function __construct(?PDO $pdo=null) { $this->pdo = $pdo ?? Database::connection(); }
    /** @return list<array<string,mixed>> */
    public function all(): array { return $this->pdo->query('SELECT id,name FROM agencies ORDER BY name ASC')->fetchAll(); }
    public function exists(int $id): bool
    {
        $q=$this->pdo->prepare('SELECT COUNT(*) FROM agencies WHERE id=?'); $q->execute([$id]); return (int)$q->fetchColumn()>0;
    }
    public function nameExists(string $name, ?int $ignoreId=null): bool
    {
        $q=$this->pdo->prepare('SELECT COUNT(*) FROM agencies WHERE LOWER(name)=LOWER(?) AND (? IS NULL OR id<>?)');
        $q->execute([$name,$ignoreId,$ignoreId]); return (int)$q->fetchColumn()>0;
    }
    public function create(string $name): int
    {
        $q=$this->pdo->prepare('INSERT INTO agencies(name) VALUES(?)'); $q->execute([$name]); return (int)$this->pdo->lastInsertId();
    }
    public function update(int $id,string $name): void
    {
        $q=$this->pdo->prepare('UPDATE agencies SET name=? WHERE id=?'); $q->execute([$name,$id]);
    }
    public function delete(int $id): void
    {
        $q=$this->pdo->prepare('DELETE FROM agencies WHERE id=?'); $q->execute([$id]);
    }
    public function hasTrips(int $id): bool
    {
        $q=$this->pdo->prepare('SELECT COUNT(*) FROM trips WHERE departure_agency_id=? OR arrival_agency_id=?');
        $q->execute([$id,$id]); return (int)$q->fetchColumn()>0;
    }
}
