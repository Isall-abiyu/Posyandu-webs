CREATE DATABASE IF NOT EXISTS db_posyandu CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE db_posyandu;

CREATE TABLE IF NOT EXISTS tb_login(
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE,
  password VARCHAR(255)
);

INSERT INTO tb_login(username,password) VALUES('posyandu','posyandu123') ON DUPLICATE KEY UPDATE password=VALUES(password);

CREATE TABLE IF NOT EXISTS tb_balita(
  id INT AUTO_INCREMENT PRIMARY KEY,
  nik VARCHAR(20),
  nama VARCHAR(100),
  nama_ibu VARCHAR(100),
  umur_bulan INT,
  jenis_kelamin VARCHAR(1),
  bb_kg DECIMAL(5,2),
  tb_cm DECIMAL(5,2),
  status_gizi VARCHAR(20),
  tgl_periksa DATE
);

CREATE TABLE IF NOT EXISTS tb_lansia(
  id INT AUTO_INCREMENT PRIMARY KEY,
  nik VARCHAR(20),
  nama VARCHAR(100),
  umur INT,
  jenis_kelamin VARCHAR(1),
  bb_kg DECIMAL(5,2),
  tb_cm DECIMAL(5,2),
  tekanan_darah VARCHAR(20),
  gula_darah DECIMAL(6,2),
  tgl_periksa DATE
);

-- ============================================================
-- Tabel Ibu Hamil
-- ============================================================
CREATE TABLE IF NOT EXISTS tb_ibu_hamil (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nik VARCHAR(20) NOT NULL,
  nama VARCHAR(100) NOT NULL,
  tgl_lahir DATE,
  umur INT,
  alamat TEXT,
  no_hp VARCHAR(20),
  nama_suami VARCHAR(100),
  golongan_darah VARCHAR(5),
  -- Data Kehamilan
  gravida TINYINT DEFAULT 1 COMMENT 'kehamilan ke-',
  paritas TINYINT DEFAULT 0 COMMENT 'jumlah persalinan',
  abortus TINYINT DEFAULT 0,
  jumlah_anak_hidup TINYINT DEFAULT 0,
  hpht DATE COMMENT 'Hari Pertama Haid Terakhir',
  hpl DATE COMMENT 'Hari Perkiraan Lahir',
  -- Status
  status_risiko ENUM('Normal','Risiko Rendah','Risiko Tinggi') DEFAULT 'Normal',
  faktor_risiko TEXT,
  catatan TEXT,
  tgl_daftar DATE,
  aktif TINYINT DEFAULT 1 COMMENT '1=aktif, 0=sudah melahirkan'
);

CREATE TABLE IF NOT EXISTS tb_kunjungan_hamil (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_ibu INT NOT NULL,
  tgl_periksa DATE NOT NULL,
  usia_kehamilan_minggu TINYINT,
  bb_kg DECIMAL(5,2),
  tb_cm DECIMAL(5,2),
  tekanan_darah VARCHAR(20),
  tfu_cm DECIMAL(5,2) COMMENT 'Tinggi Fundus Uteri',
  djj INT COMMENT 'Detak Jantung Janin (dpm)',
  presentasi_janin VARCHAR(30) COMMENT 'kepala/sungsang/dll',
  edema ENUM('Tidak','Ringan','Sedang','Berat') DEFAULT 'Tidak',
  hb DECIMAL(4,2) COMMENT 'Hemoglobin g/dL',
  tablet_fe INT DEFAULT 0 COMMENT 'jumlah tablet Fe diberikan',
  imunisasi_tt VARCHAR(10) DEFAULT '-' COMMENT 'TT1-TT5',
  vitamin TEXT,
  catatan_kunjungan TEXT,
  FOREIGN KEY (id_ibu) REFERENCES tb_ibu_hamil(id) ON DELETE CASCADE
);

-- Sample data
INSERT INTO tb_ibu_hamil (nik, nama, tgl_lahir, umur, alamat, no_hp, nama_suami, golongan_darah, gravida, paritas, abortus, jumlah_anak_hidup, hpht, hpl, status_risiko, faktor_risiko, catatan, tgl_daftar, aktif)
VALUES
('3578012345', 'Siti Rahayu', '1995-03-15', 29, 'Jl. Kemuning No. 5 RT 03/08', '081234567890', 'Budi Santoso', 'O', 2, 1, 0, 1, '2026-01-10', '2026-10-17', 'Normal', NULL, 'Kehamilan berjalan normal', '2026-01-20', 1),
('3578019876', 'Dewi Lestari', '1998-07-22', 27, 'Jl. Melati No. 12 RT 03/08', '085678901234', 'Eko Prasetyo', 'A', 1, 0, 0, 0, '2025-12-01', '2026-09-07', 'Risiko Rendah', 'Anemia ringan', 'Perlu pemantauan Hb', '2025-12-10', 1);

INSERT INTO tb_kunjungan_hamil (id_ibu, tgl_periksa, usia_kehamilan_minggu, bb_kg, tb_cm, tekanan_darah, tfu_cm, djj, presentasi_janin, edema, hb, tablet_fe, imunisasi_tt, vitamin, catatan_kunjungan)
VALUES
(1, '2026-01-20', 12, 55.0, 158.0, '110/70', 10.0, 140, 'Kepala', 'Tidak', 11.5, 30, 'TT1', 'Asam folat', 'Kunjungan pertama, kondisi baik'),
(1, '2026-03-15', 24, 60.5, 158.0, '115/75', 24.0, 145, 'Kepala', 'Tidak', 12.0, 30, '-', 'Vitamin C, Fe', 'Perkembangan janin normal'),
(2, '2025-12-10', 8, 48.0, 152.0, '100/65', 8.0, 138, 'Kepala', 'Tidak', 9.8, 30, 'TT1', 'Asam folat', 'Hb rendah, perlu suplementasi'),
(2, '2026-02-05', 20, 51.5, 152.0, '105/70', 20.0, 142, 'Kepala', 'Ringan', 10.5, 30, 'TT2', 'Fe, Vitamin B', 'Edema ringan di kaki, masih aman');
