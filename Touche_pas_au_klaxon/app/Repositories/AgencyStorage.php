<?php
declare(strict_types=1);
namespace App\Repositories;
interface AgencyStorage
{
    public function exists(int $id): bool;
    public function nameExists(string $name, ?int $ignoreId = null): bool;
    public function create(string $name): int;
    public function update(int $id, string $name): void;
    public function delete(int $id): void;
    public function hasTrips(int $id): bool;
}
