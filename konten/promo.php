<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$promo_edit = null;
$edit_mode = false;

if (isset($_GET['edit'])) {
    $id_edit = intval($_GET['edit']);
    $get = mysqli_query($conn, "SELECT * FROM promo WHERE id = $id_edit");
    $promo_edit = mysqli_fetch_assoc($get);
    $edit_mode = true;
}

if (isset($_GET['hapus'])) {
    $id_hapus = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM promo WHERE id = $id_hapus");
    header("Location: dashboard.php?page=promo");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = $_POST['kode'];
    $tipe_diskon = $_POST['tipe_diskon'];
    $nilai_diskon = $_POST['nilai_diskon'];
    $minimal_belanja = $_POST['minimal_belanja'];
    $kuota = $_POST['kuota'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_berakhir = $_POST['tanggal_berakhir'];

    if ($edit_mode) {
        $id_promo = intval($_POST['id']);
        $stmt = $conn->prepare("UPDATE promo SET kode=?, tipe_diskon=?, nilai_diskon=?, minimal_belanja=?, kuota=?, tanggal_mulai=?, tanggal_berakhir=? WHERE id=?");
        $stmt->bind_param("ssddissi", $kode, $tipe_diskon, $nilai_diskon, $minimal_belanja, $kuota, $tanggal_mulai, $tanggal_berakhir, $id_promo);
    } else {
        $stmt = $conn->prepare("INSERT INTO promo (kode, tipe_diskon, nilai_diskon, minimal_belanja, kuota, tanggal_mulai, tanggal_berakhir, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'aktif')");
        $stmt->bind_param("ssddiss", $kode, $tipe_diskon, $nilai_diskon, $minimal_belanja, $kuota, $tanggal_mulai, $tanggal_berakhir);
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
  <title>Kelola Kode Promo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h2>Kelola Kode Promo</h2>

  <form method="POST" class="mt-4">
    <?php if ($edit_mode): ?>
      <input type="hidden" name="id" value="<?= $promo_edit['id'] ?>">
    <?php endif; ?>
    <div class="mb-2">
      <label>Kode Promo</label>
      <input type="text" name="kode" class="form-control" required value="<?= $promo_edit['kode'] ?? '' ?>">
    </div>
    <div class="mb-2">
      <label>Tipe Diskon</label>
      <select name="tipe_diskon" class="form-control">
        <option value="persen" <?= ($promo_edit['tipe_diskon'] ?? '') == 'persen' ? 'selected' : '' ?>>Persen</option>
        <option value="nominal" <?= ($promo_edit['tipe_diskon'] ?? '') == 'nominal' ? 'selected' : '' ?>>Nominal</option>
      </select>
    </div>
    <div class="mb-2">
      <label>Nilai Diskon</label>
      <input type="number" name="nilai_diskon" class="form-control" step="0.01" required value="<?= $promo_edit['nilai_diskon'] ?? '' ?>">
    </div>
    <div class="mb-2">
      <label>Minimal Belanja</label>
      <input type="number" name="minimal_belanja" class="form-control" value="<?= $promo_edit['minimal_belanja'] ?? '' ?>">
    </div>
    <div class="mb-2">
      <label>Kuota</label>
      <input type="number" name="kuota" class="form-control" value="<?= $promo_edit['kuota'] ?? '' ?>">
    </div>
    <div class="mb-2">
      <label>Tanggal Mulai</label>
      <input type="date" name="tanggal_mulai" class="form-control" required value="<?= $promo_edit['tanggal_mulai'] ?? '' ?>">
    </div>
    <div class="mb-2">
      <label>Tanggal Berakhir</label>
      <input type="date" name="tanggal_berakhir" class="form-control" required value="<?= $promo_edit['tanggal_berakhir'] ?? '' ?>">
    </div>
    <button type="submit" class="btn btn-primary"><?= $edit_mode ? 'Update' : 'Simpan' ?> Kode Promo</button>
  </form>

  <h4 class="mt-5">Daftar Kode Promo</h4>
  <table class="table table-bordered">
    <thead>
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
$result = mysqli_query($conn, "SELECT * FROM promo WHERE kode IS NOT NULL ORDER BY id DESC");
while ($row = mysqli_fetch_assoc($result)) {
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
      <a href='dashboard.php?page=promo?edit={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
      <a href='dashboard.php?page=promo?hapus={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus promo?\")'>Hapus</a>
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
