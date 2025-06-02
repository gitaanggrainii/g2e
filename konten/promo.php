<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$promo_edit = null;
$edit_mode = false;

// Ambil data jika edit
if (isset($_GET['edit'])) {
    $id_edit = intval($_GET['edit']);
    $get = mysqli_query($conn, "SELECT * FROM promo WHERE id = $id_edit");
    $promo_edit = mysqli_fetch_assoc($get);
    $edit_mode = true;
}

// Hapus promo
if (isset($_GET['hapus'])) {
    $id_hapus = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM promo WHERE id = $id_hapus");
    header("Location: ?page=promo");
    exit;
}

// Simpan / update promo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jenis = $_POST['jenis'];
    $tipe_diskon = $_POST['tipe_diskon'];
    $nilai_diskon = $_POST['nilai_diskon'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_berakhir = $_POST['tanggal_berakhir'];

    if ($jenis === 'produk') {
        $id_produk = $_POST['id_produk'];
        $stmt = $conn->prepare("INSERT INTO promo (id_produk, tipe_diskon, nilai_diskon, tanggal_mulai, tanggal_berakhir, status) VALUES (?, ?, ?, ?, ?, 'aktif')");
        $stmt->bind_param("isdss", $id_produk, $tipe_diskon, $nilai_diskon, $tanggal_mulai, $tanggal_berakhir);
        $stmt->execute();
        $stmt->close();
        if ($edit_mode) {
            $id_promo = intval($_POST['id']);
            $stmt = $conn->prepare("UPDATE promo SET id_produk=?, tipe_diskon=?, nilai_diskon=?, tanggal_mulai=?, tanggal_berakhir=? WHERE id=?");
            $stmt->bind_param("isdssi", $id_produk, $tipe_diskon, $nilai_diskon, $tanggal_mulai, $tanggal_berakhir, $id_promo);
        } else {
            $stmt = $conn->prepare("INSERT INTO promo (id_produk, tipe_diskon, nilai_diskon, tanggal_mulai, tanggal_berakhir, status) VALUES (?, ?, ?, ?, ?, 'aktif')");
            $stmt->bind_param("isdss", $id_produk, $tipe_diskon, $nilai_diskon, $tanggal_mulai, $tanggal_berakhir);
        }
    } elseif ($jenis === 'kode') {
        $kode = $_POST['kode'];
        $minimal_belanja = $_POST['minimal_belanja'];
        $kuota = $_POST['kuota'];
        $stmt = $conn->prepare("INSERT INTO promo (kode, tipe_diskon, nilai_diskon, minimal_belanja, kuota, tanggal_mulai, tanggal_berakhir, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'aktif')");
        $stmt->bind_param("ssddiss", $kode, $tipe_diskon, $nilai_diskon, $minimal_belanja, $kuota, $tanggal_mulai, $tanggal_berakhir);
        $stmt->execute();
        $stmt->close();
        if ($edit_mode) {
            $id_promo = intval($_POST['id']);
            $stmt = $conn->prepare("UPDATE promo SET kode=?, tipe_diskon=?, nilai_diskon=?, minimal_belanja=?, kuota=?, tanggal_mulai=?, tanggal_berakhir=? WHERE id=?");
            $stmt->bind_param("ssddissi", $kode, $tipe_diskon, $nilai_diskon, $minimal_belanja, $kuota, $tanggal_mulai, $tanggal_berakhir, $id_promo);
        } else {
            $stmt = $conn->prepare("INSERT INTO promo (kode, tipe_diskon, nilai_diskon, minimal_belanja, kuota, tanggal_mulai, tanggal_berakhir, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'aktif')");
            $stmt->bind_param("ssddiss", $kode, $tipe_diskon, $nilai_diskon, $minimal_belanja, $kuota, $tanggal_mulai, $tanggal_berakhir);
        }
    }

    $stmt->execute();
    $stmt->close();
    header("Location: ?page=promo");
    exit;
}
?>

<!-- HTML START -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Promo - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h2>Kelola Promo</h2>

  <ul class="nav nav-tabs mt-3">
    <li class="nav-item">
      <button class="nav-link <?= !$promo_edit || $promo_edit['id_produk'] ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#produk">Promo Produk</button>
    </li>
    <li class="nav-item">
      <button class="nav-link <?= $promo_edit && $promo_edit['kode'] ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#kode">Kode Promo</button>
    </li>
  </ul>

  <div class="tab-content mt-3">
    <!-- Promo Produk -->
    <div class="tab-pane fade <?= !$promo_edit || $promo_edit['id_produk'] ? 'show active' : '' ?>" id="produk">
      <form method="POST">
        <input type="hidden" name="jenis" value="produk">
        <?php if ($edit_mode): ?>
          <input type="hidden" name="id" value="<?= $promo_edit['id'] ?>">
        <?php endif; ?>
        <div class="mb-2">
          <label>Produk</label>
          <select name="id_produk" class="form-control" required>
            <option value="">-- Pilih Produk --</option>
            <?php
            $produk = mysqli_query($conn, "SELECT id, name FROM products");
            while ($row = mysqli_fetch_assoc($produk)) {
              $selected = $promo_edit && $promo_edit['id_produk'] == $row['id'] ? 'selected' : '';
              echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
            }
            ?>
          </select>
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
          <label>Tanggal Mulai</label>
          <input type="date" name="tanggal_mulai" class="form-control" required value="<?= $promo_edit['tanggal_mulai'] ?? '' ?>">
        </div>
        <div class="mb-2">
          <label>Tanggal Berakhir</label>
          <input type="date" name="tanggal_berakhir" class="form-control" required value="<?= $promo_edit['tanggal_berakhir'] ?? '' ?>">
        </div>
        <button type="submit" class="btn btn-primary"><?= $edit_mode ? 'Update' : 'Simpan' ?> Promo Produk</button>
      </form>
    </div>

    <!-- Kode Promo -->
    <div class="tab-pane fade <?= $promo_edit && $promo_edit['kode'] ? 'show active' : '' ?>" id="kode">
      <form method="POST">
        <input type="hidden" name="jenis" value="kode">
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
    </div>
  </div>

  <!-- Tabel Promo -->
  <h4 class="mt-5">Daftar Promo</h4>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Produk</th>
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
$result = mysqli_query($conn, "SELECT p.*, pr.name AS nama_produk FROM promo p LEFT JOIN products pr ON p.id_produk = pr.id ORDER BY p.id DESC");
while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr>
    <td>{$row['id']}</td>
    <td>" . ($row['nama_produk'] ?? '-') . "</td>
    <td>" . ($row['kode'] ?? '-') . "</td>
    <td>" . ucfirst($row['tipe_diskon']) . "</td>
    <td>" . ($row['tipe_diskon'] === 'persen' ? $row['nilai_diskon'] . '%' : 'Rp ' . number_format($row['nilai_diskon'], 0, ',', '.')) . "</td>
    <td>" . ($row['minimal_belanja'] ? 'Rp ' . number_format($row['minimal_belanja'], 0, ',', '.') : '-') . "</td>
    <td>" . ($row['kuota'] ?? '-') . "</td>
    <td>{$row['tanggal_mulai']}</td>
    <td>{$row['tanggal_berakhir']}</td>
    <td>" . ucfirst($row['status']) . "</td>
    <td>
      <a href='edit_promo.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
      <a href='?hapus={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus promo?\")'>Hapus</a>
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
