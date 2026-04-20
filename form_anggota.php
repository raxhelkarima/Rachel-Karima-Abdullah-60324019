<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php
                // Function sanitasi
                function sanitize_input($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                // Variabel untuk error per field
                $errors = [];
                $success = '';

                // Variabel untuk keep value
                $nama = '';
                $email = '';
                $telepon = '';
                $alamat = '';
                $jenis_kelamin = '';
                $tanggal_lahir = '';
                $pekerjaan = '';

                // Proses form
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Terima dan sanitasi data
                    $nama = sanitize_input($_POST['nama'] ?? '');
                    $email = sanitize_input($_POST['email'] ?? '');
                    $telepon = sanitize_input($_POST['telepon'] ?? '');
                    $alamat = sanitize_input($_POST['alamat'] ?? '');
                    $jenis_kelamin = sanitize_input($_POST['jenis_kelamin'] ?? '');
                    $tanggal_lahir = sanitize_input($_POST['tanggal_lahir'] ?? '');
                    $pekerjaan = sanitize_input($_POST['pekerjaan'] ?? '');

                    // Validasi per field

                    // 1. Nama lengkap
                    if (empty($nama)) {
                        $errors['nama'] = "Nama lengkap wajib diisi";
                    } elseif (strlen($nama) < 3) {
                        $errors['nama'] = "Nama minimal 3 karakter";
                    }

                    // 2. Email
                    if (empty($email)) {
                        $errors['email'] = "Email wajib diisi";
                    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors['email'] = "Format email tidak valid";
                    }

                    // 3. Telepon (format 08xxxxxxxxxx, 10-13 digit)
                    if (empty($telepon)) {
                        $errors['telepon'] = "Telepon wajib diisi";
                    } elseif (!preg_match('/^08[0-9]{8,11}$/', $telepon)) {
                        $errors['telepon'] = "Format telepon tidak valid (contoh: 08123456789)";
                    }

                    // 4. Alamat
                    if (empty($alamat)) {
                        $errors['alamat'] = "Alamat wajib diisi";
                    } elseif (strlen($alamat) < 10) {
                        $errors['alamat'] = "Alamat minimal 10 karakter";
                    }

                    // 5. Jenis kelamin
                    if (empty($jenis_kelamin)) {
                        $errors['jenis_kelamin'] = "Jenis kelamin wajib dipilih";
                    } else {
                        $valid_jk = ['Laki-laki', 'Perempuan'];
                        if (!in_array($jenis_kelamin, $valid_jk)) {
                            $errors['jenis_kelamin'] = "Jenis kelamin tidak valid";
                        }
                    }

                    // 6. Tanggal lahir (umur minimal 10 tahun)
                    if (empty($tanggal_lahir)) {
                        $errors['tanggal_lahir'] = "Tanggal lahir wajib diisi";
                    } else {
                        $lahir = new DateTime($tanggal_lahir);
                        $sekarang = new DateTime();
                        $umur = $sekarang->diff($lahir)->y;
                        if ($umur < 10) {
                            $errors['tanggal_lahir'] = "Umur minimal 10 tahun";
                        }
                    }

                    // 7. Pekerjaan
                    if (empty($pekerjaan)) {
                        $errors['pekerjaan'] = "Pekerjaan wajib dipilih";
                    } else {
                        $valid_pekerjaan = ['Pelajar', 'Mahasiswa', 'Pegawai', 'Lainnya'];
                        if (!in_array($pekerjaan, $valid_pekerjaan)) {
                            $errors['pekerjaan'] = "Pekerjaan tidak valid";
                        }
                    }

                    // Jika tidak ada error
                    if (count($errors) == 0) {
                        $success = "Registrasi anggota berhasil!";
                    }
                }
                ?>

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-person-plus"></i> Registrasi Anggota Perpustakaan</h4>
                    </div>
                    <div class="card-body">
                        <!-- Success Message -->
                        <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle-fill"></i> <strong>Berhasil!</strong> <?php echo $success; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>

                        <!-- Card data anggota -->
                        <div class="card mb-4 border-success">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0"><i class="bi bi-person-check"></i> Data Anggota Terdaftar</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless mb-0">
                                    <tr><th width="150">Nama Lengkap</th><td>: <?php echo htmlspecialchars($nama); ?></td></tr>
                                    <tr><th>Email</th><td>: <?php echo htmlspecialchars($email); ?></td></tr>
                                    <tr><th>Telepon</th><td>: <?php echo htmlspecialchars($telepon); ?></td></tr>
                                    <tr><th>Alamat</th><td>: <?php echo htmlspecialchars($alamat); ?></td></tr>
                                    <tr><th>Jenis Kelamin</th><td>: <?php echo htmlspecialchars($jenis_kelamin); ?></td></tr>
                                    <tr><th>Tanggal Lahir</th><td>: <?php echo htmlspecialchars($tanggal_lahir); ?></td></tr>
                                    <tr><th>Pekerjaan</th><td>: <?php echo htmlspecialchars($pekerjaan); ?></td></tr>
                                </table>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Global Error Summary -->
                        <?php if (count($errors) > 0): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <h6><i class="bi bi-exclamation-triangle-fill"></i> Terdapat <?php echo count($errors); ?> kesalahan:</h6>
                            <ul class="mb-0">
                                <?php foreach ($errors as $field => $error): ?>
                                    <li><strong><?php echo ucfirst(str_replace('_', ' ', $field)); ?>:</strong> <?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <form method="POST" action="" novalidate>
                            <!-- Nama lengkap -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control <?php echo isset($errors['nama']) ? 'is-invalid' : ''; ?>"
                                       id="nama"
                                       name="nama"
                                       value="<?php echo htmlspecialchars($nama); ?>"
                                       placeholder="Masukkan nama lengkap">
                                <?php if (isset($errors['nama'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $errors['nama']; ?>
                                </div>
                                <?php endif; ?>
                                <small class="text-muted">Minimal 3 karakter</small>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email"
                                       class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>"
                                       id="email"
                                       name="email"
                                       value="<?php echo htmlspecialchars($email); ?>"
                                       placeholder="contoh@email.com">
                                <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $errors['email']; ?>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Telepon -->
                            <div class="mb-3">
                                <label for="telepon" class="form-label">
                                    Telepon <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control <?php echo isset($errors['telepon']) ? 'is-invalid' : ''; ?>"
                                       id="telepon"
                                       name="telepon"
                                       value="<?php echo htmlspecialchars($telepon); ?>"
                                       placeholder="08123456789">
                                <?php if (isset($errors['telepon'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $errors['telepon']; ?>
                                </div>
                                <?php endif; ?>
                                <small class="text-muted">Format: 08xxxxxxxxxx (10-13 digit)</small>
                            </div>

                            <!-- Alamat -->
                            <div class="mb-3">
                                <label for="alamat" class="form-label">
                                    Alamat <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control <?php echo isset($errors['alamat']) ? 'is-invalid' : ''; ?>"
                                          id="alamat"
                                          name="alamat"
                                          rows="3"
                                          placeholder="Masukkan alamat lengkap"><?php echo htmlspecialchars($alamat); ?></textarea>
                                <?php if (isset($errors['alamat'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $errors['alamat']; ?>
                                </div>
                                <?php endif; ?>
                                <small class="text-muted">Minimal 10 karakter</small>
                            </div>

                            <!-- Jenis kelamin & tanggal lahir -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Jenis Kelamin <span class="text-danger">*</span>
                                    </label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input <?php echo isset($errors['jenis_kelamin']) ? 'is-invalid' : ''; ?>"
                                                   type="radio"
                                                   name="jenis_kelamin"
                                                   id="jk_laki"
                                                   value="Laki-laki"
                                                   <?php echo ($jenis_kelamin == 'Laki-laki') ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="jk_laki">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input"
                                                   type="radio"
                                                   name="jenis_kelamin"
                                                   id="jk_perempuan"
                                                   value="Perempuan"
                                                   <?php echo ($jenis_kelamin == 'Perempuan') ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="jk_perempuan">Perempuan</label>
                                        </div>
                                        <?php if (isset($errors['jenis_kelamin'])): ?>
                                        <div class="text-danger small">
                                            <?php echo $errors['jenis_kelamin']; ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_lahir" class="form-label">
                                        Tanggal Lahir <span class="text-danger">*</span>
                                    </label>
                                    <input type="date"
                                           class="form-control <?php echo isset($errors['tanggal_lahir']) ? 'is-invalid' : ''; ?>"
                                           id="tanggal_lahir"
                                           name="tanggal_lahir"
                                           value="<?php echo htmlspecialchars($tanggal_lahir); ?>"
                                           max="<?php echo date('Y-m-d'); ?>">
                                    <?php if (isset($errors['tanggal_lahir'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['tanggal_lahir']; ?>
                                    </div>
                                    <?php endif; ?>
                                    <small class="text-muted">Umur minimal 10 tahun</small>
                                </div>
                            </div>

                            <!-- Pekerjaan -->
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">
                                    Pekerjaan <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?php echo isset($errors['pekerjaan']) ? 'is-invalid' : ''; ?>"
                                        id="pekerjaan"
                                        name="pekerjaan">
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    <option value="Pelajar" <?php echo ($pekerjaan == 'Pelajar') ? 'selected' : ''; ?>>Pelajar</option>
                                    <option value="Mahasiswa" <?php echo ($pekerjaan == 'Mahasiswa') ? 'selected' : ''; ?>>Mahasiswa</option>
                                    <option value="Pegawai" <?php echo ($pekerjaan == 'Pegawai') ? 'selected' : ''; ?>>Pegawai</option>
                                    <option value="Lainnya" <?php echo ($pekerjaan == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                                </select>
                                <?php if (isset($errors['pekerjaan'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $errors['pekerjaan']; ?>
                                </div>
                                <?php endif; ?>
                            </div>

                            <hr>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-save"></i> Daftar Anggota
                                </button>
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Reset Form
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>