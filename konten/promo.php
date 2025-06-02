<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';
// Cek jika sedang dalam mode edit
$promo_edit = null;
if (isset($_GET['edit'])) {
    $id_edit = intval($_GET['edit']);
    $get = mysqli_query($conn, "SELECT * FROM promo WHERE id = $id_edit");
    $promo_edit = mysqli_fetch_assoc($get);
}

// Simpan promo
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
    } elseif ($jenis === 'kode') {
        $kode = $_POST['kode'];
        $minimal_belanja = $_POST['minimal_belanja'];
        $kuota = $_POST['kuota'];
        $stmt = $conn->prepare("INSERT INTO promo (kode, tipe_diskon, nilai_diskon, minimal_belanja, kuota, tanggal_mulai, tanggal_berakhir, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'aktif')");
        $stmt->bind_param("ssddiss", $kode, $tipe_diskon, $nilai_diskon, $minimal_belanja, $kuota, $tanggal_mulai, $tanggal_berakhir);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: ?page=promo");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin - Promo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      min-height: 100vh;
    }
    .sidebar {
      width: 250px;
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
      flex: 1;
      padding: 2rem;
      background-color: #f8f9fa;
    }
  </style>
</head>
<body>
<!-- Content -->
<div class="content">
  <h2>Kelola Promo</h2>

  <!-- Tab -->
  <ul class="nav nav-tabs mt-3" id="promoTab" role="tablist">
    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#produk">Promo Produk</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#kode">Kode Promo</button></li>
  </ul>

  <!-- Tab Content -->
  <div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="produk">
      <form method="POST">
        <input type="hidden" name="jenis" value="produk">
        <div class="mb-2">
          <label>Produk</label>
          <select name="id_produk" class="form-control" required>
            <option value="">-- Pilih Produk --</option>
            <?php
            $produk = mysqli_query($conn, "SELECT id, name FROM products");
            while ($row = mysqli_fetch_assoc($produk)) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
            }
            ?>
          </select>
        </div>
        <div class="mb-2">
          <label>Tipe Diskon</label>
          <select name="tipe_diskon" class="form-control">
            <option value="persen">Persen</option>
            <option value="nominal">Nominal</option>
          </select>
        </div>
        <div class="mb-2">
          <label>Nilai Diskon</label>
          <input type="number" name="nilai_diskon" class="form-control" step="0.01" required>
        </div>
        <div class="mb-2">
          <label>Tanggal Mulai</label>
          <input type="date" name="tanggal_mulai" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Tanggal Berakhir</label>
          <input type="date" name="tanggal_berakhir" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Promo Produk</button>
      </form>
    </div>

    <div class="tab-pane fade" id="kode">
      <form method="POST">
        <input type="hidden" name="jenis" value="kode">
        <div class="mb-2">
          <label>Kode Promo</label>
          <input type="text" name="kode" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Tipe Diskon</label>
          <select name="tipe_diskon" class="form-control">
            <option value="persen">Persen</option>
            <option value="nominal">Nominal</option>
          </select>
        </div>
        <div class="mb-2">
          <label>Nilai Diskon</label>
          <input type="number" name="nilai_diskon" class="form-control" step="0.01" required>
        </div>
        <div class="mb-2">
          <label>Minimal Belanja</label>
          <input type="number" name="minimal_belanja" class="form-control" step="0.01">
        </div>
        <div class="mb-2">
          <label>Kuota</label>
          <input type="number" name="kuota" class="form-control">
        </div>
        <div class="mb-2">
          <label>Tanggal Mulai</label>
          <input type="date" name="tanggal_mulai" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Tanggal Berakhir</label>
          <input type="date" name="tanggal_berakhir" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary " >Simpan Kode Promo</button>
      </form>
    </div>
  </div>

  <!-- Tabel Daftar Promo -->
  <h4 class="mt-4">Daftar Promo</h4>
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
        </tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
