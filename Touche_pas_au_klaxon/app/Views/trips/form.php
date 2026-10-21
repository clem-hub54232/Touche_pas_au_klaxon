<?php use App\Core\{Auth,Http};
$e=static fn(mixed $v):string=>Http::esc($v);
$isEdit=is_array($trip);
$user=Auth::user();
$action=$isEdit?'/trajets/'.(int)$trip['id'].'/modifier':'/trajets';
$dt=static fn(string $s):string=> $s!=='' ? str_replace(' ','T',substr($s,0,16)) : '';
?>
<div class="page-header"><h1><?= $isEdit?'Modifier un trajet':'Créer un trajet' ?></h1><p class="text-muted">Renseignez les informations du déplacement inter-sites.</p></div>
<div class="app-card p-4"><form method="post" action="<?= $action ?>">
<input type="hidden" name="_csrf" value="<?= $e(Http::csrf()) ?>">
<div class="row g-3 mb-3">
<div class="col-md-6"><label class="form-label" for="owner">Collaborateur</label><input id="owner" class="form-control" value="<?= $e($user['first_name'].' '.$user['last_name']) ?>" readonly></div>
<div class="col-md-6"><label class="form-label" for="email">Adresse e-mail</label><input id="email" class="form-control" value="<?= $e($user['email']) ?>" readonly></div>
<div class="col-md-6"><label class="form-label" for="phone">Téléphone</label><input id="phone" class="form-control" value="<?= $e($user['phone']) ?>" readonly></div></div>
<div class="row g-3">
<div class="col-md-6"><label for="dep" class="form-label">Agence de départ *</label><select name="departure_agency_id" id="dep" class="form-select" required><option value="">Sélectionner</option><?php foreach($agencies as $agency):?><option value="<?= (int)$agency['id'] ?>" <?= $isEdit&&(int)$trip['departure_agency_id']===(int)$agency['id']?'selected':'' ?>><?= $e($agency['name']) ?></option><?php endforeach;?></select></div>
<div class="col-md-6"><label for="arr" class="form-label">Agence d’arrivée *</label><select name="arrival_agency_id" id="arr" class="form-select" required><option value="">Sélectionner</option><?php foreach($agencies as $agency):?><option value="<?= (int)$agency['id'] ?>" <?= $isEdit&&(int)$trip['arrival_agency_id']===(int)$agency['id']?'selected':'' ?>><?= $e($agency['name']) ?></option><?php endforeach;?></select></div>
<div class="col-md-6"><label for="start" class="form-label">Départ : date et heure *</label><input name="departure_at" type="datetime-local" id="start" class="form-control" value="<?= $e($isEdit?$dt((string)$trip['departure_at']):'') ?>" required></div>
<div class="col-md-6"><label for="end" class="form-label">Arrivée : date et heure *</label><input name="arrival_at" type="datetime-local" id="end" class="form-control" value="<?= $e($isEdit?$dt((string)$trip['arrival_at']):'') ?>" required></div>
<div class="col-md-6"><label for="total" class="form-label">Nombre total de places *</label><input name="seats_total" type="number" id="total" class="form-control" min="1" max="8" value="<?= $e($isEdit?$trip['seats_total']:4) ?>" required></div>
<div class="col-md-6"><label for="available" class="form-label">Places disponibles *</label><input name="seats_available" type="number" id="available" class="form-control" min="0" max="8" value="<?= $e($isEdit?$trip['seats_available']:3) ?>" required></div>
</div><div class="mt-4 d-flex gap-2"><button class="btn btn-primary" type="submit"><?= $isEdit?'Enregistrer les modifications':'Publier le trajet' ?></button><a class="btn btn-outline-secondary" href="<?= Auth::isAdmin()?'/admin/trajets':'/' ?>">Annuler</a></div></form></div>
