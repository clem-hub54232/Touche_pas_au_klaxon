<?php
declare(strict_types=1);
namespace App\Services;
use DateTimeImmutable;
use DateTimeZone;

/** Validations métier réutilisables pour création et modification d'un trajet. */
final class TripValidator
{
    /** @param array<string,mixed> $input
     *  @return array<string,string> tableau des erreurs par champ
     */
    public static function errors(array $input): array
    {
        $errors=[];
        $dep = filter_var($input['departure_agency_id'] ?? null, FILTER_VALIDATE_INT);
        $arr = filter_var($input['arrival_agency_id'] ?? null, FILTER_VALIDATE_INT);
        if ($dep === false || $dep === null || $dep < 1) { $errors['departure_agency_id']='Départ invalide.'; }
        if ($arr === false || $arr === null || $arr < 1) { $errors['arrival_agency_id']='Destination invalide.'; }
        if (!isset($errors['departure_agency_id']) && !isset($errors['arrival_agency_id']) && $dep === $arr) {
            $errors['arrival_agency_id']='Les agences doivent être différentes.';
        }
        $start=self::parse((string)($input['departure_at']??''));
        $end=self::parse((string)($input['arrival_at']??''));
        if ($start===null) { $errors['departure_at']='Date/heure de départ incorrecte.'; }
        elseif ($start<=new DateTimeImmutable('now', new DateTimeZone(date_default_timezone_get()))) { $errors['departure_at']='Le départ doit être dans le futur.'; }
        if ($end===null) { $errors['arrival_at']='Date/heure d’arrivée incorrecte.'; }
        elseif ($start!==null && $end<=$start) { $errors['arrival_at']='L’arrivée doit être après le départ.'; }
        $total=filter_var($input['seats_total']??null, FILTER_VALIDATE_INT);
        $available=filter_var($input['seats_available']??null, FILTER_VALIDATE_INT);
        if ($total===false || $total===null || $total<1 || $total>8) { $errors['seats_total']='Entre 1 et 8 places.'; }
        if ($available===false || $available===null || $available<0 || $available>8 || ($total!==false && $total!==null && $available>$total)) {
            $errors['seats_available']='Les places disponibles doivent être entre 0 et le total.';
        }
        return $errors;
    }
    public static function parse(string $raw): ?DateTimeImmutable
    {
        $raw=trim($raw);
        foreach (['!Y-m-d\TH:i','!Y-m-d H:i:s'] as $format) {
            $date=DateTimeImmutable::createFromFormat($format, $raw);
            if ($date && $date->format($format==='!Y-m-d\TH:i'?'Y-m-d\TH:i':'Y-m-d H:i:s')===$raw) { return $date; }
        }
        return null;
    }
    /** @param array<string,mixed> $input
     *  @return array<string,int|string>
     */
    public static function normalize(array $input): array
    {
        return ['departure_agency_id'=>(int)$input['departure_agency_id'], 'arrival_agency_id'=>(int)$input['arrival_agency_id'],
            'departure_at'=>self::parse((string)$input['departure_at'])->format('Y-m-d H:i:s'),
            'arrival_at'=>self::parse((string)$input['arrival_at'])->format('Y-m-d H:i:s'),
            'seats_total'=>(int)$input['seats_total'], 'seats_available'=>(int)$input['seats_available']];
    }
}
