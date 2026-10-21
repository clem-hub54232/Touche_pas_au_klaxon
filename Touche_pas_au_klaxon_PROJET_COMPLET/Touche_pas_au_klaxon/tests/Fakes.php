<?php
declare(strict_types=1);
namespace Tests;
use App\Repositories\{TripStorage,AgencyStorage};

/** Doubles en mémoire pour tester les écritures métier sans base MySQL. */
final class FakeTripStorage implements TripStorage
{
    /** @var array<int,array<string,mixed>> */
    public array $rows=[];
    public function find(int $id): ?array { return $this->rows[$id]??null; }
    public function create(array $data): int { $id=count($this->rows)+1; $this->rows[$id]=$data+['id'=>$id]; return $id; }
    public function update(int $id,array $data): void { $this->rows[$id]=array_merge($this->rows[$id],$data); }
    public function delete(int $id): void { unset($this->rows[$id]); }
}
final class FakeAgencyStorage implements AgencyStorage
{
    /** @var array<int,string> */
    public array $rows=[1=>'Paris',2=>'Lyon',3=>'Nice'];
    public bool $hasAssociatedTrips=false;
    public function exists(int $id): bool { return isset($this->rows[$id]); }
    public function nameExists(string $name,?int $ignoreId=null): bool
    {
        foreach ($this->rows as $id=>$v) { if ($id!==$ignoreId && strtolower($v)===strtolower($name)) return true; }
        return false;
    }
    public function create(string $name): int { $id=max(array_keys($this->rows))+1; $this->rows[$id]=$name; return $id; }
    public function update(int $id,string $name): void { $this->rows[$id]=$name; }
    public function delete(int $id): void { unset($this->rows[$id]); }
    public function hasTrips(int $id): bool { return $this->hasAssociatedTrips; }
}
