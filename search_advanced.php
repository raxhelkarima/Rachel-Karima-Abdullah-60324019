<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Buku Advanced</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5 mb-5">
        <h1 class="mb-4"><i class="bi bi-search"></i> Pencarian Buku Advanced</h1>

        <?php
        session_start();

        // Data buku
        $buku_list = [
            [
                "kode" => "BK-001",
                "judul" => "Pemrograman PHP untuk Pemula",
                "kategori" => "Programming",
                "pengarang" => "Budi Raharjo",
                "penerbit" => "Informatika",
                "tahun" => 2023,
                "harga" => 75000,
                "stok" => 10
            ],
            [
                "kode" => "BK-002",
                "judul" => "Mastering MySQL Database",
                "kategori" => "Database",
                "pengarang" => "Andi Nugroho",
                "penerbit" => "Graha Ilmu",
                "tahun" => 2022,
                "harga" => 95000,
                "stok" => 5
            ],
            [
                "kode" => "BK-003",
                "judul" => "Laravel Framework Advanced",
                "kategori" => "Programming",
                "pengarang" => "Siti Aminah",
                "penerbit" => "Informatika",
                "tahun" => 2024,
                "harga" => 125000,
                "stok" => 8
            ],
            [
                "kode" => "BK-004",
                "judul" => "Web Design Principles",
                "kategori" => "Web Design",
                "pengarang" => "Dedi Santoso",
                "penerbit" => "Andi",
                "tahun" => 2023,
                "harga" => 85000,
                "stok" => 15
            ],
            [
                "kode" => "BK-005",
                "judul" => "Network Security Fundamentals",
                "kategori" => "Networking",
                "pengarang" => "Rina Wijaya",
                "penerbit" => "Erlangga",
                "tahun" => 2023,
                "harga" => 110000,
                "stok" => 3
            ],
            [
                "kode" => "BK-006",
                "judul" => "PHP Web Services",
                "kategori" => "Programming",
                "pengarang" => "Budi Raharjo",
                "penerbit" => "Informatika",
                "tahun" => 2024,
                "harga" => 90000,
                "stok" => 12
            ],
            [
                "kode" => "BK-007",
                "judul" => "PostgreSQL Advanced",
                "kategori" => "Database",
                "pengarang" => "Ahmad Yani",
                "penerbit" => "Graha Ilmu",
                "tahun" => 2024,
                "harga" => 115000,
                "stok" => 7
            ],
            [
                "kode" => "BK-008",
                "judul" => "JavaScript Modern",
                "kategori" => "Programming",
                "pengarang" => "Siti Aminah",
                "penerbit" => "Informatika",
                "tahun" => 2023,
                "harga" => 80000,
                "stok" => 0
            ],
            [
                "kode" => "BK-009",
                "judul" => "Dasar-Dasar Jaringan Komputer",
                "kategori" => "Networking",
                "pengarang" => "Hendra Kusuma",
                "penerbit" => "Erlangga",
                "tahun" => 2021,
                "harga" => 70000,
                "stok" => 6
            ],
            [
                "kode" => "BK-010",
                "judul" => "Desain UI/UX Modern",
                "kategori" => "Web Design",
                "pengarang" => "Dedi Santoso",
                "penerbit" => "Andi",
                "tahun" => 2024,
                "harga" => 98000,
                "stok" => 0
            ],
            [
                "kode" => "BK-011",
                "judul" => "Python untuk Data Science",
                "kategori" => "Programming",
                "pengarang" => "Rina Wijaya",
                "penerbit" => "Informatika",
                "tahun" => 2024,
                "harga" => 135000,
                "stok" => 9
            ],
            [
                "kode" => "BK-012",
                "judul" => "MongoDB Praktis",
                "kategori" => "Database",
                "pengarang" => "Ahmad Yani",
                "penerbit" => "Graha Ilmu",
                "tahun" => 2022,
                "harga" => 88000,
                "stok" => 4
            ]
        ];

        // Ambil parameter GET
        $keyword   = isset($_GET['keyword'])   ? trim($_GET['keyword'])   : '';
        $kategori  = isset($_GET['kategori'])  ? trim($_GET['kategori'])  : '';
        $min_harga = isset($_GET['min_harga']) ? trim($_GET['min_harga']) : '';
        $max_harga = isset($_GET['max_harga']) ? trim($_GET['max_harga']) : '';
        $tahun     = isset($_GET['tahun'])     ? trim($_GET['tahun'])     : '';
        $status    = isset($_GET['status'])    ? trim($_GET['status'])    : 'semua';
        $sort      = isset($_GET['sort'])      ? trim($_GET['sort'])      : 'judul';
        $page      = isset($_GET['page'])      ? (int)$_GET['page']      : 1;

        // Sanitasi
        $keyword  = htmlspecialchars($keyword);
        $kategori = htmlspecialchars($kategori);

        // Validasi
        $errors = [];
        $is_search = false;

        if (!empty($keyword) || !empty($kategori) || !empty($min_harga) || !empty($max_harga) || !empty($tahun) || $status != 'semua') {
            $is_search = true;
        }

        // 1. Validasi harga
        if (!empty($min_harga) && !empty($max_harga)) {
            if ((int)$min_harga > (int)$max_harga) {
                $errors[] = "Harga minimum tidak boleh lebih besar dari harga maksimum";
            }
        }

        // 2. Validasi tahun
        if (!empty($tahun)) {
            if (!is_numeric($tahun) || $tahun < 1900 || $tahun > date('Y')) {
                $errors[] = "Tahun harus valid (1900 - " . date('Y') . ")";
            }
        }

        // Function highlight keyword
        function highlight($text, $keyword) {
            if (empty($keyword)) return htmlspecialchars($text);
            $escaped = htmlspecialchars($text);
            $pattern = '/' . preg_quote(htmlspecialchars($keyword), '/') . '/i';
            return preg_replace($pattern, '<mark>$0</mark>', $escaped);
        }

        // Proses filter
        $hasil = [];

        if (count($errors) == 0) {
            foreach ($buku_list as $buku) {
                $match = true;

                // Filter keyword (judul atau pengarang)
                if (!empty($keyword)) {
                    if (stripos($buku['judul'], $keyword) === false &&
                        stripos($buku['pengarang'], $keyword) === false) {
                        $match = false;
                    }
                }

                // Filter kategori
                if (!empty($kategori) && $buku['kategori'] != $kategori) {
                    $match = false;
                }

                // Filter harga minimum
                if (!empty($min_harga) && $buku['harga'] < (int)$min_harga) {
                    $match = false;
                }

                // Filter harga maksimum
                if (!empty($max_harga) && $buku['harga'] > (int)$max_harga) {
                    $match = false;
                }

                // Filter tahun
                if (!empty($tahun) && is_numeric($tahun) && $buku['tahun'] != (int)$tahun) {
                    $match = false;
                }

                // Filter status ketersediaan
                if ($status == 'tersedia' && $buku['stok'] <= 0) $match = false;
                if ($status == 'habis'    && $buku['stok'] > 0)  $match = false;

                if ($match) {
                    $hasil[] = $buku;
                }
            }

            // Sorting hasil
            usort($hasil, function($a, $b) use ($sort) {
                if ($sort == 'harga_asc')  return $a['harga'] - $b['harga'];
                if ($sort == 'harga_desc') return $b['harga'] - $a['harga'];
                if ($sort == 'tahun_desc') return $b['tahun'] - $a['tahun'];
                if ($sort == 'tahun_asc')  return $a['tahun'] - $b['tahun'];
                return strcmp($a['judul'], $b['judul']); // default: judul a-z
            });
        }

        // Export CSV - harus sebelum output HTML
        if (isset($_GET['export']) && $_GET['export'] == 'csv' && count($errors) == 0) {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="hasil_pencarian.csv"');
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Kode', 'Judul', 'Kategori', 'Pengarang', 'Penerbit', 'Tahun', 'Harga', 'Stok']);
            foreach ($hasil as $buku) {
                fputcsv($out, [
                    $buku['kode'], $buku['judul'], $buku['kategori'],
                    $buku['pengarang'], $buku['penerbit'],
                    $buku['tahun'], $buku['harga'], $buku['stok']
                ]);
            }
            fclose($out);
            exit;
        }

        // Simpan recent searches ke session
        if ($is_search && count($errors) == 0 && !empty($keyword)) {
            if (!isset($_SESSION['recent_searches'])) {
                $_SESSION['recent_searches'] = [];
            }
            // Hindari duplikat
            if (!in_array($keyword, $_SESSION['recent_searches'])) {
                array_unshift($_SESSION['recent_searches'], $keyword);
                $_SESSION['recent_searches'] = array_slice($_SESSION['recent_searches'], 0, 5); // max 5
            }
        }

        // Clear session
        if (isset($_GET['clear_session'])) {
            unset($_SESSION['recent_searches']);
            header('Location: search_advanced.php');
            exit;
        }

        // Pagination
        $per_page    = 10;
        $total_hasil = count($hasil);
        $total_page  = (int)ceil($total_hasil / $per_page);
        $page        = max(1, min($page, $total_page ?: 1));
        $offset      = ($page - 1) * $per_page;
        $hasil_page  = array_slice($hasil, $offset, $per_page);

        // Query string untuk pagination & export link (tanpa page & export)
        $query_params = $_GET;
        unset($query_params['page'], $query_params['export']);
        $query_string = http_build_query($query_params);
        ?>

        <!-- Recent searches -->
        <?php if (!empty($_SESSION['recent_searches'])): ?>
        <div class="mb-3">
            <small class="text-muted"><i class="bi bi-clock-history"></i> Pencarian terakhir:</small>
            <?php foreach ($_SESSION['recent_searches'] as $recent): ?>
                <a href="?keyword=<?php echo urlencode($recent); ?>" class="badge bg-light text-dark text-decoration-none border ms-1">
                    <?php echo htmlspecialchars($recent); ?>
                </a>
            <?php endforeach; ?>
            <a href="?clear_session=1" class="badge bg-danger text-decoration-none ms-1">
                <i class="bi bi-x"></i> Hapus
            </a>
        </div>
        <?php endif; ?>

        <!-- Form pencarian -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-funnel"></i> Filter Pencarian Advanced</h5>
            </div>
            <div class="card-body">
                <!-- Error validasi -->
                <?php if (count($errors) > 0): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <div><i class="bi bi-exclamation-triangle"></i> <?php echo $error; ?></div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <form method="GET" action="">
                    <div class="row">
                        <!-- Keyword -->
                        <div class="col-md-6 mb-3">
                            <label for="keyword" class="form-label">Kata Kunci (Judul / Pengarang)</label>
                            <input type="text" class="form-control" id="keyword" name="keyword"
                                   value="<?php echo $keyword; ?>"
                                   placeholder="Masukkan kata kunci...">
                        </div>

                        <!-- Kategori -->
                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori" name="kategori">
                                <option value="">-- Semua Kategori --</option>
                                <option value="Programming" <?php echo ($kategori == 'Programming') ? 'selected' : ''; ?>>Programming</option>
                                <option value="Database"    <?php echo ($kategori == 'Database')    ? 'selected' : ''; ?>>Database</option>
                                <option value="Web Design"  <?php echo ($kategori == 'Web Design')  ? 'selected' : ''; ?>>Web Design</option>
                                <option value="Networking"  <?php echo ($kategori == 'Networking')  ? 'selected' : ''; ?>>Networking</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Harga min -->
                        <div class="col-md-3 mb-3">
                            <label for="min_harga" class="form-label">Harga Minimum (Rp)</label>
                            <input type="number" class="form-control" id="min_harga" name="min_harga"
                                   value="<?php echo $min_harga; ?>"
                                   min="0" step="10000" placeholder="0">
                        </div>

                        <!-- Harga max -->
                        <div class="col-md-3 mb-3">
                            <label for="max_harga" class="form-label">Harga Maksimum (Rp)</label>
                            <input type="number" class="form-control" id="max_harga" name="max_harga"
                                   value="<?php echo $max_harga; ?>"
                                   min="0" step="10000" placeholder="200000">
                        </div>

                        <!-- Tahun -->
                        <div class="col-md-3 mb-3">
                            <label for="tahun" class="form-label">Tahun Terbit</label>
                            <input type="number" class="form-control" id="tahun" name="tahun"
                                   value="<?php echo $tahun; ?>"
                                   min="1900" max="<?php echo date('Y'); ?>"
                                   placeholder="<?php echo date('Y'); ?>">
                        </div>

                        <!-- Sorting -->
                        <div class="col-md-3 mb-3">
                            <label for="sort" class="form-label">Urutkan</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="judul"      <?php echo ($sort == 'judul')      ? 'selected' : ''; ?>>Judul A-Z</option>
                                <option value="harga_asc"  <?php echo ($sort == 'harga_asc')  ? 'selected' : ''; ?>>Harga Terendah</option>
                                <option value="harga_desc" <?php echo ($sort == 'harga_desc') ? 'selected' : ''; ?>>Harga Tertinggi</option>
                                <option value="tahun_desc" <?php echo ($sort == 'tahun_desc') ? 'selected' : ''; ?>>Tahun Terbaru</option>
                                <option value="tahun_asc"  <?php echo ($sort == 'tahun_asc')  ? 'selected' : ''; ?>>Tahun Terlama</option>
                            </select>
                        </div>
                    </div>

                    <!-- Status ketersediaan -->
                    <div class="mb-3">
                        <label class="form-label">Status Ketersediaan</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status_semua"
                                       value="semua" <?php echo ($status == 'semua') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="status_semua">Semua</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status_tersedia"
                                       value="tersedia" <?php echo ($status == 'tersedia') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="status_tersedia">Tersedia</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status_habis"
                                       value="habis" <?php echo ($status == 'habis') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="status_habis">Habis</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Cari
                        </button>
                        <a href="search_advanced.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                        <?php if ($is_search && $total_hasil > 0 && count($errors) == 0): ?>
                        <a href="?<?php echo $query_string; ?>&export=csv" class="btn btn-success ms-auto">
                            <i class="bi bi-download"></i> Export CSV
                        </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Hasil pencarian -->
        <?php if ($is_search && count($errors) == 0): ?>
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-table"></i> Hasil Pencarian
                    <span class="badge bg-light text-dark"><?php echo $total_hasil; ?> buku ditemukan</span>
                </h5>
                <?php if ($total_page > 1): ?>
                <small>Halaman <?php echo $page; ?> dari <?php echo $total_page; ?></small>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <?php if ($total_hasil > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Harga</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = $offset + 1;
                            foreach ($hasil_page as $buku):
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><code><?php echo $buku['kode']; ?></code></td>
                                <td>
                                    <strong><?php echo highlight($buku['judul'], $keyword); ?></strong>
                                    <?php if ($buku['tahun'] >= 2024): ?>
                                        <span class="badge bg-danger">NEW</span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="badge bg-primary"><?php echo $buku['kategori']; ?></span></td>
                                <td><?php echo highlight($buku['pengarang'], $keyword); ?></td>
                                <td><?php echo $buku['penerbit']; ?></td>
                                <td><?php echo $buku['tahun']; ?></td>
                                <td>Rp <?php echo number_format($buku['harga'], 0, ',', '.'); ?></td>
                                <td class="text-center">
                                    <?php if ($buku['stok'] > 0): ?>
                                        <span class="badge bg-success"><?php echo $buku['stok']; ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Habis</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($total_page > 1): ?>
                <nav class="mt-3">
                    <ul class="pagination pagination-sm justify-content-center mb-0">
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?<?php echo $query_string; ?>&page=<?php echo $page - 1; ?>">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= $total_page; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?<?php echo $query_string; ?>&page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo ($page >= $total_page) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?<?php echo $query_string; ?>&page=<?php echo $page + 1; ?>">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>

                <!-- Info parameter pencarian -->
                <div class="alert alert-info mt-3 mb-0">
                    <strong><i class="bi bi-info-circle"></i> Parameter Pencarian:</strong>
                    <ul class="mb-0">
                        <?php if (!empty($keyword)): ?>
                            <li>Kata kunci: <strong><?php echo $keyword; ?></strong></li>
                        <?php endif; ?>
                        <?php if (!empty($kategori)): ?>
                            <li>Kategori: <strong><?php echo $kategori; ?></strong></li>
                        <?php endif; ?>
                        <?php if (!empty($min_harga)): ?>
                            <li>Harga minimal: <strong>Rp <?php echo number_format($min_harga, 0, ',', '.'); ?></strong></li>
                        <?php endif; ?>
                        <?php if (!empty($max_harga)): ?>
                            <li>Harga maksimal: <strong>Rp <?php echo number_format($max_harga, 0, ',', '.'); ?></strong></li>
                        <?php endif; ?>
                        <?php if (!empty($tahun)): ?>
                            <li>Tahun: <strong><?php echo $tahun; ?></strong></li>
                        <?php endif; ?>
                        <?php if ($status != 'semua'): ?>
                            <li>Status: <strong><?php echo ucfirst($status); ?></strong></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <?php else: ?>
                <div class="alert alert-warning mb-0">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Tidak ada buku yang ditemukan</strong> dengan kriteria pencarian tersebut.
                    Silakan coba dengan kriteria lain.
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php else: ?>
        <!-- Tampilkan semua buku jika belum search -->
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-book"></i> Semua Buku Perpustakaan
                    <span class="badge bg-light text-dark"><?php echo count($buku_list); ?> buku</span>
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Gunakan form di atas untuk mencari buku berdasarkan kriteria tertentu.
                </div>

                <div class="row">
                    <?php foreach ($buku_list as $buku): ?>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="card-title"><?php echo $buku['judul']; ?></h6>
                                <p class="card-text mb-2">
                                    <small class="text-muted">
                                        <strong><?php echo $buku['pengarang']; ?></strong> |
                                        <?php echo $buku['penerbit']; ?> (<?php echo $buku['tahun']; ?>)
                                    </small>
                                </p>
                                <p class="mb-2">
                                    <span class="badge bg-primary"><?php echo $buku['kategori']; ?></span>
                                    <?php if ($buku['stok'] > 0): ?>
                                        <span class="badge bg-success">Tersedia</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Habis</span>
                                    <?php endif; ?>
                                    <?php if ($buku['tahun'] >= 2024): ?>
                                        <span class="badge bg-danger">NEW</span>
                                    <?php endif; ?>
                                </p>
                                <p class="mb-0">
                                    <strong>Harga:</strong> Rp <?php echo number_format($buku['harga'], 0, ',', '.'); ?><br>
                                    <strong>Stok:</strong> <?php echo $buku['stok']; ?> buku
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>