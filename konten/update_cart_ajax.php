<?php
session_start();
include 'koneksi.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = intval($_POST['cart_id']);
    $action = $_POST['action'];

    $result = mysqli_query($conn, "SELECT jumlah FROM cart WHERE id = $cart_id");
    $row = mysqli_fetch_assoc($result);
    $jumlah = (int) $row['jumlah'];

    if ($action === 'increase') {
        $jumlah++;
    } elseif ($action === 'decrease' && $jumlah > 1) {
        $jumlah--;
    }

    $stmt = $conn->prepare("UPDATE cart SET jumlah = ? WHERE id = ?");
    $stmt->bind_param("ii", $jumlah, $cart_id);
    $stmt->execute();

    echo json_encode(['success' => true, 'new_quantity' => $jumlah]);
    exit;
}

echo json_encode(['success' => false]);
