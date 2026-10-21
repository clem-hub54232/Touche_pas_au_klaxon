<?php
declare(strict_types=1);
namespace Tests;
require_once __DIR__.'/Fakes.php';
use PHPUnit\Framework\TestCase;
use App\Services\AgencyService;
use DomainException;

/** Couverture des opérations d'écriture agences (administrateur). */
final class AgencyServiceTest extends TestCase
{
    public function testCreateAgency(): void
    {
        $agencies=new FakeAgencyStorage(); $id=(new AgencyService($agencies))->create('Toulouse');
        self::assertSame('Toulouse',$agencies->rows[$id]);
    }
    public function testRenameAgency(): void
    {
        $agencies=new FakeAgencyStorage(); (new AgencyService($agencies))->update(1,'Paris Ouest');
        self::assertSame('Paris Ouest',$agencies->rows[1]);
    }
    public function testDeleteUnusedAgency(): void
    {
        $agencies=new FakeAgencyStorage(); (new AgencyService($agencies))->delete(3);
        self::assertFalse($agencies->exists(3));
    }
    public function testRejectDuplicate(): void
    {
        $this->expectException(DomainException::class);
        (new AgencyService(new FakeAgencyStorage()))->create('paris');
    }
    public function testRejectDeletionWhenUsed(): void
    {
        $agencies=new FakeAgencyStorage(); $agencies->hasAssociatedTrips=true;
        $this->expectException(DomainException::class);
        (new AgencyService($agencies))->delete(1);
    }
}
