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

<div class="container mt-5">
    <h1 class="mb-4">Status Peminjaman Anggota</h1>

    <?php
    // DATA
    $nama_anggota = "Budi Santoso";
    $total_pinjaman = 2;
    $buku_terlambat = 1;
    $hari_keterlambatan = 5;

    // ATURAN
    $maks_pinjam = 3;
    $denda_per_hari = 1000;
    $maks_denda = 50000;

    // HITUNG DENDA
    $total_denda = 0;
    if ($buku_terlambat > 0) {
        $total_denda = $buku_terlambat * $hari_keterlambatan * $denda_per_hari;

        if ($total_denda > $maks_denda) {
            $total_denda = $maks_denda;
        }
    }

    // CEK STATUS PINJAM
    if ($buku_terlambat > 0) {
        $status_pinjam = "Tidak bisa meminjam (ada keterlambatan)";
        $badge = "danger";
        $icon = "x-circle";
    } elseif ($total_pinjaman >= $maks_pinjam) {
        $status_pinjam = "Tidak bisa meminjam (mencapai batas)";
        $badge = "warning";
        $icon = "exclamation-triangle";
    } else {
        $status_pinjam = "Bisa meminjam";
        $badge = "success";
        $icon = "check-circle";
    }

    // LEVEL MEMBER
    if ($total_pinjaman < 0) {
        $level = "Data tidak valid";
    } else {

        switch (true) {
            case ($total_pinjaman <= 5):
                $level = "Bronze";
                $warna_level = "primary";
                break;
            case ($total_pinjaman <= 15):
                $level = "Silver";
                $warna_level = "secondary";
                break;
            default:
                $level = "Gold";
                $warna_level = "warning";
                break;
        }

    }
    ?>

    <!-- informasi anggota -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-person"></i> Informasi Anggota
            </h5>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th width="250">Nama Anggota</th>
                    <td>: <?php echo $nama_anggota; ?></td>
                </tr>
                <tr>
                    <th>Total Peminjaman</th>
                    <td>: <?php echo $total_pinjaman; ?> buku</td>
                </tr>
                <tr>
                    <th>Level Member</th>
                    <td>:
                        <span class="badge bg-<?php echo $warna_level; ?>">
                            <?php echo $level; ?>
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- status peminjaman -->
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">
                <i class="bi bi-clipboard-check"></i> Status Peminjaman
            </h5>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th width="250">Buku Terlambat</th>
                    <td>: <?php echo $buku_terlambat; ?> buku</td>
                </tr>
                <tr>
                    <th>Hari Keterlambatan</th>
                    <td>: <?php echo $hari_keterlambatan; ?> hari</td>
                </tr>
                <tr class="table-secondary">
                    <th>Total Denda</th>
                    <td>: Rp <?php echo number_format($total_denda,0,',','.'); ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>:
                        <span class="badge bg-<?php echo $badge; ?>">
                            <i class="bi bi-<?php echo $icon; ?>"></i>
                            <?php echo $status_pinjam; ?>
                        </span>
                    </td>
                </tr>
            </table>

            <!-- PERINGATAN -->
            <?php if ($buku_terlambat > 0): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                    Anda memiliki keterlambatan, harap segera mengembalikan.
                </div>
            <?php endif; ?>

        </div>
    </div>

</div>
</body>
</html>