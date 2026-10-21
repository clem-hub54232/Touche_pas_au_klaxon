<?php
use App\Core\{Auth,Http};
$user=Auth::user();
$flash=$_SESSION['flash']??null;
unset($_SESSION['flash']);
$e=static fn(mixed $v):string=>Http::esc($v);
?>
<!doctype html>
<html lang="fr"><head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title><?= $e($title??'Accueil') ?> — Touche pas au klaxon</title>
<link rel="stylesheet" href="/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="/assets/css/app.css">
</head><body>
<div class="app-shell">
<header class="app-navbar"><div class="container py-3 d-flex align-items-center justify-content-between gap-3 flex-wrap">
<a class="app-brand fs-5" href="<?= Auth::isAdmin()?'/admin':'/' ?>">Touche pas au klaxon</a>
<nav aria-label="Navigation principale" class="d-flex align-items-center gap-2 flex-wrap">
<?php if (!$user): ?>
<a href="/connexion" class="btn btn-dark btn-sm">Connexion</a>
<?php elseif (Auth::isAdmin()): ?>
<a class="btn btn-outline-secondary btn-sm" href="/admin/utilisateurs">Utilisateurs</a>
<a class="btn btn-outline-secondary btn-sm" href="/admin/agences">Agences</a>
<a class="btn btn-outline-secondary btn-sm" href="/admin/trajets">Trajets</a>
<a class="btn btn-outline-primary btn-sm" href="/">Accueil</a>
<a class="btn btn-primary btn-sm" href="/trajets/nouveau">Créer un trajet</a>
<span class="small mx-1">Bonjour <?= $e($user['first_name'].' '.$user['last_name']) ?></span>
<form method="post" action="/deconnexion" class="d-inline"><input type="hidden" name="_csrf" value="<?= $e(Http::csrf()) ?>"><button class="btn btn-dark btn-sm">Déconnexion</button></form>
<?php else: ?>
<a class="btn btn-primary btn-sm" href="/trajets/nouveau">Créer un trajet</a>
<span class="small mx-1">Bonjour <?= $e($user['first_name'].' '.$user['last_name']) ?></span>
<form method="post" action="/deconnexion" class="d-inline"><input type="hidden" name="_csrf" value="<?= $e(Http::csrf()) ?>"><button class="btn btn-dark btn-sm">Déconnexion</button></form>
<?php endif; ?>
</nav></div></header>
<main class="app-main"><div class="container">
<?php if ($flash): ?><div class="alert alert-<?= $e(in_array($flash['kind'],['success','danger','warning','info'],true)?$flash['kind']:'info') ?>" role="status"><?= $e($flash['message']) ?></div><?php endif; ?>
<?= $content ?>
</div></main>
<footer class="app-footer py-3 text-center small">Touche pas au klaxon — &copy; <?= date('Y') ?></footer>
</div><script src="/assets/js/bootstrap.bundle.min.js"></script><script src="/assets/js/site.js"></script></body></html>
