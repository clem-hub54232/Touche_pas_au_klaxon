<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\{Auth,Http,View};
use App\Repositories\{AgencyRepository,TripRepository,UserRepository};
use App\Services\AgencyService;
use DomainException;

/** Gestion réservée aux administrateurs ; aucune écriture sur les employés RH. */
final class AdminController
{
    public function dashboard(): void
    {
        Auth::requireAdmin();
        View::render('admin/dashboard',['title'=>'Tableau de bord']);
    }
    public function users(): void
    {
        Auth::requireAdmin();
        View::render('admin/users',['title'=>'Employés','users'=>(new UserRepository())->all()]);
    }
    public function trips(): void
    {
        Auth::requireAdmin();
        View::render('admin/trips',['title'=>'Tous les trajets','trips'=>(new TripRepository())->all()]);
    }
    public function agencies(): void
    {
        Auth::requireAdmin();
        View::render('admin/agencies',['title'=>'Agences','agencies'=>(new AgencyRepository())->all()]);
    }
    public function addAgency(): void
    {
        Auth::requireAdmin(); Http::verifyCsrf();
        try { (new AgencyService(new AgencyRepository()))->create((string)($_POST['name']??'')); Http::flash('success','Agence créée.'); }
        catch (DomainException $e) { Http::flash('danger',$e->getMessage()); }
        Http::redirect('/admin/agences');
    }
    public function updateAgency(int $id): void
    {
        Auth::requireAdmin(); Http::verifyCsrf();
        try { (new AgencyService(new AgencyRepository()))->update($id,(string)($_POST['name']??'')); Http::flash('success','Agence modifiée.'); }
        catch (DomainException $e) { Http::flash('danger',$e->getMessage()); }
        Http::redirect('/admin/agences');
    }
    public function deleteAgency(int $id): void
    {
        Auth::requireAdmin(); Http::verifyCsrf();
        try { (new AgencyService(new AgencyRepository()))->delete($id); Http::flash('success','Agence supprimée.'); }
        catch (DomainException $e) { Http::flash('danger',$e->getMessage()); }
        Http::redirect('/admin/agences');
    }
}
