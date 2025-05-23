<form action="proses_tambah_produk.php" method="post" enctype="multipart/form-data">
  <label>Nama Produk:</label><br>
  <input type="text" name="nama_produk" required><br>

  <label>Kategori:</label><br>
  <select name="kategori" required>
    <option value="makeup">Makeup</option>
    <option value="skincare">Skincare</option>
    <option value="haircare">Haircare</option>
    <option value="nails">Nails</option>
    <option value="bath&body">Bath & Body</option>
  </select><br>

  <label>Deskripsi:</label><br>
  <textarea name="deskripsi" required></textarea><br>

  <label>Harga:</label><br>
  <input type="number" name="harga" step="0.01" required><br>

  <label>Gambar Produk:</label><br>
  <input type="file" name="gambar" accept="image/*" required><br><br>

  <input type="submit" value="Tambah Produk">
</form>
