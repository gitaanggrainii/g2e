<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$produk_id = intval($_GET['id']);

$cek = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $user_id AND produk_id = $produk_id");

if (mysqli_num_rows($cek) > 0) {
    mysqli_query($conn, "UPDATE cart SET jumlah = jumlah + 1 WHERE user_id = $user_id AND produk_id = $produk_id");
} else {
    mysqli_query($conn, "INSERT INTO cart (user_id, produk_id, jumlah) VALUES ($user_id, $produk_id, 1)");
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
