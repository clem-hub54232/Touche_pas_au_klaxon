# Touche pas au klaxon 🚗

Application **intranet de covoiturage inter-sites** en **PHP 8.2+**, **MVC**, **MySQL/MariaDB**, **Bootstrap** et **Sass**, réalisée à partir du brief pédagogique.

**Important :** le code est fourni prêt à installer sur un poste/serveur disposant de PHP et MySQL. Aucun site public n'est déployé et aucun dépôt GitHub n'est créé automatiquement. Publier le projet sur votre propre compte GitHub avant de remettre le PDF.

## Fonctionnalités

- Visiteur : accueil public (trajets futurs avec des places, triés par date), connexion.
- Employé connecté : détails du trajet via modale (auteur, téléphone, mail, total de places) ; création ; modification/suppression de ses propres trajets ; déconnexion.
- Administrateur : tableau de bord ; liste des employés RH en lecture seule ; CRUD agences ; lecture de tous les trajets ; création/modification/suppression des trajets.
- Après toute opération d'écriture : **redirection HTTP 303** vers la liste appropriée + **message flash**.
- Validation : agences différentes ; arrivée après départ ; départ futur ; places disponibles <= places totales ; limite 8.
- Pas de création/modification/suppression de comptes employés via l'application, conformément au brief.

## Structure du projet

```text
Touche_pas_au_klaxon/
├── app/
│   ├── Controllers/       # actions HTTP, règles d'accès
│   ├── Core/              # Router, session/CSRF, PDO, vues
│   ├── Repositories/      # requêtes SQL préparées
│   ├── Services/          # validations et CRUD métier testables
│   └── Views/             # HTML Bootstrap
├── public/                # seule racine HTTP à exposer
│   ├── assets/css/        # Bootstrap 5 + CSS applicatif fourni
│   ├── assets/js/         # Bootstrap JS + confirmation actions
│   ├── .htaccess
│   ├── index.php          # front controller
│   └── router.php         # routing serveur PHP intégré
├── resources/scss/       # Sass + variables de Bootstrap
├── database/
│   ├── agences.txt       # données d'annexe, 12 agences
│   ├── users.txt         # données d'annexe, 20 employés
│   ├── 01_schema.sql
│   └── 02_seed.sql
├── docs/                  # MCD, MLD, dossier PDF et visuels annexes
├── tests/                 # PHPUnit : écritures des trajets/agences
├── .env.example
├── composer.json
├── phpunit.xml
├── phpstan.neon
└── README.md
```

## Prérequis

