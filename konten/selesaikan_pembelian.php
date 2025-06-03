<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $purchase_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    // Update status jadi 'selesai'
    $stmt = $conn->prepare("UPDATE riwayat SET status = 'selesai' WHERE purchase_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $purchase_id, $user_id);
    $stmt->execute();

    // Ambil nama produk
    $result = $conn->query("SELECT product_name FROM riwayat WHERE purchase_id = $purchase_id");
    $data = $result->fetch_assoc();
    $product = urlencode($data['product_name']);

    // Redirect ke rating
    header("Location: rating.php?product=$product");
    exit();
}
?>
