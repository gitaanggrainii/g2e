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

// Proses simpan alamat (insert/update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $kota = $_POST['kota'] ?? '';
    $provinsi = $_POST['provinsi'] ?? '';
    $kode_pos = $_POST['kode_pos'] ?? '';
    $telepon = $_POST['telepon'] ?? '';

    if ($data) {
        // Update jika data sudah ada
        $update = $conn->prepare("UPDATE alamat SET nama=?, alamat=?, kota=?, provinsi=?, kode_pos=?, telepon=? WHERE email=?");
        $update->bind_param("sssssss", $nama, $alamat, $kota, $provinsi, $kode_pos, $telepon, $email);
        if ($update->execute()) {
            echo "<script>alert('Alamat berhasil diperbarui!'); window.location.href='pembayaran.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal memperbarui alamat.');</script>";
        }
    } else {
        // Insert jika belum ada data
        $insert = $conn->prepare("INSERT INTO alamat (email, nama, alamat, kota, provinsi, kode_pos, telepon) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("sssssss", $email, $nama, $alamat, $kota, $provinsi, $kode_pos, $telepon);
        if ($insert->execute()) {
            echo "<script>alert('Alamat berhasil disimpan!'); window.location.href='pembayaran.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal menyimpan alamat.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Alamat</title>
    <link rel="stylesheet" href="../css/edit_alamat.css">

    
</head>
<body>
<?php include '../header/header_keranjang.php'; ?>

<div class="form-section">
    <h2><?= $data ? 'Edit' : 'Isi' ?> Alamat Pengiriman</h2>
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

        <button type="submit">Simpan</button>
    </form>
</div>

<?php include '../footer/footer.php'; ?>
</body>
</html>
