<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = intval($_POST['cart_id']);
    $action = $_POST['action'];

    $query = mysqli_query($conn, "SELECT jumlah FROM cart WHERE id = $cart_id");
    $row = mysqli_fetch_assoc($query);
    $jumlah = (int)$row['jumlah'];

    if ($action === 'increase') {
        $jumlah += 1;
    } elseif ($action === 'decrease' && $jumlah > 1) {
        $jumlah -= 1;
    }

    $stmt = $conn->prepare("UPDATE cart SET jumlah = ? WHERE id = ?");
    $stmt->bind_param("ii", $jumlah, $cart_id);
    $stmt->execute();
}

header("Location: keranjang.php");
exit;
?>
