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
      <th>Harga Asli</th>
      <th>Diskon (%)</th>
      <th>Harga Diskon</th>
      <th>Promo Periode</th>
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
        <td><?= $row['diskon_persen'] ?>%</td>
        <td>
          <?php if (!empty($row['harga_diskon'])): ?>
            <span style="text-decoration:line-through; color:gray;">Rp<?= number_format($row['price'], 0, ',', '.') ?></span><br>
            <strong>Rp<?= number_format($row['harga_diskon'], 0, ',', '.') ?></strong>
          <?php else: ?>
            -
          <?php endif; ?>
        </td>
        <td>
          <?= $row['promo_mulai'] ? date('d M Y', strtotime($row['promo_mulai'])) : '-' ?> -
          <?= $row['promo_akhir'] ? date('d M Y', strtotime($row['promo_akhir'])) : '-' ?>
        </td>
        <td><?= htmlspecialchars($row['description']) ?></td>
        <td>
          <a href="edit-produk.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="hapus-produk.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>

