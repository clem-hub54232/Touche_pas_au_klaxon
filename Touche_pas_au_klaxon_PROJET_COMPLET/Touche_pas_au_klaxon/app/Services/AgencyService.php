<?php
declare(strict_types=1);
namespace App\Services;
use App\Repositories\AgencyStorage;
use DomainException;

/** Gestion des agences avec contrôle des doublons et des dépendances trajets. */
final class AgencyService
{
    public function __construct(private AgencyStorage $agencies) {}
    public function create(string $name): int
    {
        $name=$this->validate($name);
        if ($this->agencies->nameExists($name)) { throw new DomainException('Cette agence existe déjà.'); }
        return $this->agencies->create($name);
    }
    public function update(int $id,string $name): void
    {
        if (!$this->agencies->exists($id)) { throw new DomainException('Agence introuvable.'); }
        $name=$this->validate($name);
        if ($this->agencies->nameExists($name,$id)) { throw new DomainException('Cette agence existe déjà.'); }
        $this->agencies->update($id,$name);
    }
    public function delete(int $id): void
    {
        if (!$this->agencies->exists($id)) { throw new DomainException('Agence introuvable.'); }
        if ($this->agencies->hasTrips($id)) { throw new DomainException('Agence utilisée par des trajets : suppression impossible.'); }
        $this->agencies->delete($id);
    }
    private function validate(string $name): string
    {
        $name=trim($name);
        if ($name==='' || strlen($name)>100 || preg_match('/[<>]/',$name)) { throw new DomainException('Nom d’agence invalide (1 à 100 caractères).'); }
        return $name;
    }
}
