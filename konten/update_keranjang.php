<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['index'], $_POST['action'])) {
    $index = $_POST['index'];
    $action = $_POST['action'];

    if (isset($_SESSION['cart'][$index])) {
        if ($action === 'increase') {
            $_SESSION['cart'][$index]['quantity'] += 1;
        } elseif ($action === 'decrease') {
            $_SESSION['cart'][$index]['quantity'] -= 1;

            // Hapus item jika quantity jadi 0
            if ($_SESSION['cart'][$index]['quantity'] <= 0) {
                unset($_SESSION['cart'][$index]);
                // Reset index array agar tidak lompat
                $_SESSION['cart'] = array_values($_SESSION['cart']);
            }
        }
    }
}

header('Location: keranjang.php');
exit;
