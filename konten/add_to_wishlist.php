<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    echo "Silakan login terlebih dahulu.";
    exit();
}

// Include file koneksi ke database
include('koneksi.php');

// Ambil ID user dari session dan ID produk dari POST
$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'] ?? null;

// Validasi ID produk
if (!$product_id || !is_numeric($product_id)) {
    echo "ID produk tidak valid.";
    exit();
}

// Cek apakah produk sudah ada di wishlist
$check = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
$check->bind_param("ii", $user_id, $product_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "Produk sudah ada di favorit.";
    $check->close();
    exit();
}

// Tambahkan ke wishlist
$insert = $conn->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
$insert->bind_param("ii", $user_id, $product_id);

if ($insert->execute()) {
    echo "Berhasil menambahkan ke favorit!";
} else {
    echo "Gagal menambahkan ke favorit.";
}

// Tutup koneksi
$insert->close();
$conn->close();
exit();
?>
