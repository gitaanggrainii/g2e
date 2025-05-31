<?php
include 'koneksi.php';
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
  $nama = $_POST['name'];
  $kategori = $_POST['kategori_id'];
  $harga = $_POST['price'];
  $deskripsi = $_POST['description'];

  mysqli_query($conn, "UPDATE products SET name='$nama', kategori_id='$kategori', price='$harga', description='$deskripsi' WHERE id=$id");
  header("Location: dashboard.php?page=daftar");
  exit;
}
?>

<h3>Edit Produk</h3>
<form method="POST" >
  <div class="mb-3">
    <label>Nama Produk</label>
    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($data['name']) ?>" required>
  </div><br>
  <div class="mb-3">
    <label>Kategori</label>
    <input type="text" name="kategori_id" class="form-control" value="<?= htmlspecialchars($data['kategori_id']) ?>" required>
  </div><br>
  <div class="mb-3">
    <label>Harga</label>
    <input type="number" name="price" class="form-control" value="<?= $data['price'] ?>" required>
  </div><br>
  <div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="description" class="form-control" required><?= htmlspecialchars($data['description']) ?></textarea>
  </div><br>
  <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
</form>
