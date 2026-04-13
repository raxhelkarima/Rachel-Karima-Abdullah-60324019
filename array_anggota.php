<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4"><i class="bi bi-people"></i> Data Anggota Perpustakaan</h2>

<?php
$anggota_list = [
    [
        "id" => "AGT-001",
        "nama" => "Budi Santoso",
        "email" => "budi@email.com",
        "telepon" => "081234567890",
        "alamat" => "Jakarta",
        "tanggal_daftar" => "2024-01-15",
        "status" => "Aktif",
        "total_pinjaman" => 5
    ],
    [
        "id" => "AGT-002",
        "nama" => "Siti Aminah",
        "email" => "siti@email.com",
        "telepon" => "082345678901",
        "alamat" => "Bandung",
        "tanggal_daftar" => "2024-02-10",
        "status" => "Aktif",
        "total_pinjaman" => 8
    ],
    [
        "id" => "AGT-003",
        "nama" => "Andi Wijaya",
        "email" => "andi@email.com",
        "telepon" => "083456789012",
        "alamat" => "Surabaya",
        "tanggal_daftar" => "2024-03-05",
        "status" => "Non-Aktif",
        "total_pinjaman" => 2
    ],
    [
        "id" => "AGT-004",
        "nama" => "Rina Putri",
        "email" => "rina@email.com",
        "telepon" => "084567890123",
        "alamat" => "Semarang",
        "tanggal_daftar" => "2024-01-20",
        "status" => "Aktif",
        "total_pinjaman" => 10
    ],
    [
        "id" => "AGT-005",
        "nama" => "Dedi Kurniawan",
        "email" => "dedi@email.com",
        "telepon" => "085678901234",
        "alamat" => "Yogyakarta",
        "tanggal_daftar" => "2024-02-25",
        "status" => "Non-Aktif",
        "total_pinjaman" => 1
    ]
];

function total_anggota($data){ return count($data); }

function hitung_status($data){
    $aktif=0; $non=0;
    foreach($data as $a){
        $a["status"]=="Aktif" ? $aktif++ : $non++;
    }
    return ["aktif"=>$aktif,"non"=>$non];
}

function anggota_teraktif($data){
    $max=$data[0];
    foreach($data as $a){
        if($a["total_pinjaman"]>$max["total_pinjaman"]){
            $max=$a;
        }
    }
    return $max;
}

function rata_pinjaman($data){
    $total=0;
    foreach($data as $a){ $total+=$a["total_pinjaman"]; }
    return $total/count($data);
}

function filter_status($data,$status){
    $hasil=[];
    foreach($data as $a){
        if($a["status"]==$status){ $hasil[]=$a; }
    }
    return $hasil;
}

$total = total_anggota($anggota_list);
$status = hitung_status($anggota_list);
$teraktif = anggota_teraktif($anggota_list);
$rata = rata_pinjaman($anggota_list);

$filter = isset($_GET["status"]) ? $_GET["status"] : "Semua";

if($filter=="Aktif" || $filter=="Non-Aktif"){
    $data_tampil = filter_status($anggota_list,$filter);
} else {
    $data_tampil = $anggota_list;
}

$persen_aktif = ($status["aktif"]/$total)*100;
$persen_non = ($status["non"]/$total)*100;
?>

<!-- statistik -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center border-primary">
            <div class="card-body">
                <h6>Total</h6>
                <h3><?php echo $total; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-success">
            <div class="card-body">
                <h6>Aktif</h6>
                <h3><?php echo number_format($persen_aktif,1); ?>%</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-danger">
            <div class="card-body">
                <h6>Non</h6>
                <h3><?php echo number_format($persen_non,1); ?>%</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-warning">
            <div class="card-body">
                <h6>Rata</h6>
                <h3><?php echo number_format($rata,1); ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- anggota teraktif -->
<div class="card mb-4">
    <div class="card-header bg-warning">
        <i class="bi bi-trophy"></i> anggota teraktif
    </div>
    <div class="card-body">
        <strong><?php echo $teraktif["nama"]; ?></strong>
        <span class="badge bg-success"><?php echo $teraktif["total_pinjaman"]; ?> pinjaman</span>    </div>
</div>

<!-- filter -->
<form method="GET" class="mb-3">
    <select name="status" class="form-select w-25 d-inline">
        <option>Semua</option>
        <option>Aktif</option>
        <option>Non-Aktif</option>
    </select>
    <button class="btn btn-primary">filter</button>
</form>

<!-- tabel -->
<div class="card">
    <div class="card-header bg-primary text-white">
        daftar anggota
    </div>
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Pinjaman</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($data_tampil as $a): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><code><?php echo $a["id"]; ?></code></td>
                    <td><?php echo $a["nama"]; ?></td>
                    <td>
                        <span class="badge bg-<?php echo $a["status"]=="Aktif"?"success":"secondary"; ?>">
                            <?php echo $a["status"]; ?>
                        </span>
                    </td>
                    <td><span class="badge bg-info"><?php echo $a["total_pinjaman"]; ?></span></td>
                    <td><?php echo $a["tanggal_daftar"]; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</div>
</body>
</html>