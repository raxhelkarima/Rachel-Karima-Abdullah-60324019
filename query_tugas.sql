-- STATISTIK BUKU (5 Query)

-- Total buku seluruhnya
SELECT COUNT(*) AS total_buku FROM buku;

-- Total nilai inventaris
SELECT 
    SUM(harga * stok) AS total_nilai_inventaris
FROM buku;

-- Rata-rata harga buku
SELECT 
    AVG(harga) AS rata_rata_harga
FROM buku;

-- Buku termahal (tampilkan judul dan harga)
SELECT 
    judul, 
    harga
FROM buku
WHERE harga = (SELECT MAX(harga) FROM buku);

-- Buku dengan stok terbanyak
SELECT 
    judul, 
    stok
FROM buku
ORDER BY stok DESC
LIMIT 1;


-- FILTER DAN PENCARIAN (5 Query)

-- Semua buku kategori Programming yang harga < 100.000
SELECT * 
FROM buku
WHERE kategori = 'Programming' AND harga < 100000;

-- Buku yang judulnya mengandung kata "PHP" atau "MySQL"
SELECT * 
FROM buku
WHERE judul LIKE '%PHP%' OR judul LIKE '%MySQL%';

-- Buku yang terbit tahun 2024
SELECT * 
FROM buku
WHERE tahun_terbit = 2024;

-- Buku yang stoknya antara 5-10
SELECT * 
FROM buku
WHERE stok BETWEEN 5 AND 10;

-- Buku yang pengarangnya "Budi Raharjo"
SELECT * 
FROM buku
WHERE pengarang = 'Budi Raharjo';


-- GROUPING DAN AGREGASI (3 Query)

-- Jumlah buku per kategori beserta total stok per kategori
SELECT 
    kategori,
    COUNT(*) AS jumlah_buku,
    SUM(stok) AS total_stok
FROM buku
GROUP BY kategori
ORDER BY jumlah_buku DESC;

-- Rata-rata harga per kategori
SELECT 
    kategori,
    ROUND(AVG(harga), 2) AS rata_rata_harga
FROM buku
GROUP BY kategori
ORDER BY rata_rata_harga DESC;

-- Kategori dengan total nilai inventaris terbesar
SELECT 
    kategori,
    SUM(harga * stok) AS total_nilai_inventaris
FROM buku
GROUP BY kategori
ORDER BY total_nilai_inventaris DESC
LIMIT 1;


-- UPDATE DATA (2 Query)

-- Naikkan harga semua buku kategori Programming sebesar 5%
UPDATE buku
SET harga = harga * 1.05
WHERE kategori = 'Programming';

-- Verifikasi hasilnya
SELECT judul, kategori, harga FROM buku WHERE kategori = 'Programming';

-- Tambah stok 10 untuk semua buku yang stoknya < 5
UPDATE buku
SET stok = stok + 10
WHERE stok < 5;

-- Verifikasi hasilnya
SELECT judul, stok FROM buku ORDER BY stok ASC;


-- LAPORAN KHUSUS (2 Query)

-- Daftar buku yang perlu restocking (stok < 5)
SELECT * FROM buku WHERE stok < 5;

-- Top 5 buku termahal
SELECT judul, harga FROM buku ORDER BY harga DESC LIMIT 5;