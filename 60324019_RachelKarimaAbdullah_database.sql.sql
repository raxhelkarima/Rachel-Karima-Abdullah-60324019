DROP DATABASE IF EXISTS perpustakaan;
CREATE DATABASE perpustakaan;
USE perpustakaan;

-- Tabel kategori_buku
CREATE TABLE kategori_buku (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL UNIQUE,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

-- Tabel penerbit
CREATE TABLE penerbit (
    id_penerbit INT AUTO_INCREMENT PRIMARY KEY,
    nama_penerbit VARCHAR(100) NOT NULL,
    alamat TEXT,
    telepon VARCHAR(15),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

-- Tabel rak (bonus)
CREATE TABLE rak (
    id_rak INT AUTO_INCREMENT PRIMARY KEY,
    nama_rak VARCHAR(50),
    lokasi VARCHAR(100)
);

-- Tabel buku
CREATE TABLE buku (
    id_buku INT AUTO_INCREMENT PRIMARY KEY,
    kode_buku VARCHAR(20) UNIQUE NOT NULL,
    judul VARCHAR(200) NOT NULL,
    id_kategori INT,
    pengarang VARCHAR(100) NOT NULL,
    id_penerbit INT,
    id_rak INT,
    tahun_terbit INT NOT NULL,
    isbn VARCHAR(20),
    harga DECIMAL(10,2) NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (id_kategori) REFERENCES kategori_buku(id_kategori),
    FOREIGN KEY (id_penerbit) REFERENCES penerbit(id_penerbit),
    FOREIGN KEY (id_rak) REFERENCES rak(id_rak)
);

-- Tabel anggota
CREATE TABLE anggota (
    id_anggota INT AUTO_INCREMENT PRIMARY KEY,
    kode_anggota VARCHAR(20) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telepon VARCHAR(15) NOT NULL,
    alamat TEXT NOT NULL,
    tanggal_lahir DATE NOT NULL,
    jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL,
    pekerjaan VARCHAR(50),
    tanggal_daftar DATE NOT NULL,
    status ENUM('Aktif', 'Nonaktif') DEFAULT 'Aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

-- Tabel transaksi
CREATE TABLE transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    id_buku INT NOT NULL,
    id_anggota INT NOT NULL,
    tanggal_pinjam DATE NOT NULL,
    tanggal_harus_kembali DATE NOT NULL,
    tanggal_kembali DATE,
    status ENUM('Dipinjam', 'Dikembalikan', 'Terlambat') DEFAULT 'Dipinjam',
    denda DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_buku) REFERENCES buku(id_buku),
    FOREIGN KEY (id_anggota) REFERENCES anggota(id_anggota)
);

-- Insert kategori
INSERT INTO kategori_buku (nama_kategori, deskripsi) VALUES
('Programming', 'Buku tentang pemrograman'),
('Database', 'Buku tentang basis data'),
('Web Design', 'Buku desain web'),
('Networking', 'Buku jaringan komputer'),
('AI', 'Buku kecerdasan buatan');

-- Insert penerbit
INSERT INTO penerbit (nama_penerbit, alamat, telepon, email) VALUES
('Erlangga', 'Jakarta', '0811111111', 'info@erlangga.com'),
('Gramedia', 'Jakarta', '0822222222', 'info@gramedia.com'),
('Informatika', 'Bandung', '0833333333', 'info@informatika.com'),
('Andi Offset', 'Yogyakarta', '0844444444', 'info@andi.com'),
('Deepublish', 'Yogyakarta', '0855555555', 'info@deepublish.com');

-- Insert rak
INSERT INTO rak (nama_rak, lokasi) VALUES
('Rak A', 'Lantai 1'),
('Rak B', 'Lantai 1'),
('Rak C', 'Lantai 2');

-- Insert buku
INSERT INTO buku (kode_buku, judul, id_kategori, pengarang, id_penerbit, id_rak, tahun_terbit, isbn, harga, stok, deskripsi) VALUES
('BK-001', 'Belajar PHP', 1, 'Andi', 1, 1, 2020, '111', 80000, 10, 'Dasar PHP'),
('BK-002', 'Mastering Java', 1, 'Budi', 2, 1, 2021, '222', 90000, 8, 'Java lanjutan'),
('BK-003', 'Database MySQL', 2, 'Citra', 3, 2, 2019, '333', 85000, 7, 'MySQL dasar'),
('BK-004', 'Desain Web Modern', 3, 'Dewi', 4, 2, 2022, '444', 95000, 5, 'UI/UX'),
('BK-005', 'Jaringan Komputer', 4, 'Eko', 5, 3, 2018, '555', 88000, 6, 'Networking'),
('BK-006', 'AI Dasar', 5, 'Fajar', 1, 1, 2023, '666', 100000, 9, 'AI basic'),
('BK-007', 'Python Programming', 1, 'Gina', 2, 1, 2020, '777', 87000, 4, 'Python'),
('BK-008', 'SQL Advanced', 2, 'Hadi', 3, 2, 2021, '888', 92000, 3, 'SQL lanjut'),
('BK-009', 'CSS & HTML', 3, 'Indah', 4, 2, 2022, '999', 78000, 5, 'Frontend'),
('BK-010', 'Cisco Networking', 4, 'Joko', 5, 3, 2021, '101', 99000, 6, 'Cisco'),
('BK-011', 'Machine Learning', 5, 'Kiki', 1, 1, 2023, '102', 120000, 7, 'ML'),
('BK-012', 'Laravel Framework', 1, 'Lina', 2, 1, 2022, '103', 95000, 8, 'Laravel'),
('BK-013', 'PostgreSQL', 2, 'Mira', 3, 2, 2021, '104', 87000, 5, 'Postgres'),
('BK-014', 'UI Design', 3, 'Nina', 4, 2, 2020, '105', 76000, 6, 'UI'),
('BK-015', 'Cloud Network', 4, 'Omar', 5, 3, 2023, '106', 110000, 4, 'Cloud');

-- Insert anggota
INSERT INTO anggota (kode_anggota, nama, email, telepon, alamat, tanggal_lahir, jenis_kelamin, pekerjaan, tanggal_daftar) VALUES
('AGT-001', 'Budi Santoso', 'budi@email.com', '081234567890', 'Jl. Merdeka No.10, Jakarta', '1995-05-15', 'Laki-laki', 'Mahasiswa', '2024-01-10'),
('AGT-002', 'Siti Nurhaliza', 'siti@email.com', '081234567891', 'Jl. Sudirman No.25, Bandung', '1998-08-20', 'Perempuan', 'Pegawai', '2024-01-15'),
('AGT-003', 'Ahmad Dhani', 'ahmad@email.com', '081234567892', 'Jl. Gatot Subroto No.5, Surabaya', '1992-03-10', 'Laki-laki', 'Pegawai', '2024-02-01');

-- Insert transaksi
INSERT INTO transaksi (id_buku, id_anggota, tanggal_pinjam, tanggal_harus_kembali, status) VALUES
(1, 1, '2024-02-01', '2024-02-08', 'Dipinjam'),
(2, 2, '2024-02-03', '2024-02-10', 'Dipinjam'),
(3, 1, '2024-01-25', '2024-02-01', 'Dikembalikan');

-- JOIN buku dengan nama kategori dan penerbit
SELECT 
    buku.judul,
    kategori_buku.nama_kategori,
    penerbit.nama_penerbit
FROM buku
JOIN kategori_buku ON buku.id_kategori = kategori_buku.id_kategori
JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit;

-- Jumlah buku per kategori
SELECT 
    kategori_buku.nama_kategori,
    COUNT(buku.id_buku) AS jumlah_buku
FROM buku
JOIN kategori_buku ON buku.id_kategori = kategori_buku.id_kategori
GROUP BY kategori_buku.nama_kategori;

-- Jumlah buku per penerbit
SELECT 
    penerbit.nama_penerbit,
    COUNT(buku.id_buku) AS jumlah_buku
FROM buku
JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit
GROUP BY penerbit.nama_penerbit;

-- Detail lengkap buku (kategori + penerbit)
SELECT 
    buku.kode_buku,
    buku.judul,
    buku.pengarang,
    kategori_buku.nama_kategori,
    penerbit.nama_penerbit,
    buku.tahun_terbit,
    buku.harga,
    buku.stok
FROM buku
JOIN kategori_buku ON buku.id_kategori = kategori_buku.id_kategori
JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit;

-- Bonus: stored procedure tampil semua buku
DELIMITER $$

CREATE PROCEDURE tampil_semua_buku()
BEGIN
    SELECT * FROM buku WHERE deleted_at IS NULL;
END$$

DELIMITER ;