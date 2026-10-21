<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\{Auth,Http,View};
use App\Repositories\UserRepository;

/** Connexion d'employés RH (aucune création de compte via le site). */
final class AuthController
{
    public function form(): void
    {
        if (Auth::user()) { Http::redirect('/'); }
        View::render('auth/login', ['title'=>'Connexion']);
    }
    public function login(): void
    {
        Http::verifyCsrf();
        $attempts=$_SESSION['login_attempts']??[];
        $attempts=array_values(array_filter($attempts, static fn($t) => (int)$t>time()-900));
        if (count($attempts)>=5) { Http::flash('danger','Trop de tentatives : réessayez dans 15 minutes.'); Http::redirect('/connexion'); }
        $email=strtolower(trim((string)($_POST['email']??'')));
        $password=(string)($_POST['password']??'');
        $user=filter_var($email,FILTER_VALIDATE_EMAIL) ? (new UserRepository())->byEmail($email) : null;
        if (!$user || !password_verify($password,(string)$user['password_hash'])) {
            $attempts[]=time(); $_SESSION['login_attempts']=$attempts;
            Http::flash('danger','Identifiants invalides.'); Http::redirect('/connexion');
        }
        session_regenerate_id(true);
        unset($user['password_hash'],$_SESSION['login_attempts']);
        $_SESSION['user']=$user;
        Http::flash('success','Connexion réussie. Bienvenue ' . $user['first_name'] . ' !');
        Http::redirect(Auth::isAdmin()?'/admin':'/');
    }
    public function logout(): void
    {
        Auth::requireUser(); Http::verifyCsrf();
        $_SESSION=[]; session_regenerate_id(true);
        Http::flash('success','Vous êtes déconnecté.'); Http::redirect('/');
    }
}
