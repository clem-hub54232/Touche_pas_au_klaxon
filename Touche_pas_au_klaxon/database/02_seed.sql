-- Jeu d essais issu des annexes : 12 agences et 20 utilisateurs RH.
-- Comptes de démonstration locaux (changer les mots de passe avant mise en service).
USE touche_pas_au_klaxon;

-- Les INSERT IGNORE permettent une installation répétée sans écraser les comptes.
INSERT IGNORE INTO agencies(name) VALUES ('Paris');
INSERT IGNORE INTO agencies(name) VALUES ('Lyon');
INSERT IGNORE INTO agencies(name) VALUES ('Marseille');
INSERT IGNORE INTO agencies(name) VALUES ('Toulouse');
INSERT IGNORE INTO agencies(name) VALUES ('Nice');
INSERT IGNORE INTO agencies(name) VALUES ('Nantes');
INSERT IGNORE INTO agencies(name) VALUES ('Strasbourg');
INSERT IGNORE INTO agencies(name) VALUES ('Montpellier');
INSERT IGNORE INTO agencies(name) VALUES ('Bordeaux');
INSERT IGNORE INTO agencies(name) VALUES ('Lille');
INSERT IGNORE INTO agencies(name) VALUES ('Rennes');
INSERT IGNORE INTO agencies(name) VALUES ('Reims');

INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Martin','Alexandre','0612345678','alexandre.martin@email.fr','$2y$12$EIXjUJssVIga3S8nYPrOZeOwXEww/fI6W4TK5NuWR2GMqVqv01jTO','admin');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Dubois','Sophie','0698765432','sophie.dubois@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Bernard','Julien','0622446688','julien.bernard@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Moreau','Camille','0611223344','camille.moreau@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Lefèvre','Lucie','0777889900','lucie.lefevre@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Leroy','Thomas','0655443322','thomas.leroy@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Roux','Chloé','0633221199','chloe.roux@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Petit','Maxime','0766778899','maxime.petit@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Garnier','Laura','0688776655','laura.garnier@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Dupuis','Antoine','0744556677','antoine.dupuis@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Lefebvre','Emma','0699887766','emma.lefebvre@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Fontaine','Louis','0655667788','louis.fontaine@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Chevalier','Clara','0788990011','clara.chevalier@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Robin','Nicolas','0644332211','nicolas.robin@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Gauthier','Marine','0677889922','marine.gauthier@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Fournier','Pierre','0722334455','pierre.fournier@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Girard','Sarah','0688665544','sarah.girard@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Lambert','Hugo','0611223366','hugo.lambert@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Masson','Julie','0733445566','julie.masson@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');
INSERT IGNORE INTO users(last_name,first_name,phone,email,password_hash,role) VALUES ('Henry','Arthur','0666554433','arthur.henry@email.fr','$2y$12$0yUgFlxPJ2XZeCw4trGbGuHySktSvx517uLoGdyE9eVbA3SLiJQtS','user');

-- Exemples de trajets futurs (3 jours, 5 jours, 8 jours, 12 jours) sans nom d agence inventé.
-- Un trajet complet existe pour tester le filtre ; il est invisible sur l accueil.
INSERT INTO trips(departure_agency_id,arrival_agency_id,departure_at,arrival_at,seats_total,seats_available,owner_id) SELECT dep.id, arr.id, DATE_ADD(DATE_ADD(CURDATE(), INTERVAL 3 DAY), INTERVAL 9 HOUR), DATE_ADD(DATE_ADD(CURDATE(), INTERVAL 4 DAY), INTERVAL 12 HOUR), 4, 3, u.id FROM agencies dep CROSS JOIN agencies arr CROSS JOIN users u WHERE dep.name='Paris' AND arr.name='Lyon' AND u.email='alexandre.martin@email.fr' AND NOT EXISTS(SELECT 1 FROM trips t WHERE t.owner_id=u.id AND t.departure_agency_id=dep.id AND t.arrival_agency_id=arr.id);
INSERT INTO trips(departure_agency_id,arrival_agency_id,departure_at,arrival_at,seats_total,seats_available,owner_id) SELECT dep.id, arr.id, DATE_ADD(DATE_ADD(CURDATE(), INTERVAL 5 DAY), INTERVAL 9 HOUR), DATE_ADD(DATE_ADD(CURDATE(), INTERVAL 5 DAY), INTERVAL 12 HOUR), 3, 2, u.id FROM agencies dep CROSS JOIN agencies arr CROSS JOIN users u WHERE dep.name='Nice' AND arr.name='Marseille' AND u.email='sophie.dubois@email.fr' AND NOT EXISTS(SELECT 1 FROM trips t WHERE t.owner_id=u.id AND t.departure_agency_id=dep.id AND t.arrival_agency_id=arr.id);
INSERT INTO trips(departure_agency_id,arrival_agency_id,departure_at,arrival_at,seats_total,seats_available,owner_id) SELECT dep.id, arr.id, DATE_ADD(DATE_ADD(CURDATE(), INTERVAL 8 DAY), INTERVAL 9 HOUR), DATE_ADD(DATE_ADD(CURDATE(), INTERVAL 8 DAY), INTERVAL 12 HOUR), 5, 4, u.id FROM agencies dep CROSS JOIN agencies arr CROSS JOIN users u WHERE dep.name='Bordeaux' AND arr.name='Nantes' AND u.email='julien.bernard@email.fr' AND NOT EXISTS(SELECT 1 FROM trips t WHERE t.owner_id=u.id AND t.departure_agency_id=dep.id AND t.arrival_agency_id=arr.id);
INSERT INTO trips(departure_agency_id,arrival_agency_id,departure_at,arrival_at,seats_total,seats_available,owner_id) SELECT dep.id, arr.id, DATE_ADD(DATE_ADD(CURDATE(), INTERVAL 12 DAY), INTERVAL 9 HOUR), DATE_ADD(DATE_ADD(CURDATE(), INTERVAL 12 DAY), INTERVAL 12 HOUR), 4, 0, u.id FROM agencies dep CROSS JOIN agencies arr CROSS JOIN users u WHERE dep.name='Lille' AND arr.name='Reims' AND u.email='camille.moreau@email.fr' AND NOT EXISTS(SELECT 1 FROM trips t WHERE t.owner_id=u.id AND t.departure_agency_id=dep.id AND t.arrival_agency_id=arr.id);
