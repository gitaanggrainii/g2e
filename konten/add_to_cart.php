<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

if ($product_id > 0) {
    // Cek apakah produk sudah ada di cart
    $cek = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $user_id AND produk_id = $product_id");
    if (mysqli_num_rows($cek) > 0) {
        // Kalau sudah ada, update jumlah
        mysqli_query($conn, "UPDATE cart SET jumlah = jumlah + $quantity WHERE user_id = $user_id AND produk_id = $product_id");
    } else {
        // Kalau belum ada, insert baru
        mysqli_query($conn, "INSERT INTO cart (user_id, produk_id, jumlah) VALUES ($user_id, $product_id, $quantity)");
    }
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