- **PHP 8.2+**, extensions `PDO` et **`pdo_mysql`** ; Apache avec mod_rewrite, ou serveur intégré PHP pour développement.
- **MySQL 8.0+ / MariaDB 10.6+** ; MySQL Workbench facultatif.
- **Composer** pour PHPUnit et PHPStan (le runtime n'exige pas de dépendances Composer).
- Node.js + npm **facultatifs** pour recompiler les fichiers Sass (le CSS fonctionnel est déjà fourni).

## Installation complète (Windows ou Linux/macOS)

1. Extraire le ZIP. Placer le dossier `Touche_pas_au_klaxon` dans un emplacement local.
2. Démarrer MySQL/MariaDB. Avec **MySQL Workbench**, ouvrir puis exécuter dans cet ordre :
   - `database/01_schema.sql` : création des 3 tables, clés étrangères et contraintes ;
   - `database/02_seed.sql` : import des **12 agences, 20 employés** des annexes et de **4 trajets de démonstration**.

   En console Bash / `cmd.exe` (depuis la racine du projet) :

   ```bash
   mysql -u root -p < database/01_schema.sql
   mysql -u root -p < database/02_seed.sql
   ```

   **PowerShell :** utiliser MySQL Workbench, ou lancer les commandes ci-dessus via `cmd.exe` (la redirection `<` n'est pas gérée pareil selon les versions).
3. Copier `.env.example` vers `.env` et adapter :

   ```dotenv
   APP_ENV=development
   APP_URL=http://127.0.0.1:8000
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_NAME=touche_pas_au_klaxon
   DB_USER=root
   DB_PASSWORD=VOTRE_MOT_DE_PASSE_MYSQL
   SESSION_SECURE=false
   ```

   Pour un serveur interne en **HTTPS**, passer `SESSION_SECURE=true`. Ne jamais committer `.env`.
4. Dans un terminal ouvert à la racine du projet :

   ```bash
   php -S 127.0.0.1:8000 -t public public/router.php
   ```

5. Ouvrir dans le navigateur **http://127.0.0.1:8000**.

### Comptes de démonstration

Ces deux comptes proviennent du jeu RH. **Les mots de passe ci-dessous ont été créés pour les tests, ils ne sont pas fournis par le système RH. Ne pas les conserver sur un intranet réel.**

| Rôle | E-mail | Mot de passe de démonstration |
| --- | --- | --- |
| Administrateur | `alexandre.martin@email.fr` | `Admin@2026!` |
| Employé | `sophie.dubois@email.fr` | `User@2026!` |

Les autres employés importés disposent aussi du mot de passe temporaire `User@2026!`. En exploitation, importer des identifiants réels depuis le SI RH / utiliser un SSO d'entreprise, faire remplacer immédiatement les identifiants de démonstration, et restreindre l'accès au réseau interne.

### Comment utiliser l'application

**Sans connexion :** consulter les trajets disponibles. **Connecté :** cliquer sur « Détails » pour voir l'identité et les coordonnées du conducteur. Pour proposer un trajet, cliquer sur « Créer un trajet », renseigner départ, arrivée, dates et places, puis valider. Les données de l'employé sont préremplies et non modifiables. Pour éditer ou supprimer son propre trajet, utiliser les actions du tableau. **Admin :** cliquer sur « Utilisateurs », « Agences » ou « Trajets » dans le header.

Après un ajout/une modification/une suppression, l'application redirige vers la liste et affiche un message flash de réussite ou d'erreur.

## Personnalisation de la palette Bootstrap/Sass

Les couleurs du brief sont présentes dans `resources/scss/main.scss` : `#f1f8fc`, `#0074c7`, `#00497c`, `#384050`, `#cd2c2e`, `#82b864`. Pour générer une nouvelle feuille Bootstrap + thème :

```bash
npm install
npm run build:css
```

Le résultat est `public/assets/css/bundle.css`. Pour l'utiliser, remplacer **les deux** liens CSS du layout `app/Views/partials/layout.php` par un lien unique vers `/assets/css/bundle.css`. **Sans npm**, le site est immédiatement utilisable avec les deux fichiers CSS fournis, dont Bootstrap local (pas besoin de CDN).

## Tests et qualité

Installer les dépendances de développement, puis lancer :

```bash
composer install
composer test
composer analyse
```

- Tests PHPUnit : CRUD trajets et agences (services métier), propriété des trajets, statut administrateur, refus des dates/agences/places incohérentes.
- PHPStan : analyse statique du PHP sous `app/` et `public/index.php` ; configuration de départ niveau 5, à monter si nécessaire.
- Tests manuels : connexion, filtres, modale, création/modification/suppression, messages flash, droits d'accès, CSRF, contraintes SQL.
- La vérification `php -l` a été réalisée sur les fichiers PHP fournis. Les tests PHPUnit et un parcours MySQL complet doivent être exécutés sur un environnement disposant des extensions PHP, de Composer et de MySQL (non exécutés ici).

## Sécurité & intranet

- Exposer **uniquement** `public/` à Apache/Nginx. Ne jamais exposer `.env`, les scripts SQL, les contrôleurs ou les annexes RH.
- Restreindre l'application au **réseau/VPN d'entreprise** via firewall/reverse proxy (et HTTPS même sur intranet). Le code seul ne peut pas garantir l'isolation réseau.
- Mots de passe hachés avec `password_hash` et vérifiés par `password_verify` ; régénération d'ID de session ; cookies HttpOnly, SameSite Lax, Secure si HTTPS.
- Jeton CSRF sur tous les POST ; requêtes PDO préparées ; échappement HTML ; vérification de l'auteur des trajets ; contrôle des rôles ; limitation de tentatives de connexion par session.
- Métadonnées privées conducteur accessibles après authentification uniquement ; employés accessibles en lecture seule aux admins.
- Les employés et coordonnées fournis dans l'annexe sont des données d'exercice : ne pas les déployer publiquement.
- Conseil de production : politique de mot de passe/SSO du SI RH, journalisation, sauvegardes chiffrées, mises à jour de PHP/MySQL/Bootstrap, rotation des secrets et audit de sécurité.

## Modèle de données

- `users` **1:N** `trips` : un utilisateur propose plusieurs trajets.
- `agencies` **1:N** `trips` (deux rôles : départ et arrivée).
- `trips` : deux références à une agence, `owner_id`, horaires, places totales/disponibles.

Voir `docs/MCD.png`, `docs/MLD.txt` et `database/01_schema.sql`.

## Dépôt GitHub & rendu

Le **brief exige un dépôt GitHub** contenant le code, les deux scripts SQL et le README. Pour publier ce dossier dans *votre* compte GitHub (dans le terminal) :

```bash
git init
git add .
git commit -m "Projet MVC PHP Touche pas au klaxon"
git branch -M main
git remote add origin https://github.com/VOTRE_COMPTE/touche-pas-au-klaxon.git
git push -u origin main
```

La commande `git remote add` nécessite que le dépôt GitHub vide existe au préalable. Pensez à remplacer l'URL par le **vrai dépôt** et à la reporter dans le PDF. Le PDF du dossier est placé dans `docs/`.

## Limites de périmètre

- Pas de réservation automatique de places ni de synchronisation RH demandées dans la V1.
- Pas d'application mobile/tablette spécifique : la cible est le poste de travail des employés. Bootstrap permet toutefois un affichage tolérant aux largeurs réduites.
- Aucune URL de déploiement public : projet destiné à l'intranet privé de l'entreprise.
