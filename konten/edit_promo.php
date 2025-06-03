<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// Validasi ID promo
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID promo tidak valid.</div>";
    exit;
}

$id = intval($_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM promo WHERE id = $id");
if (!$query || mysqli_num_rows($query) === 0) {
    echo "<div class='alert alert-warning'>Promo tidak ditemukan untuk ID: $id</div>";
    exit;
}
$promo = mysqli_fetch_assoc($query);

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipe_diskon = $_POST['tipe_diskon'];
    $nilai_diskon = $_POST['nilai_diskon'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_berakhir = $_POST['tanggal_berakhir'];

    if (!empty($promo['kode'])) {
        $kode = $_POST['kode'];
        $minimal_belanja = $_POST['minimal_belanja'];
        $kuota = $_POST['kuota'];

        $stmt = $conn->prepare("UPDATE promo SET kode=?, tipe_diskon=?, nilai_diskon=?, minimal_belanja=?, kuota=?, tanggal_mulai=?, tanggal_berakhir=? WHERE id=?");
        $stmt->bind_param("ssddissi", $kode, $tipe_diskon, $nilai_diskon, $minimal_belanja, $kuota, $tanggal_mulai, $tanggal_berakhir, $id);
    } else {
        $id_produk = $_POST['id_produk'];

        $stmt = $conn->prepare("UPDATE promo SET id_produk=?, tipe_diskon=?, nilai_diskon=?, tanggal_mulai=?, tanggal_berakhir=? WHERE id=?");
        $stmt->bind_param("isdssi", $id_produk, $tipe_diskon, $nilai_diskon, $tanggal_mulai, $tanggal_berakhir, $id);
    }

    $stmt->execute();
    $stmt->close();
    header("Location: dashboard.php?page=promo");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Promo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding-top: 2rem;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #495057;
        }

        .content {
            margin-left: 250px;
            padding: 2rem;
            background-color: #f8f9fa;
            flex: 1;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4 class="text-center">Dashboard Admin</h4>
    <a href="dashboard.php?page=kelola">Tambah Produk</a>
    <a href="dashboard.php?page=daftar">Daftar Produk</a>
    <a href="dashboard.php?page=variasi">Daftar Variasi</a>
    <a href="dashboard.php?page=promo" class="active">Daftar Promo</a>
    <a href="dashboard.php?page=logout">Logout</a>
</div>

<div class="content">
    <h3>Edit Promo</h3>
    <form method="POST">
        <?php if (!empty($promo['kode'])): ?>
            <!-- Kode Promo -->
            <div class="mb-3">
                <label>Kode Promo</label>
                <input type="text" name="kode" class="form-control" required value="<?= $promo['kode'] ?>">
            </div>
            <div class="mb-3">
                <label>Tipe Diskon</label>
                <select name="tipe_diskon" class="form-control">
                    <option value="persen" <?= $promo['tipe_diskon'] === 'persen' ? 'selected' : '' ?>>Persen</option>
                    <option value="nominal" <?= $promo['tipe_diskon'] === 'nominal' ? 'selected' : '' ?>>Nominal</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Nilai Diskon</label>
                <input type="number" name="nilai_diskon" class="form-control" step="0.01" value="<?= $promo['nilai_diskon'] ?>">
            </div>
            <div class="mb-3">
                <label>Minimal Belanja</label>
                <input type="number" name="minimal_belanja" class="form-control" value="<?= $promo['minimal_belanja'] ?>">
            </div>
            <div class="mb-3">
                <label>Kuota</label>
                <input type="number" name="kuota" class="form-control" value="<?= $promo['kuota'] ?>">
            </div>
        <?php else: ?>
            <!-- Promo Produk -->
            <div class="mb-3">
                <label>Pilih Produk</label>
                <select name="id_produk" class="form-control" required>
                    <?php
                    $produk = mysqli_query($conn, "SELECT id, name FROM products");
                    while ($p = mysqli_fetch_assoc($produk)) {
                        $selected = $promo['id_produk'] == $p['id'] ? 'selected' : '';
                        echo "<option value='{$p['id']}' $selected>{$p['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Tipe Diskon</label>
                <select name="tipe_diskon" class="form-control">
                    <option value="persen" <?= $promo['tipe_diskon'] === 'persen' ? 'selected' : '' ?>>Persen</option>
                    <option value="nominal" <?= $promo['tipe_diskon'] === 'nominal' ? 'selected' : '' ?>>Nominal</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Nilai Diskon</label>
                <input type="number" name="nilai_diskon" class="form-control" step="0.01" value="<?= $promo['nilai_diskon'] ?>">
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label>Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" value="<?= $promo['tanggal_mulai'] ?>">
        </div>
        <div class="mb-3">
            <label>Tanggal Berakhir</label>
            <input type="date" name="tanggal_berakhir" class="form-control" value="<?= $promo['tanggal_berakhir'] ?>">
        </div>

        <button type="submit" class="btn btn-success">Update Promo</button>
        <a href="dashboard.php?page=promo" class="btn btn-secondary">Kembali</a>
    </form>
</div>

</body>
</html>
