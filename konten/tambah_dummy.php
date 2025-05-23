<?php
session_start();
include 'koneksi.php';

$user_id = 1; // Ganti dengan $_SESSION['user_id'] jika login aktif


foreach ($items as $item) {
    $nama_produk = $item[0];
    $harga = $item[1];
    $kuantitas = $item[2];
    $subtotal = $harga * $kuantitas;
    $gambar = $item[3];

    $query = "INSERT INTO keranjang (user_id, nama_produk, harga, kuantitas, subtotal, gambar) 
              VALUES ('$user_id', '$nama_produk', '$harga', '$kuantitas', '$subtotal', '$gambar')";
    mysqli_query($conn, $query);
}

echo "Data dummy berhasil ditambahkan ke keranjang. <a href='keranjang.php'>Lihat keranjang</a>";
?>
