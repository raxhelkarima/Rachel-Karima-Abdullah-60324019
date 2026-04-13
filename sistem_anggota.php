<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>

<?php
// Include functions
require_once 'functions_anggota.php';

// Data anggota
$anggota_list = [
    [
        "id" => 1,
        "nama" => "Andi Baharudin",
        "email" => "andi@gmail.com",
        "status" => "Aktif",
        "total_pinjaman" => 5,
        "tanggal_daftar" => "2024-01-10"
    ],
    [
        "id" => 2,
        "nama" => "Budi Amanila",
        "email" => "budi@gmail.com",
        "status" => "Non-Aktif",
        "total_pinjaman" => 2,
        "tanggal_daftar" => "2023-12-01"
    ],
    [
        "id" => 3,
        "nama" => "Citra Lestari",
        "email" => "citra@gmail.com",
        "status" => "Aktif",
        "total_pinjaman" => 8,
        "tanggal_daftar" => "2024-02-15"
    ],
    [
        "id" => 4,
        "nama" => "Dewi Aulia",
        "email" => "dewi@gmail",
        "status" => "Aktif",
        "total_pinjaman" => 3,
        "tanggal_daftar" => "2024-03-20"
    ],
    [
        "id" => 5,
        "nama" => "Eko Fauzan",
        "email" => "eko@gmail.com",
        "status" => "Non-Aktif",
        "total_pinjaman" => 1,
        "tanggal_daftar" => "2023-11-11"
    ]
];

// proses data
$total = hitung_total_anggota($anggota_list);
$aktif = hitung_anggota_aktif($anggota_list);
$non = $total - $aktif;
$rata = hitung_rata_rata_pinjaman($anggota_list);
$teraktif = cari_anggota_teraktif($anggota_list);

$anggota_aktif = filter_by_status($anggota_list, "Aktif");
$anggota_non = filter_by_status($anggota_list, "Non-Aktif");

$sorted = sort_nama($anggota_list);

// search fleksibel (id + nama)
$keyword = isset($_GET["cari"]) ? $_GET["cari"] : "";
$hasil_search = [];

if ($keyword) {
    if (is_numeric($keyword)) {
        $hasil = cari_anggota_by_id($anggota_list, $keyword);
        if ($hasil) {
            $hasil_search[] = $hasil;
        }
    } else {
        $hasil_search = search_nama($anggota_list, $keyword);
    }
}

function badge_status($status){
    return $status=="Aktif"
        ? '<span class="badge bg-success">Aktif</span>'
        : '<span class="badge bg-secondary">Non-Aktif</span>';
}
?>

<div class="container mt-5">

<h1 class="mb-4"><i class="bi bi-people"></i> Sistem Anggota</h1>

<!-- dashboard -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-primary text-center">
            <div class="card-body">
                <h6>Total</h6>
                <h3><?php echo $total; ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-success text-center">
            <div class="card-body">
                <h6>Aktif</h6>
                <h3><?php echo $aktif; ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-secondary text-center">
            <div class="card-body">
                <h6>Non-Aktif</h6>
                <h3><?php echo $non; ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-warning text-center">
            <div class="card-body">
                <h6>Rata Pinjaman</h6>
                <h3><?php echo number_format($rata,1); ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- tabel anggota -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        Daftar Anggota
    </div>
    <div class="card-body">

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Pinjaman</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sorted as $a): ?>
                <tr>
                    <td><code><?php echo $a["id"]; ?></code></td>
                    <td><?php echo $a["nama"]; ?></td>
                    <td>
                        <?php echo $a["email"]; ?>
                        <?php if (!validasi_email($a["email"])): ?>
                            <span class="badge bg-danger">invalid</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo badge_status($a["status"]); ?></td>
                    <td><span class="badge bg-info"><?php echo $a["total_pinjaman"]; ?></span></td>
                    <td><?php echo format_tanggal_indo($a["tanggal_daftar"]); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<!-- anggota teraktif -->
<div class="card mb-4">
    <div class="card-header bg-success text-white">
        Anggota Teraktif
    </div>
    <div class="card-body">
        <h4><?php echo $teraktif["nama"]; ?></h4>
        <span class="badge bg-success"><?php echo $teraktif["total_pinjaman"]; ?> pinjaman</span>
    </div>
</div>

<!-- aktif vs non aktif -->
<div class="row">

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                Anggota Aktif
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($anggota_aktif as $a): ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <?php echo $a["nama"]; ?>
                        <span class="badge bg-success"><?php echo $a["total_pinjaman"]; ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                Anggota Non-Aktif
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($anggota_non as $a): ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <?php echo $a["nama"]; ?>
                        <span class="badge bg-secondary"><?php echo $a["total_pinjaman"]; ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

</div>

<!-- search -->
<div class="card mt-4">
    <div class="card-header bg-dark text-white">
        Pencarian Anggota
    </div>
    <div class="card-body">

        <form method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="cari" class="form-control" placeholder="cari nama atau id..." value="<?php echo $keyword; ?>">
                <button class="btn btn-primary">Cari</button>
            </div>
        </form>

        <?php if($keyword): ?>
            <?php if(count($hasil_search) > 0): ?>
                <?php foreach ($hasil_search as $a): ?>
                    <span class="badge bg-success"><?php echo $a["nama"]; ?></span>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-warning">tidak ditemukan</div>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</div>

</div>

</body>
</html>