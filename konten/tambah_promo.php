<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = $_POST['kode'];
    $tipe_diskon = $_POST['tipe_diskon'];
    $nilai_diskon = $_POST['nilai_diskon'];
    $minimal_belanja = $_POST['minimal_belanja'];
    $kuota = $_POST['kuota'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_berakhir = $_POST['tanggal_berakhir'];

    $stmt = $conn->prepare("INSERT INTO promo (kode, tipe_diskon, nilai_diskon, minimal_belanja, kuota, tanggal_mulai, tanggal_berakhir, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'aktif')");
    $stmt->bind_param("ssddiss", $kode, $tipe_diskon, $nilai_diskon, $minimal_belanja, $kuota, $tanggal_mulai, $tanggal_berakhir);
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
  <title>Tambah Promo</title>
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
    <a href="dashboard.php?page=promo" class="active">Daftar Promo</a>
    <a href="dashboard.php?page=logout">Logout</a>
</div>

<div class="content">
  <h2>Tambah Kode Promo</h2>

  <form method="POST" class="mt-4">
    <div class="mb-3">
      <label>Kode Promo</label>
      <input type="text" name="kode" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Tipe Diskon</label>
      <select name="tipe_diskon" class="form-control">
        <option value="persen">Persen</option>
        <option value="nominal">Nominal</option>
      </select>
    </div>
    <div class="mb-3">
      <label>Nilai Diskon</label>
      <input type="number" name="nilai_diskon" class="form-control" step="0.01" required>
    </div>
    <div class="mb-3">
      <label>Minimal Belanja</label>
      <input type="number" name="minimal_belanja" class="form-control">
    </div>
    <div class="mb-3">
      <label>Kuota</label>
      <input type="number" name="kuota" class="form-control">
    </div>
    <div class="mb-3">
      <label>Tanggal Mulai</label>
      <input type="date" name="tanggal_mulai" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Tanggal Berakhir</label>
      <input type="date" name="tanggal_berakhir" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan Kode Promo</button>
    <a href="dashboard.php?page=promo" class="btn btn-secondary">Kembali</a>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>