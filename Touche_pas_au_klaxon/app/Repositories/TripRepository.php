<?php
declare(strict_types=1);
namespace App\Repositories;
use App\Core\Database;
use PDO;

/** Centralise les lectures et les écritures SQL sur les trajets. */
final class TripRepository implements TripStorage
{
    private PDO $pdo;
    public function __construct(?PDO $pdo = null) { $this->pdo = $pdo ?? Database::connection(); }

    /** @return list<array<string,mixed>> */
    public function available(): array
    {
        $q = $this->pdo->query("SELECT t.*, d.name AS departure_name, a.name AS arrival_name,
            u.first_name, u.last_name, u.email, u.phone FROM trips t
            JOIN agencies d ON d.id=t.departure_agency_id JOIN agencies a ON a.id=t.arrival_agency_id
            JOIN users u ON u.id=t.owner_id
            WHERE t.departure_at >= NOW() AND t.seats_available > 0 ORDER BY t.departure_at ASC, t.id ASC");
        return $q->fetchAll();
    }

    /** @return list<array<string,mixed>> */
    public function all(): array
    {
        return $this->pdo->query("SELECT t.*, d.name AS departure_name, a.name AS arrival_name,
            u.first_name, u.last_name, u.email, u.phone FROM trips t
            JOIN agencies d ON d.id=t.departure_agency_id JOIN agencies a ON a.id=t.arrival_agency_id
            JOIN users u ON u.id=t.owner_id ORDER BY t.departure_at DESC, t.id DESC")->fetchAll();
    }
    public function find(int $id): ?array
    {
        $q = $this->pdo->prepare('SELECT * FROM trips WHERE id=?');
        $q->execute([$id]);
        return $q->fetch() ?: null;
    }
    public function create(array $data): int
    {
        $q = $this->pdo->prepare('INSERT INTO trips (departure_agency_id,arrival_agency_id,departure_at,arrival_at,seats_total,seats_available,owner_id)
            VALUES (:dep,:arr,:start,:end,:total,:available,:owner)');
        $q->execute(['dep'=>$data['departure_agency_id'], 'arr'=>$data['arrival_agency_id'],
            'start'=>$data['departure_at'], 'end'=>$data['arrival_at'], 'total'=>$data['seats_total'],
            'available'=>$data['seats_available'], 'owner'=>$data['owner_id']]);
        return (int)$this->pdo->lastInsertId();
    }
    public function update(int $id, array $data): void
    {
        $q = $this->pdo->prepare('UPDATE trips SET departure_agency_id=:dep,arrival_agency_id=:arr,
            departure_at=:start,arrival_at=:end,seats_total=:total,seats_available=:available WHERE id=:id');
        $q->execute(['dep'=>$data['departure_agency_id'], 'arr'=>$data['arrival_agency_id'],
            'start'=>$data['departure_at'], 'end'=>$data['arrival_at'], 'total'=>$data['seats_total'],
            'available'=>$data['seats_available'], 'id'=>$id]);
    }
    public function delete(int $id): void
    {
        $q = $this->pdo->prepare('DELETE FROM trips WHERE id=?');
        $q->execute([$id]);
    }
}
