<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    // Jika belum login, arahkan ke login atau tampilkan pesan
    echo "<script>alert('Silakan login terlebih dahulu untuk menambahkan ke favorit.'); window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['product_id'] ?? null;

// Validasi
if (!$product_id) {
    echo "Produk tidak ditemukan.";
    exit;
}

// Cek apakah sudah ada di favorit
$cek = mysqli_query($conn, "SELECT * FROM favorites WHERE user_id=$user_id AND product_id=$product_id");
if (mysqli_num_rows($cek) == 0) {
    mysqli_query($conn, "INSERT INTO favorites (user_id, product_id) VALUES ($user_id, $product_id)");
}

// Redirect kembali ke halaman sebelumnya jika ada
if (isset($_GET['redirect'])) {
    header("Location: " . $_GET['redirect']);
} else {
    header("Location: favorit.php");
}
exit;
?>
