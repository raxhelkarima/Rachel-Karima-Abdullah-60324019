<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Buku - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Informasi Buku</h1>
        
        <?php
        // buku 1
        $judul1 = "Laravel: From Beginner to Advanced";
        $pengarang1 = "Budi Raharjo";
        $penerbit1 = "Informatika";
        $tahun_terbit1 = 2023;
        $harga1 = 12500;
        $stok1 = 8;
        $isbn1 = "978-602-1234-56-7";
        $kategori1 = "Programming";
        $bahasa1 = "Indonesia";
        $halaman1 = 300;
        $berat1 = 500;

        // buku 2 
        $judul2 = "MySQL Database Administration";
        $pengarang2 = "Andi Setiawan";
        $penerbit2 = "Elex Media";
        $tahun_terbit2 = 2022;
        $harga2 = 15000;
        $stok2 = 5;
        $isbn2 = "978-602-1111-22-3";
        $kategori2 = "Database";
        $bahasa2 = "Inggris";
        $halaman2 = 400;
        $berat2 = 600;

        // buku 3
        $judul3 = "Desain Web Modern";
        $pengarang3 = "Siti Nurhaliza";
        $penerbit3 = "Informatika";
        $tahun_terbit3 = 2021;
        $harga3 = 10000;
        $stok3 = 10;
        $isbn3 = "978-602-3333-44-5";
        $kategori3 = "Web Design";
        $bahasa3 = "Indonesia";
        $halaman3 = 250;
        $berat3 = 400;

        // buku 4
        $judul4 = "JavaScript Advanced";
        $pengarang4 = "Ahmad Fauzi";
        $penerbit4 = "Gramedia";
        $tahun_terbit4 = 2023;
        $harga4 = 18000;
        $stok4 = 7;
        $isbn4 = "978-602-9999-88-7";
        $kategori4 = "Programming";
        $bahasa4 = "Inggris";
        $halaman4 = 350;
        $berat4 = 550;
        ?>
        
        <!-- card buku 1 -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><?php echo $judul1; ?>
                <span class="badge bg-success"><?php echo $kategori1; ?></span>
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Pengarang</th>
                        <td>: <?php echo $pengarang1; ?></td>
                    </tr>
                    <tr>
                        <th>Penerbit</th>
                        <td>: <?php echo $penerbit1; ?></td>
                    </tr>
                    <tr>
                        <th>Tahun Terbit</th>
                        <td>: <?php echo $tahun_terbit1; ?></td>
                    </tr>
                    <tr>
                        <th>ISBN</th>
                        <td>: <?php echo $isbn1; ?></td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>: Rp <?php echo number_format($harga1, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td>: <?php echo $stok1; ?> buku</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>: <?php echo $kategori1; ?></td>
                    </tr>
                    <tr>
                        <th>Bahasa</th>
                        <td>: <?php echo $bahasa1; ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Halaman</th>
                        <td>: <?php echo $halaman1; ?> halaman</td>
                    </tr>
                    <tr>
                        <th>Berat</th>
                        <td>: <?php echo $berat1; ?> gram</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- card buku 2 -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><?php echo $judul2; ?>
                <span class="badge bg-warning"><?php echo $kategori2; ?></span>
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Pengarang</th>
                        <td>: <?php echo $pengarang2; ?></td>
                    </tr>
                    <tr>
                        <th>Penerbit</th>
                        <td>: <?php echo $penerbit2; ?></td>
                    </tr>
                    <tr>
                        <th>Tahun Terbit</th>
                        <td>: <?php echo $tahun_terbit2; ?></td>
                    </tr>
                    <tr>
                        <th>ISBN</th>
                        <td>: <?php echo $isbn2; ?></td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>: Rp <?php echo number_format($harga2, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td>: <?php echo $stok2; ?> buku</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>: <?php echo $kategori2; ?></td>
                    </tr>
                    <tr>
                        <th>Bahasa</th>
                        <td>: <?php echo $bahasa2; ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Halaman</th>
                        <td>: <?php echo $halaman2; ?> halaman</td>
                    </tr>
                    <tr>
                        <th>Berat</th>
                        <td>: <?php echo $berat2; ?> gram</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- card buku 3 -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><?php echo $judul3; ?>
                <span class="badge bg-info"><?php echo $kategori3; ?></span>
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Pengarang</th>
                        <td>: <?php echo $pengarang3; ?></td>
                    </tr>
                    <tr>
                        <th>Penerbit</th>
                        <td>: <?php echo $penerbit3; ?></td>
                    </tr>
                    <tr>
                        <th>Tahun Terbit</th>
                        <td>: <?php echo $tahun_terbit3; ?></td>
                    </tr>
                    <tr>
                        <th>ISBN</th>
                        <td>: <?php echo $isbn3; ?></td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>: Rp <?php echo number_format($harga3, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td>: <?php echo $stok3; ?> buku</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>: <?php echo $kategori3; ?></td>
                    </tr>
                    <tr>
                        <th>Bahasa</th>
                        <td>: <?php echo $bahasa3; ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Halaman</th>
                        <td>: <?php echo $halaman3; ?> halaman</td>
                    </tr>
                    <tr>
                        <th>Berat</th>
                        <td>: <?php echo $berat3; ?> gram</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- card buku 4 -->
        <div class="card mb-4">
           <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><?php echo $judul4; ?>
                <span class="badge bg-success"><?php echo $kategori4; ?></span>
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Pengarang</th>
                        <td>: <?php echo $pengarang4; ?></td>
                    </tr>
                    <tr>
                        <th>Penerbit</th>
                        <td>: <?php echo $penerbit4; ?></td>
                    </tr>
                    <tr>
                        <th>Tahun Terbit</th>
                        <td>: <?php echo $tahun_terbit4; ?></td>
                    </tr>
                    <tr>
                        <th>ISBN</th>
                        <td>: <?php echo $isbn4; ?></td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>: Rp <?php echo number_format($harga4, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td>: <?php echo $stok4; ?> buku</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>: <?php echo $kategori4; ?></td>
                    </tr>
                    <tr>
                        <th>Bahasa</th>
                        <td>: <?php echo $bahasa4; ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Halaman</th>
                        <td>: <?php echo $halaman4; ?> halaman</td>
                    </tr>
                    <tr>
                        <th>Berat</th>
                        <td>: <?php echo $berat4; ?> gram</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>