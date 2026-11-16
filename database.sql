CREATE DATABASE IF NOT EXISTS db_ruang_sidang;
USE db_ruang_sidang;

CREATE TABLE IF NOT EXISTS master_ruang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_ruang VARCHAR(100) NOT NULL,
    gedung VARCHAR(100) NOT NULL
);

INSERT INTO master_ruang (nama_ruang, gedung) VALUES
('Ruang Sidang 1', 'Gedung D'),
('Ruang Sidang 2', 'Gedung D');

CREATE TABLE IF NOT EXISTS nomor_gedung (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_gedung VARCHAR(100) NOT NULL
);

INSERT INTO nomor_gedung (nama_gedung) VALUES
('Gedung A'),
('Gedung B'),
('Gedung D');

CREATE TABLE IF NOT EXISTS fasilitas_ruang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_ruang VARCHAR(100) NOT NULL,
    proyektor VARCHAR(50) NOT NULL,
    pc VARCHAR(50) NOT NULL
);

INSERT INTO fasilitas_ruang (nama_ruang, proyektor, pc) VALUES
('Ruang Sidang 1', 'Ada', 'Ada'),
('Ruang Sidang 2', 'Ada', 'Tidak Ada'),
('Ruang Sidang 3', 'Tidak Ada', 'Ada');

CREATE TABLE IF NOT EXISTS pengguna (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'user'
);
