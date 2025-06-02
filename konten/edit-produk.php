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

  // Input diskon dan promo
  $diskon_persen = isset($_POST['diskon_persen']) ? (int)$_POST['diskon_persen'] : 0;
  $promo_mulai = !empty($_POST['promo_mulai']) ? $_POST['promo_mulai'] : null;
  $promo_akhir = !empty($_POST['promo_akhir']) ? $_POST['promo_akhir'] : null;

  // Hitung harga diskon otomatis
  if ($diskon_persen > 0) {
    $harga_diskon = $harga - ($harga * $diskon_persen / 100);
  } else {
    $harga_diskon = null;
    $promo_mulai = null;
    $promo_akhir = null;
  }

  $sql = "UPDATE products SET 
            name='$nama', 
            kategori_id='$kategori', 
            price='$harga', 
            description='$deskripsi', 
            diskon_persen='$diskon_persen', 
            harga_diskon=" . ($harga_diskon !== null ? $harga_diskon : "NULL") . ",
            promo_mulai=" . ($promo_mulai ? "'$promo_mulai'" : "NULL") . ",
            promo_akhir=" . ($promo_akhir ? "'$promo_akhir'" : "NULL") . "
          WHERE id=$id";

  mysqli_query($conn, $sql);
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
      <td style="padding: 10px;"><label>Diskon (%):</label></td>
      <td style="padding: 10px;">
        <input type="number" name="diskon_persen" min="0" max="100"
               value="<?= $data['diskon_persen'] ?? 0 ?>"
               style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
      </td>
    </tr>

    <tr>
      <td style="padding: 10px;"><label>Promo Mulai:</label></td>
      <td style="padding: 10px;">
        <input type="date" name="promo_mulai"
               value="<?= $data['promo_mulai'] ?>"
               style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
      </td>
    </tr>

    <tr>
      <td style="padding: 10px;"><label>Promo Akhir:</label></td>
      <td style="padding: 10px;">
        <input type="date" name="promo_akhir"
               value="<?= $data['promo_akhir'] ?>"
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
