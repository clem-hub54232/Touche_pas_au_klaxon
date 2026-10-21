<?php use App\Core\Http; $e=static fn(mixed $v):string=>Http::esc($v); ?>
<div class="page-header"><h1>Gestion des agences</h1><p class="text-muted">Seul l’administrateur peut ajouter, renommer ou supprimer une agence.</p></div>
<div class="app-card p-4 mb-4"><h2 class="h5">Ajouter une agence</h2><form class="row g-2" method="post" action="/admin/agences"><input type="hidden" name="_csrf" value="<?= $e(Http::csrf()) ?>"><div class="col-lg-8"><label class="visually-hidden" for="new-name">Ville</label><input id="new-name" name="name" class="form-control" placeholder="Ville" maxlength="100" required></div><div class="col-lg-4"><button class="btn btn-primary">Ajouter</button></div></form></div>
<div class="app-card app-table table-responsive"><table class="table table-striped mb-0"><thead><tr><th>Ville</th><th>Actions</th></tr></thead><tbody>
<?php foreach($agencies as $agency):?><tr><td><?= $e($agency['name']) ?></td><td><div class="d-flex flex-wrap gap-2">
<form class="d-flex gap-2" method="post" action="/admin/agences/<?= (int)$agency['id'] ?>/modifier"><input type="hidden" name="_csrf" value="<?= $e(Http::csrf()) ?>"><label class="visually-hidden" for="agency-<?= (int)$agency['id'] ?>">Modifier la ville</label><input class="form-control form-control-sm" id="agency-<?= (int)$agency['id'] ?>" name="name" value="<?= $e($agency['name']) ?>" required maxlength="100"><button class="btn btn-outline-primary btn-sm">Enregistrer</button></form>
<form method="post" action="/admin/agences/<?= (int)$agency['id'] ?>/supprimer" data-confirm="Supprimer cette agence ?"><input type="hidden" name="_csrf" value="<?= $e(Http::csrf()) ?>"><button class="btn btn-outline-danger btn-sm">Supprimer</button></form>
</div></td></tr><?php endforeach;?>
</tbody></table></div>
