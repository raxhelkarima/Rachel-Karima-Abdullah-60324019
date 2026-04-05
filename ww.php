<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <i class="bi bi-book"></i> Sistem Perpustakaan
        </a>
    </div>
</nav>

<div class="container mt-4">
    <h1 class="mb-4"><i class="bi bi-person"></i> Status Peminjaman Anggota</h1>

    <?php
    // ==========================
    // DATA ANGGOTA
    // ==========================
    $nama_anggota = "Budi Santoso";
    $total_pinjaman = 2;
    $buku_terlambat = 1;
    $hari_keterlambatan = 5;

    // ==========================
    // ATURAN
    // ==========================
    $max_pinjam = 3;
    $denda_per_hari = 1000;
    $max_denda = 50000;

    // ==========================
    // SWITCH LEVEL MEMBER
    // ==========================
    switch (true) {
        case ($total_pinjaman <= 5):
            $level = "Bronze";
            $warna_level = "secondary";
            break;
        case ($total_pinjaman <= 15):
            $level = "Silver";
            $warna_level = "info";
            break;
        default:
            $level = "Gold";
            $warna_level = "warning";
    }

    // ==========================
    // STATUS PINJAMAN (IF ELSE)
    // ==========================
    if ($buku_terlambat > 0) {
        $status = "Tidak bisa pinjam";
        $warna_status = "danger";
        $icon_status = "x-circle";
    } elseif ($total_pinjaman >= $max_pinjam) {
        $status = "Maksimal pinjaman tercapai";
        $warna_status = "warning";
        $icon_status = "exclamation-triangle";
    } else {
        $status = "Boleh meminjam";
        $warna_status = "success";
        $icon_status = "check-circle";
    }

    // ==========================
    // HITUNG DENDA
    // ==========================
    $total_denda = 0;

    if ($buku_terlambat > 0) {
        $total_denda = $buku_terlambat * $hari_keterlambatan * $denda_per_hari;

        if ($total_denda > $max_denda) {
            $total_denda = $max_denda;
        }
    }
    ?>

    <!-- CARD DATA ANGGOTA -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Informasi Anggota
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> <?php echo $nama_anggota; ?></p>
            <p><strong>Total Pinjaman:</strong> <?php echo $total_pinjaman; ?></p>
            <p>
                <strong>Level Member:</strong>
                <span class="badge bg-<?php echo $warna_level; ?>">
                    <?php echo $level; ?>
                </span>
            </p>
        </div>
    </div>

    <!-- STATUS -->
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            Status Peminjaman
        </div>
        <div class="card-body">
            <p>
                <strong>Status:</strong>
                <span class="badge bg-<?php echo $warna_status; ?>">
                    <i class="bi bi-<?php echo $icon_status; ?>"></i>
                    <?php echo $status; ?>
                </span>
            </p>

            <p>Buku Terlambat: <?php echo $buku_terlambat; ?></p>
            <p>Hari Keterlambatan: <?php echo $hari_keterlambatan; ?> hari</p>
        </div>
    </div>

    <!-- DENDA -->
    <div class="card">
        <div class="card-header bg-danger text-white">
            Informasi Denda
        </div>
        <div class="card-body">
            <?php if ($total_denda > 0): ?>
                <h5 class="text-danger">
                    Rp <?php echo number_format($total_denda, 0, ',', '.'); ?>
                </h5>
                <p class="text-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                    Anda memiliki keterlambatan!
                </p>
            <?php else: ?>
                <p class="text-success">
                    <i class="bi bi-check-circle"></i>
                    Tidak ada denda
                </p>
            <?php endif; ?>
        </div>
    </div>

</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
    <p class="mb-0">&copy; <?php echo date('Y'); ?> Sistem Perpustakaan</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>