<?php
declare(strict_types=1);
namespace Tests;
require_once __DIR__.'/Fakes.php';
use PHPUnit\Framework\TestCase;
use App\Services\TripService;
use DomainException;

/** Couverture des opérations d'écriture des trajets : CRUD, validation, propriété. */
final class TripServiceTest extends TestCase
{
    /** @return array<string,mixed> */
    private function input(): array {
        return ['departure_agency_id'=>1,'arrival_agency_id'=>2,
            'departure_at'=>(new \DateTimeImmutable('+3 days'))->format('Y-m-d\TH:i'),
            'arrival_at'=>(new \DateTimeImmutable('+3 days +2 hours'))->format('Y-m-d\TH:i'),
            'seats_total'=>4,'seats_available'=>3];
    }
    public function testCreateStoresOwnerAndSeats(): void
    {
        $trips=new FakeTripStorage(); $svc=new TripService($trips,new FakeAgencyStorage());
        $id=$svc->create($this->input(),['id'=>7,'role'=>'user']);
        self::assertSame(7,$trips->rows[$id]['owner_id']);
        self::assertSame(3,$trips->rows[$id]['seats_available']);
    }
    public function testUpdateByOwner(): void
    {
        $trips=new FakeTripStorage(); $svc=new TripService($trips,new FakeAgencyStorage());
        $id=$svc->create($this->input(),['id'=>7,'role'=>'user']);
        $input=$this->input(); $input['seats_available']=1;
        $svc->update($id,$input,['id'=>7,'role'=>'user']);
        self::assertSame(1,$trips->rows[$id]['seats_available']);
    }
    public function testAnotherUserCannotDelete(): void
    {
        $trips=new FakeTripStorage(); $svc=new TripService($trips,new FakeAgencyStorage());
        $id=$svc->create($this->input(),['id'=>7,'role'=>'user']);
        $this->expectException(DomainException::class);
        $svc->delete($id,['id'=>8,'role'=>'user']);
    }
    public function testAdminCanDeleteOtherUserTrip(): void
    {
        $trips=new FakeTripStorage(); $svc=new TripService($trips,new FakeAgencyStorage());
        $id=$svc->create($this->input(),['id'=>7,'role'=>'user']);
        $svc->delete($id,['id'=>8,'role'=>'admin']);
        self::assertNull($trips->find($id));
    }
    public function testRejectsSameAgency(): void
    {
        $svc=new TripService(new FakeTripStorage(),new FakeAgencyStorage());
        $input=$this->input();$input['arrival_agency_id']=1;
        $this->expectException(DomainException::class);
        $svc->create($input,['id'=>7,'role'=>'user']);
    }
    public function testRejectsOverbooking(): void
    {
        $svc=new TripService(new FakeTripStorage(),new FakeAgencyStorage());
        $input=$this->input();$input['seats_available']=7;
        $this->expectException(DomainException::class);
        $svc->create($input,['id'=>7,'role'=>'user']);
    }
}
