<?php
// 1. Function untuk hitung total anggota
function hitung_total_anggota($anggota_list) {
    return count($anggota_list);
}

// 2. Function untuk hitung anggota aktif
function hitung_anggota_aktif($anggota_list) {
    $total = 0;
    foreach ($anggota_list as $a) {
        if ($a["status"] == "Aktif") {
            $total++;
        }
    }
    return $total;
}

// 3. Function untuk hitung rata-rata pinjaman
function hitung_rata_rata_pinjaman($anggota_list) {
    if (count($anggota_list) == 0) {
        return 0;
    }

    $total = 0;
    foreach ($anggota_list as $a) {
        $total += $a["total_pinjaman"];
    }
    return $total / count($anggota_list);
}

// 4. Function untuk cari anggota by ID
function cari_anggota_by_id($anggota_list, $id) {
    foreach ($anggota_list as $a) {
        if ($a["id"] == $id) {
            return $a;
        }
    }
    return null;
}

// 5. Function untuk cari anggota teraktif
function cari_anggota_teraktif($anggota_list) {
    if (empty($anggota_list)) {
        return null;
    }

    $teraktif = $anggota_list[0];

    foreach ($anggota_list as $a) {
        if ($a["total_pinjaman"] > $teraktif["total_pinjaman"]) {
            $teraktif = $a;
        }
    }
    return $teraktif;
}

// 6. Function untuk filter by status
function filter_by_status($anggota_list, $status) {
    $hasil = [];
    foreach ($anggota_list as $a) {
        if ($a["status"] == $status) {
            $hasil[] = $a;
        }
    }
    return $hasil;
}

// 7. Function untuk validasi email
function validasi_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// 8. Function untuk format tanggal Indonesia
function format_tanggal_indo($tanggal) {
    $bulan = [
        1 => "Januari","Februari","Maret","April","Mei","Juni",
        "Juli","Agustus","September","Oktober","November","Desember"
    ];

    $pecah = explode("-", $tanggal);

    if (count($pecah) != 3) {
        return $tanggal;
    }

    return $pecah[2] . " " . $bulan[(int)$pecah[1]] . " " . $pecah[0];
}

// bonus: sort anggota by nama (A-Z)
function sort_nama($anggota_list) {
    usort($anggota_list, function($a, $b) {
        return strcmp($a["nama"], $b["nama"]);
    });
    return $anggota_list;
}

// bonus: search anggota by nama
function search_nama($anggota_list, $keyword) {
    $hasil = [];
    foreach ($anggota_list as $a) {
        if (stripos($a["nama"], $keyword) !== false) {
            $hasil[] = $a;
        }
    }
    return $hasil;
}
?>