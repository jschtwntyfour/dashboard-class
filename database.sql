-- Jalankan file ini di phpMyAdmin > tab SQL

CREATE DATABASE IF NOT EXISTS db_sekolah;
USE db_sekolah;

-- Tabel users (untuk login guru & siswa)
CREATE TABLE users (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(100),
    role     VARCHAR(10)   -- 'guru' atau 'siswa'
);

-- Tabel siswa
CREATE TABLE siswa (
    id    INT AUTO_INCREMENT PRIMARY KEY,
    nama  VARCHAR(100),
    nisn  VARCHAR(10),
    kelas VARCHAR(20),
    jk    VARCHAR(15)
);

-- Tabel nilai
CREATE TABLE nilai (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    id_siswa INT,
    mapel    VARCHAR(50),
    nilai    INT
);

-- Tabel tugas (tugas, ujian harian, agenda)
CREATE TABLE tugas (
    id      INT AUTO_INCREMENT PRIMARY KEY,
    mapel   VARCHAR(50),
    judul   VARCHAR(100),
    isi     TEXT,
    jenis   VARCHAR(20),  -- 'Tugas', 'Ujian Harian', 'Agenda'
    tanggal DATE
);

-- Tabel absensi
CREATE TABLE absensi (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    id_siswa INT,
    tanggal  DATE,
    status   VARCHAR(10)
);

-- Data awal: akun guru dan siswa
INSERT INTO users (username, password, role) VALUES
('guru1',   'guru123',   'guru'),
('siswa1',  'siswa1',  'siswa'),
('siswa2',  'siswa2',  'siswa'),
('siswa3',  'siswa3',  'siswa'),
('siswa4',  'siswa4',  'siswa'),
('siswa5',  'siswa5',  'siswa'),
('siswa6',  'siswa6',  'siswa'),
('siswa7',  'siswa7',  'siswa'),
('siswa8',  'siswa8',  'siswa'),
('siswa9',  'siswa9',  'siswa'),
('siswa10',  'siswa10',  'siswa'),
('siswa11',  'siswa11',  'siswa'),
('siswa12',  'siswa12',  'siswa'),
('siswa13',  'siswa13',  'siswa'),
('siswa14',  'siswa14',  'siswa'),
('siswa15',  'siswa15',  'siswa'),
('siswa16',  'siswa16',  'siswa'),
('siswa17',  'siswa17',  'siswa'),
('siswa18',  'siswa18',  'siswa'),
('siswa19',  'siswa19',  'siswa'),
('siswa20',  'siswa20',  'siswa'),
('siswa21',  'siswa21',  'siswa'),
('siswa22',  'siswa22',  'siswa'),
('siswa23',  'siswa23',  'siswa'),
('siswa24',  'siswa24',  'siswa'),
('siswa25',  'siswa25',  'siswa'),
('siswa26',  'siswa26',  'siswa'),
('siswa27',  'siswa27',  'siswa'),
('siswa28',  'siswa28',  'siswa'),
('siswa29',  'siswa29',  'siswa'),
('siswa30',  'siswa30',  'siswa'),
('siswa31',  'siswa31',  'siswa'),
('siswa32',  'siswa32',  'siswa');

-- Data awal: siswa
INSERT INTO siswa (nama, nisn, kelas, jk) VALUES
('siswa1',    '11111111', '10 PPLG 1', 'Perempuan'),
('siswa2',    '22222222', '10 PPLG 1', 'Perempuan'),
('siswa3',    '33333333', '10 PPLG 1', 'Laki-laki'),
('siswa4',    '44444444', '10 PPLG 1', 'Perempuan'),
('siswa5',    '55555555', '10 PPLG 1', 'Laki-laki'),
('siswa6',    '66666666', '10 PPLG 1', 'Perempuan'),
('siswa7',    '77777777', '10 PPLG 1', 'Laki-laki'),
('siswa8',    '88888888', '10 PPLG 1', 'Perempuan'),
('siswa9',    '99999999', '10 PPLG 1', 'Laki-laki'),
('siswa10',   '10101010', '10 PPLG 1', 'Perempuan'),
('siswa11',    '1111', '10 PPLG 1', 'Laki-laki'),
('siswa12',    '1212', '10 PPLG 1', 'Laki-laki'),
('siswa13',    '1313', '10 PPLG 1', 'Laki-laki'),
('siswa14',    '1414', '10 PPLG 1', 'Laki-laki'),
('siswa15',    '1515', '10 PPLG 1', 'Laki-laki'),
('siswa16',    '1616', '10 PPLG 1', 'Laki-laki'),
('siswa17',    '1717', '10 PPLG 1', 'Laki-laki'),
('siswa18',    '1818', '10 PPLG 1', 'Laki-laki'),
('siswa19',    '1919', '10 PPLG 1', 'Laki-laki'),
('siswa20',    '2020', '10 PPLG 1', 'Laki-laki'),
('siswa21',    '2121', '10 PPLG 1', 'Laki-laki'),
('siswa22',    '2222', '10 PPLG 1', 'Laki-laki'),
('siswa23',    '2323', '10 PPLG 1', 'Laki-laki'),
('siswa24',    '2424', '10 PPLG 1', 'Laki-laki'),
('siswa25',    '2525', '10 PPLG 1', 'Laki-laki'),
('siswa26',    '2626', '10 PPLG 1', 'Laki-laki'),
('siswa27',    '2727', '10 PPLG 1', 'Perempuan'),
('siswa28',    '2828', '10 PPLG 1', 'Laki-laki'),
('siswa29',    '2929', '10 PPLG 1', 'Laki-laki'),
('siswa30',    '3030', '10 PPLG 1', 'Laki-laki'),
('siswa31',    '3131', '10 PPLG 1', 'Laki-laki'),
('siswa32',    '3232', '10 PPLG 1', 'Laki-laki'),
('siswa33',    '3333', '10 PPLG 1', 'Laki-laki')


-- Data awal: nilai
INSERT INTO nilai (id_siswa, mapel, nilai) VALUES
(1, 'Matematika', 85),
(1, 'Bahasa Indonesia', 80),
(1, 'Pemrograman Web', 92),
(1, 'Basis Data', 88),
(2, 'Matematika', 78),
(2, 'Bahasa Indonesia', 90),
(2, 'Pemrograman Web', 85),
(2, 'Basis Data', 82);

-- Data awal: tugas
INSERT INTO tugas (mapel, judul, isi, jenis, tanggal) VALUES
('Pemrograman Web', 'Buat Form Login', 'Buat form login sederhana dengan HTML & CSS', 'Tugas', '2025-04-05'),
('Basis Data', 'UH Tabel & Relasi', 'Kerjakan soal no 1-10 di buku paket hal 45', 'Ujian Harian', '2025-04-07'),
('Matematika', 'Ulangan Fungsi', 'Materi: fungsi komposisi dan invers', 'Ujian Harian', '2025-04-10'),
('Bahasa Indonesia', 'Agenda Presentasi', 'Jadwal presentasi kelompok tiap Rabu', 'Agenda', '2025-04-09');



