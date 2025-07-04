<?php
// === FILE: promo.php ===

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';



// Hapus promo
if (isset($_GET['hapus'])) {
    $id_hapus = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM promo WHERE id = $id_hapus");
    header("Location: dashboard.php?page=promo");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Kode Promo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h2>Kelola Kode Promo</h2>

  <a href="tambah_promo.php" class="btn btn-success mb-3">+ Tambah Kode Promo</a>

  <h4>Daftar Kode Promo</h4>
  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Kode</th>
        <th>Tipe</th>
        <th>Diskon</th>
        <th>Min. Belanja</th>
        <th>Kuota</th>
        <th>Mulai</th>
        <th>Berakhir</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
<?php
$tanggal_hari_ini = date('Y-m-d');
$result = mysqli_query($conn, "SELECT * FROM promo WHERE kode IS NOT NULL ORDER BY id ASC");
while ($row = mysqli_fetch_assoc($result)) {
  // Periksa apakah promo sudah kedaluwarsa dan masih aktif
  if (strtotime($row['tanggal_berakhir']) < strtotime($tanggal_hari_ini) && $row['status'] === 'aktif') {
    mysqli_query($conn, "UPDATE promo SET status = 'nonaktif' WHERE id = {$row['id']}");
    $row['status'] = 'nonaktif';
  }
  // Periksa apakah promo sudah mulai dan masih nonaktif
  elseif (strtotime($row['tanggal_mulai']) <= strtotime($tanggal_hari_ini) && $row['status'] === 'nonaktif' && strtotime($row['tanggal_berakhir']) >= strtotime($tanggal_hari_ini)) {
    mysqli_query($conn, "UPDATE promo SET status = 'aktif' WHERE id = {$row['id']}");
    $row['status'] = 'aktif';
  }

  echo "<tr>
    <td>{$row['id']}</td>
    <td>{$row['kode']}</td>
    <td>" . ucfirst($row['tipe_diskon']) . "</td>
    <td>" . ($row['tipe_diskon'] === 'persen' ? $row['nilai_diskon'] . '%' : 'Rp ' . number_format($row['nilai_diskon'], 0, ',', '.')) . "</td>
    <td>" . ($row['minimal_belanja'] ? 'Rp ' . number_format($row['minimal_belanja'], 0, ',', '.') : '-') . "</td>
    <td>" . ($row['kuota'] ?? '-') . "</td>
    <td>{$row['tanggal_mulai']}</td>
    <td>{$row['tanggal_berakhir']}</td>
    <td>" . ucfirst($row['status']) . "</td>
    <td>
      <a href='edit_promo.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
      <a href='dashboard.php?page=promo&hapus={$row['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin ingin menghapus promo?')\">Hapus</a>
    </td>
  </tr>";
}
?>
    </tbody>
  </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
