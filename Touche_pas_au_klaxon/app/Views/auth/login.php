<?php use App\Core\Http; ?>
<div class="row justify-content-center"><div class="col-lg-5 col-md-7"><div class="app-card p-4 p-lg-5">
<h1 class="h3 mb-3">Connexion</h1><p class="text-muted">Réservé aux employés de l’entreprise.</p>
<form method="post" action="/connexion"><input type="hidden" name="_csrf" value="<?= Http::esc(Http::csrf()) ?>">
<div class="mb-3"><label class="form-label" for="email">Adresse e-mail professionnelle</label><input id="email" name="email" type="email" class="form-control" autocomplete="username" required maxlength="190"></div>
<div class="mb-4"><label class="form-label" for="password">Mot de passe</label><input id="password" name="password" type="password" class="form-control" autocomplete="current-password" required></div>
<button class="btn btn-primary w-100">Se connecter</button></form>
</div></div></div>
