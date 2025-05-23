<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
$tanggal = date('Y-m-d');

$first_name  = $_POST['first_name'] ?? '';
$last_name   = $_POST['last_name'] ?? '';
$address     = $_POST['address'] ?? '';
$subdistrict = $_POST['sub_district'] ?? '';
$city        = $_POST['city'] ?? '';
$province    = $_POST['province'] ?? '';
$postal_code = $_POST['postal_code'] ?? '';
$phone       = $_POST['phone'] ?? '';
$delivery    = $_POST['delivery'] ?? '';
$payment     = $_POST['payment-method'] ?? '';

$nama_lengkap = trim($first_name . ' ' . $last_name);
$alamat_lengkap = "$nama_lengkap, $address, $subdistrict, $city, $province, $postal_code, Telp: $phone";

$cek = $conn->prepare("SELECT id FROM alamat WHERE email = ?");
$cek->bind_param("s", $email);
$cek->execute();
$result = $cek->get_result();

if ($result->num_rows > 0) {
    $update = $conn->prepare("UPDATE alamat SET nama = ?, alamat = ?, kota = ?, provinsi = ?, kode_pos = ?, telepon = ? WHERE email = ?");
    $update->bind_param("sssssss", $nama_lengkap, $address, $city, $province, $postal_code, $phone, $email);
    $update->execute();
} else {
    $insert = $conn->prepare("INSERT INTO alamat (email, nama, alamat, kota, provinsi, kode_pos, telepon) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insert->bind_param("sssssss", $email, $nama_lengkap, $address, $city, $province, $postal_code, $phone);
    $insert->execute();
}
$query = "SELECT cart.*, products.name, products.price 
          FROM cart 
          JOIN products ON cart.produk_id = products.id 
          WHERE cart.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_items = $stmt->get_result();

while ($row = $cart_items->fetch_assoc()) {
    $produk = $row['name'];
    $jumlah = $row['jumlah'];
    $harga  = $row['price'];
    $total  = $jumlah * $harga;

    $insert_order = $conn->prepare("INSERT INTO orders (user_email, tanggal, produk, jumlah, total, alamat, metode_pembayaran, kurir, nama_penerima) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_order->bind_param("sssisssss", $email, $tanggal, $produk, $jumlah, $total, $alamat_lengkap, $payment, $delivery, $nama_lengkap);
    $insert_order->execute();
}

$delete_cart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$delete_cart->bind_param("i", $user_id);
$delete_cart->execute();

echo "<script>alert('Pesanan berhasil disimpan!'); window.location.href='profile.php';</script>";
exit();
