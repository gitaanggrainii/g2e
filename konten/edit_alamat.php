<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Ambil data alamat saat ini
$query = $conn->prepare("SELECT * FROM alamat WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();
$data = $result->fetch_assoc();

// Proses update alamat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $kota = $_POST['kota'] ?? '';
    $provinsi = $_POST['provinsi'] ?? '';
    $kode_pos = $_POST['kode_pos'] ?? '';
    $telepon = $_POST['telepon'] ?? '';

    $update = $conn->prepare("UPDATE alamat SET nama=?, alamat=?, kota=?, provinsi=?, kode_pos=?, telepon=? WHERE email=?");
    $update->bind_param("sssssss", $nama, $alamat, $kota, $provinsi, $kode_pos, $telepon, $email);
    if ($update->execute()) {
        echo "<script>alert('Alamat berhasil diperbarui!'); window.location.href='pembayaran.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal memperbarui alamat.');</script>";
    }
}
var_dump($update->error); // untuk cek kalau ada kesalahan query

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Alamat</title>
    <link rel="stylesheet" href="../css/pembayaran.css">
    <style>
      .form-section {
        max-width: 700px;
        background: #f4f8fc;
        margin: 50px auto;
        padding: 30px;
        border: 2px solid rgb(177, 196, 212);
        border-radius: 10px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }

      .form-section h2 {
        color: rgb(51, 120, 180);
        text-align: center;
        margin-bottom: 25px;
      }

      label {
        display: block;
        font-weight: 600;
        margin: 15px 0 5px;
        color: #2d4b7a;
      }

      input[type="text"], textarea {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        box-sizing: border-box;
      }

      button[type="submit"] {
        margin-top: 25px;
        background-color: rgb(155, 155, 224);
        color: black;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s;
      }

      button[type="submit"]:hover {
        background-color: rgb(51, 120, 180);
        color: white;
      }
    </style>
</head>
<body>
<?php include '../header/header_keranjang.php'; ?>

<div class="form-section">
    <h2>Edit Alamat Pengiriman</h2>
    <form method="POST">
        <label for="nama">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama'] ?? '') ?>" required>

        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat" rows="3" required><?= htmlspecialchars($data['alamat'] ?? '') ?></textarea>

        <label for="kota">Kota</label>
        <input type="text" id="kota" name="kota" value="<?= htmlspecialchars($data['kota'] ?? '') ?>" required>

        <label for="provinsi">Provinsi</label>
        <input type="text" id="provinsi" name="provinsi" value="<?= htmlspecialchars($data['provinsi'] ?? '') ?>" required>

        <label for="kode_pos">Kode Pos</label>
        <input type="text" id="kode_pos" name="kode_pos" value="<?= htmlspecialchars($data['kode_pos'] ?? '') ?>" required>

        <label for="telepon">No Telepon</label>
        <input type="text" id="telepon" name="telepon" value="<?= htmlspecialchars($data['telepon'] ?? '') ?>" required>

        <button type="submit">Simpan Perubahan</button>
    </form>
</div>

<?php include '../footer/footer.php'; ?>
</body>
</html>
