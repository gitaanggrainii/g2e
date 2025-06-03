<?php
include 'koneksi.php';

// Ambil semua variasi produk
$query = mysqli_query($conn, "SELECT v.id, v.product_id, v.gambar_variasi, p.name AS product_name FROM product_variants v JOIN products p ON v.product_id = p.id ORDER BY v.product_id DESC");
?>

<h2 style="text-align:center;">Daftar Variasi Produk</h2>

<table border="1" cellpadding="10" cellspacing="0" style="margin:auto; width:90%; border-collapse: collapse;">
    <thead style="background:#f0f0f0;">
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Gambar Variasi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($v = mysqli_fetch_assoc($query)) : ?>
            <tr>
                <td><?= $v['id'] ?></td>
                <td><?= htmlspecialchars($v['product_name']) ?></td>
                <td><img src="../img/<?= htmlspecialchars($v['gambar_variasi']) ?>" width="100"></td>
                <td>
                    <a href="edit_variasi.php?id=<?= $v['id'] ?>" style="padding: 5px 10px; background-color: #ffc107; color: black; border-radius: 5px; text-decoration: none;">Edit</a>
                    <a href="hapus_variasi.php?id=<?= $v['id'] ?>" onclick="return confirm('Yakin ingin menghapus variasi ini?')" style="padding: 5px 10px; background-color: #dc3545; color: white; border-radius: 5px; text-decoration: none;">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
