<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    echo "Variasi tidak ditemukan."; exit;
}
$id = intval($_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM product_variants WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Variasi tidak ditemukan."; exit;
}
?>

<h2>Edit Gambar Variasi</h2>
<form method="POST" action="update_variasi.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $data['id'] ?>">
    <p>Produk ID: <?= $data['product_id'] ?></p>
    <p>Gambar Saat Ini:</p>
    <img src="../img/<?= htmlspecialchars($data['gambar_variasi']) ?>" width="150" style="margin-bottom: 10px;"><br>

    <label>Upload Gambar Baru:</label><br>
    <input type="file" name="gambar_baru" accept="image/*" required><br><br>

    <button type="submit">Simpan Perubahan</button>
</form>
