<?php use App\Core\Http; $e=static fn(mixed $v):string=>Http::esc($v); ?>
<div class="page-header d-flex justify-content-between align-items-center"><div><h1>Tous les trajets</h1><p class="text-muted">Administration, y compris trajets complets ou passés.</p></div><a class="btn btn-primary" href="/trajets/nouveau">Créer</a></div>
<div class="app-card app-table table-responsive"><table class="table table-striped mb-0"><thead><tr><th>Départ</th><th>Arrivée</th><th>Date départ</th><th>Places</th><th>Auteur</th><th>Actions</th></tr></thead><tbody>
<?php foreach($trips as $trip):?><tr><td><?= $e($trip['departure_name']) ?></td><td><?= $e($trip['arrival_name']) ?></td><td><?= $e($trip['departure_at']) ?></td><td><?= $e($trip['seats_available'].' / '.$trip['seats_total']) ?></td><td><?= $e($trip['first_name'].' '.$trip['last_name']) ?></td><td><div class="d-flex gap-2">
<a class="btn btn-outline-primary btn-sm" href="/trajets/<?= (int)$trip['id'] ?>/modifier">Modifier</a><form method="post" action="/trajets/<?= (int)$trip['id'] ?>/supprimer" data-confirm="Supprimer définitivement ?"><input type="hidden" name="_csrf" value="<?= $e(Http::csrf()) ?>"><button class="btn btn-outline-danger btn-sm">Supprimer</button></form>
</div></td></tr><?php endforeach;?>
<?php if (!$trips):?><tr><td colspan="6" class="text-center py-4">Aucun trajet enregistré.</td></tr><?php endif;?>
</tbody></table></div>
