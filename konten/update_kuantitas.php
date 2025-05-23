<?php
include 'koneksi.php';
session_start();

if (isset($_POST['id']) && isset($_POST['kuantitas'])) {
    $id = $_POST['id'];
    $kuantitas = $_POST['kuantitas'];

    // Ambil harga dari produk berdasarkan ID
    $query = "SELECT harga FROM keranjang WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        $harga = $data['harga'];
        $subtotal = $harga * $kuantitas;

        // Update keranjang
        $update = "UPDATE keranjang SET kuantitas = $kuantitas, subtotal = $subtotal WHERE id = $id";
        mysqli_query($conn, $update);
    }
}

header("Location: keranjang.php");
exit();
?>
