<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\{Auth,Http,View};
use App\Repositories\{TripRepository,AgencyRepository};
use App\Services\TripService;
use DomainException;

/** Affichage public et CRUD de trajets. */
final class TripController
{
    public function index(): void
    {
        $trips=(new TripRepository())->available();
        View::render('trips/index',['title'=>'Trajets proposés','trips'=>$trips]);
    }
    public function new(): void
    {
        Auth::requireUser();
        View::render('trips/form',['title'=>'Créer un trajet','trip'=>null,'agencies'=>(new AgencyRepository())->all()]);
    }
    public function edit(int $id): void
    {
        Auth::requireUser();
        $trip=(new TripRepository())->find($id);
        if (!$trip) { Http::abort(404); }
        if (!Auth::isAdmin() && (int)$trip['owner_id']!==Auth::id()) { Http::abort(403); }
        View::render('trips/form',['title'=>'Modifier un trajet','trip'=>$trip,'agencies'=>(new AgencyRepository())->all()]);
    }
    public function create(): void
    {
        Auth::requireUser(); Http::verifyCsrf();
        try {
            $id=$this->service()->create($_POST,Auth::user());
            Http::flash('success','Le trajet n°'.$id.' a été créé.'); Http::redirect('/');
        } catch (DomainException $e) {
            Http::flash('danger',$e->getMessage()); Http::redirect('/trajets/nouveau');
        }
    }
    public function update(int $id): void
    {
        Auth::requireUser(); Http::verifyCsrf();
        try {
            $this->service()->update($id,$_POST,Auth::user());
            Http::flash('success','Le trajet n°'.$id.' a été modifié.'); Http::redirect(Auth::isAdmin()?'/admin/trajets':'/');
        } catch (DomainException $e) {
            Http::flash('danger',$e->getMessage()); Http::redirect('/trajets/'.$id.'/modifier');
        }
    }
    public function delete(int $id): void
    {
        Auth::requireUser(); Http::verifyCsrf();
        try {
            $this->service()->delete($id,Auth::user());
            Http::flash('success','Le trajet n°'.$id.' a été supprimé.'); Http::redirect(Auth::isAdmin()?'/admin/trajets':'/');
        } catch (DomainException $e) {
            Http::flash('danger',$e->getMessage()); Http::redirect(Auth::isAdmin()?'/admin/trajets':'/');
        }
    }
    private function service(): TripService { return new TripService(new TripRepository(),new AgencyRepository()); }
}
