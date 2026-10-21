<?php use App\Core\{Auth,Http};
$e=static fn(mixed $v):string=>Http::esc($v);
$user=Auth::user();
?>
<div class="page-header"><h1>Trajets proposés</h1>
<p class="text-muted mb-0">Déplacements inter-sites avec au moins une place disponible, par date de départ croissante.</p></div>
<?php if (!$user): ?><div class="alert alert-info">Pour obtenir plus d’informations sur un trajet, veuillez <a href="/connexion" class="alert-link">vous connecter</a>.</div><?php endif; ?>
<div class="app-card app-table table-responsive">
<table class="table table-striped table-hover mb-0">
<thead><tr><th scope="col">Départ</th><th scope="col">Date</th><th scope="col">Heure</th><th scope="col">Destination</th><th scope="col">Date</th><th scope="col">Heure</th><th scope="col">Places</th><?php if($user):?><th scope="col">Actions</th><?php endif;?></tr></thead>
<tbody>
<?php foreach($trips as $trip): ?>
<tr>
<td><?= $e($trip['departure_name']) ?></td><td><?= $e(date('d/m/Y',strtotime((string)$trip['departure_at']))) ?></td><td><?= $e(date('H:i',strtotime((string)$trip['departure_at']))) ?></td>
<td><?= $e($trip['arrival_name']) ?></td><td><?= $e(date('d/m/Y',strtotime((string)$trip['arrival_at']))) ?></td><td><?= $e(date('H:i',strtotime((string)$trip['arrival_at']))) ?></td>
<td><span class="badge badge-places"><?= $e($trip['seats_available']) ?></span></td>
<?php if($user):?><td class="text-nowrap">
<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#details<?= (int)$trip['id'] ?>" aria-label="Détails du trajet <?= (int)$trip['id'] ?>">Détails</button>
<?php if (Auth::isAdmin()||(int)$trip['owner_id']===Auth::id()):?>
<a class="btn btn-outline-primary btn-sm" href="/trajets/<?= (int)$trip['id'] ?>/modifier">Modifier</a>
<form class="d-inline" method="post" action="/trajets/<?= (int)$trip['id'] ?>/supprimer" data-confirm="Supprimer ce trajet ?"><input type="hidden" name="_csrf" value="<?= $e(Http::csrf()) ?>"><button class="btn btn-outline-danger btn-sm">Supprimer</button></form>
<?php endif;?></td><?php endif;?>
</tr>
<?php endforeach; ?>
<?php if (!$trips): ?><tr><td class="text-center py-4" colspan="<?= $user?8:7 ?>">Aucun trajet disponible actuellement.</td></tr><?php endif;?>
</tbody></table></div>
<?php if($user):foreach($trips as $trip): ?>
<div class="modal fade" id="details<?= (int)$trip['id'] ?>" tabindex="-1" aria-labelledby="detailsTitle<?= (int)$trip['id'] ?>" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h2 class="modal-title fs-5" id="detailsTitle<?= (int)$trip['id'] ?>">Détails du trajet</h2><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button></div>
<div class="modal-body"><p><strong>Auteur :</strong> <?= $e($trip['first_name'].' '.$trip['last_name']) ?></p><p><strong>Téléphone :</strong> <?= $e($trip['phone']) ?></p><p><strong>Email :</strong> <a href="mailto:<?= $e($trip['email']) ?>"><?= $e($trip['email']) ?></a></p><p><strong>Nombre total de places :</strong> <?= $e($trip['seats_total']) ?></p></div>
<div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button></div></div></div></div>
<?php endforeach;endif; ?>
