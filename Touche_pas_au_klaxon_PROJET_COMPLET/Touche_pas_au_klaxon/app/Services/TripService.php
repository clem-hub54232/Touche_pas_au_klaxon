<?php
declare(strict_types=1);
namespace App\Services;
use App\Repositories\{TripStorage,AgencyStorage};
use DomainException;

/** Encapsule les règles d'écriture : validation, auteur, droits et agences. */
final class TripService
{
    public function __construct(private TripStorage $trips, private AgencyStorage $agencies) {}
    /** @param array<string,mixed> $input
     *  @param array<string,mixed> $actor
     */
    public function create(array $input, array $actor): int
    {
        $data=$this->validated($input);
        $data['owner_id']=(int)$actor['id'];
        return $this->trips->create($data);
    }
    /** @param array<string,mixed> $input
     *  @param array<string,mixed> $actor
     */
    public function update(int $id,array $input,array $actor): void
    {
        $this->authorized($id,$actor);
        $this->trips->update($id,$this->validated($input));
    }
    /** @param array<string,mixed> $actor */
    public function delete(int $id,array $actor): void
    {
        $this->authorized($id,$actor);
        $this->trips->delete($id);
    }
    /** @param array<string,mixed> $input
     *  @return array<string,int|string>
     */
    private function validated(array $input): array
    {
        $errors=TripValidator::errors($input);
        if ($errors!==[]) { throw new DomainException(implode(' ',array_values($errors))); }
        $data=TripValidator::normalize($input);
        if (!$this->agencies->exists((int)$data['departure_agency_id']) || !$this->agencies->exists((int)$data['arrival_agency_id'])) {
            throw new DomainException('Agence inconnue.');
        }
        return $data;
    }
    /** @param array<string,mixed> $actor */
    private function authorized(int $id,array $actor): void
    {
        $trip=$this->trips->find($id);
        if (!$trip) { throw new DomainException('Trajet introuvable.'); }
        if ($actor['role']!=='admin' && (int)$trip['owner_id']!==(int)$actor['id']) { throw new DomainException('Action interdite sur ce trajet.'); }
    }
}
