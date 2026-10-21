-- Touche pas au klaxon : base relationnelle (MySQL 8.0+ / MariaDB 10.6+)
CREATE DATABASE IF NOT EXISTS touche_pas_au_klaxon CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE touche_pas_au_klaxon;

CREATE TABLE IF NOT EXISTS agencies (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  last_name VARCHAR(100) NOT NULL,
  first_name VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('user','admin') NOT NULL DEFAULT 'user',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS trips (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  departure_agency_id INT UNSIGNED NOT NULL,
  arrival_agency_id INT UNSIGNED NOT NULL,
  departure_at DATETIME NOT NULL,
  arrival_at DATETIME NOT NULL,
  seats_total TINYINT UNSIGNED NOT NULL,
  seats_available TINYINT UNSIGNED NOT NULL,
  owner_id INT UNSIGNED NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_trip_departure FOREIGN KEY (departure_agency_id) REFERENCES agencies(id) ON DELETE RESTRICT,
  CONSTRAINT fk_trip_arrival FOREIGN KEY (arrival_agency_id) REFERENCES agencies(id) ON DELETE RESTRICT,
  CONSTRAINT fk_trip_owner FOREIGN KEY (owner_id) REFERENCES users(id) ON DELETE RESTRICT,
  CONSTRAINT chk_diff_agency CHECK (departure_agency_id <> arrival_agency_id),
  CONSTRAINT chk_schedule CHECK (arrival_at > departure_at),
  CONSTRAINT chk_total CHECK (seats_total BETWEEN 1 AND 8),
  CONSTRAINT chk_places CHECK (seats_available <= seats_total),
  INDEX idx_visible (departure_at, seats_available),
  INDEX idx_owner (owner_id)
) ENGINE=InnoDB;
