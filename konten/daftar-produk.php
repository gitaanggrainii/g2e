<?php
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM products");
?>

<h3>Daftar Produk</h3>
<table class="table table-bordered table-striped mt-3">
  <thead class="table-dark">
    <tr>
      <th>Nama Produk</th>
      <th>Kategori</th>
      <th>Harga</th>
      <th>Deskripsi</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['kategori_id']) ?></td>
        <td>Rp<?= number_format($row['price'], 0, ',', '.') ?></td>
        <td><?= htmlspecialchars($row['description']) ?></td>
        <td>
          <a href="edit-produk.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="hapus-produk.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>
