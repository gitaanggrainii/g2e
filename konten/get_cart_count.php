<?php
session_start();

// Cek apakah ada keranjang dalam session
if (isset($_SESSION['keranjang'])) {
    $cart_count = 0;

    // Loop untuk menghitung jumlah semua produk di dalam keranjang
    foreach ($_SESSION['keranjang'] as $item) {
        $cart_count += $item['quantity']; // Tambahkan jumlah kuantitas produk ke total
    }

    echo $cart_count; // Mengirimkan jumlah produk ke frontend
} else {
    echo 0; // Jika tidak ada produk dalam keranjang
}
?>

