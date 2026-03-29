<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perhitungan Diskon - Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Sistem Perhitungan Diskon Bertingkat</h1>
        
        <?php
        // Data pembeli dan buku
        $nama_pembeli = "almira naraya";
        $judul_buku = "psikologi informatika";
        $harga_satuan = 75000;
        $jumlah_beli = 6;
        $is_member = true;

        // Hitung subtotal
        $subtotal = $harga_satuan * $jumlah_beli;

        // Diskon berdasarkan jumlah
        if ($jumlah_beli >= 1 && $jumlah_beli <= 2) {
            $persentase_diskon = 0;
        } elseif ($jumlah_beli >= 3 && $jumlah_beli <= 5) {
            $persentase_diskon = 10;
        } elseif ($jumlah_beli >= 6 && $jumlah_beli <= 10) {
            $persentase_diskon = 15;
        } else {
            $persentase_diskon = 20;
        }

        // Hitung diskon
        $diskon = $subtotal * ($persentase_diskon / 100);

        // Total setelah diskon pertama
        $total_setelah_diskon1 = $subtotal - $diskon;

        // Hitung diskon member jika member
        $diskon_member = 0;
        if ($is_member) {
            $diskon_member = $total_setelah_diskon1 * 0.05;
        }

        // Total setelah semua diskon
        $total_setelah_diskon = $total_setelah_diskon1 - $diskon_member;

        // Hitung PPN
        $ppn = $total_setelah_diskon * 0.11;

        // Total akhir
        $total_akhir = $total_setelah_diskon + $ppn;

        // Total penghematan
        $total_hemat = $diskon + $diskon_member;
        ?>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Detail Pembelian</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th width="250">Nama Pembeli</th>
                                <td>: <?php echo $nama_pembeli; ?></td>
                            </tr>
                            <tr>
                                <th>Judul Buku</th>
                                <td>: <?php echo $judul_buku; ?></td>
                            </tr>
                            <tr>
                                <th>Harga Satuan</th>
                                <td>: Rp <?php echo number_format($harga_satuan,0,',','.'); ?></td>
                            </tr>
                            <tr>
                                <th>Jumlah Beli</th>
                                <td>: <?php echo $jumlah_beli; ?> buku</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>: 
                                    <?php echo $is_member ? 
                                    "<span class='badge bg-success'>Member</span>" : 
                                    "<span class='badge bg-secondary'>Non Member</span>"; ?>
                                </td>
                            </tr>

                            <tr class="table-secondary">
                                <th>Subtotal</th>
                                <td>: Rp <?php echo number_format($subtotal,0,',','.'); ?></td>
                            </tr>

                            <tr class="text-success">
                                <th>Diskon (<?php echo $persentase_diskon; ?>%)</th>
                                <td>: - Rp <?php echo number_format($diskon,0,',','.'); ?></td>
                            </tr>

                            <?php if ($is_member) { ?>
                            <tr class="text-success">
                                <th>Diskon Member (5%)</th>
                                <td>: - Rp <?php echo number_format($diskon_member,0,',','.'); ?></td>
                            </tr>
                            <?php } ?>

                            <tr class="table-secondary">
                                <th>Total Setelah Diskon</th>
                                <td>: Rp <?php echo number_format($total_setelah_diskon,0,',','.'); ?></td>
                            </tr>

                            <tr>
                                <th>PPN (11%)</th>
                                <td>: + Rp <?php echo number_format($ppn,0,',','.'); ?></td>
                            </tr>

                            <tr class="table-primary fw-bold">
                                <th>TOTAL AKHIR</th>
                                <td>: Rp <?php echo number_format($total_akhir,0,',','.'); ?></td>
                            </tr>

                            <tr class="table-warning">
                                <th>Total Hemat</th>
                                <td>: Rp <?php echo number_format($total_hemat,0,',','.'); ?></td>
                            </tr>
                        </table>

                        <?php if ($persentase_diskon > 0): ?>
                        <div class="alert alert-success">
                            Anda mendapat diskon <?php echo $persentase_diskon; ?>%
                            karena membeli <?php echo $jumlah_beli; ?> buku.
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>