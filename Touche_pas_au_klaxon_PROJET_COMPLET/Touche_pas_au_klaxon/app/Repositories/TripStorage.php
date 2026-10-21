<?php
declare(strict_types=1);
namespace App\Repositories;
interface TripStorage
{
    /** @return array<string,mixed>|null */
    public function find(int $id): ?array;
    /** @param array<string,mixed> $data */
    public function create(array $data): int;
    /** @param array<string,mixed> $data */
    public function update(int $id, array $data): void;
    public function delete(int $id): void;
}
