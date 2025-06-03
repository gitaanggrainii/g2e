<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID variasi tidak ditemukan.";
    exit;
}

$id = intval($_GET['id']);

// Ambil dulu product_id agar nanti bisa redirect jika perlu
$get = mysqli_query($conn, "SELECT product_id FROM product_variants WHERE id = $id");
$data = mysqli_fetch_assoc($get);

if (!$data) {
    echo "Variasi tidak ditemukan.";
    exit;
}

// Hapus data variasi
mysqli_query($conn, "DELETE FROM product_variants WHERE id = $id");

// Redirect ke halaman daftar variasi
header("Location: daftar_variasi.php?hapus=1");
exit;
?>
