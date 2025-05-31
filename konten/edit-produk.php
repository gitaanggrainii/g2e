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

<h3 style="text-align: center; font-family: Arial, sans-serif;">Edit Produk</h3>

<form method="POST" 
  style="max-width: 600px; margin: 30px auto; padding: 30px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9; font-family: Arial, sans-serif;">

  <table style="width: 100%; border-collapse: collapse;">
    <tr>
      <td style="padding: 10px;"><label>Nama Produk:</label></td>
      <td style="padding: 10px;">
        <input type="text" name="name" required 
               value="<?= htmlspecialchars($data['name']) ?>"
               style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
      </td>
    </tr>

    <tr>
      <td style="padding: 10px;"><label>Kategori:</label></td>
      <td style="padding: 10px;">
        <input type="text" name="kategori_id" required 
               value="<?= htmlspecialchars($data['kategori_id']) ?>"
               style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
      </td>
    </tr>

    <tr>
      <td style="padding: 10px;"><label>Harga:</label></td>
      <td style="padding: 10px;">
        <input type="number" name="price" required 
               value="<?= $data['price'] ?>"
               style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
      </td>
    </tr>

    <tr>
      <td style="padding: 10px;"><label>Deskripsi:</label></td>
      <td style="padding: 10px;">
        <textarea name="description" required 
                  style="width: 100%; padding: 10px; height: 100px; border-radius: 5px; border: 1px solid #ccc;"><?= htmlspecialchars($data['description']) ?></textarea>
      </td>
    </tr>

    <tr>
      <td></td>
      <td style="padding: 10px;">
        <button type="submit" name="update" 
                style="padding: 10px 20px; background-color: black; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
          Simpan Perubahan
        </button>
      </td>
    </tr>
  </table>
</form>

