<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kode_hapus'])) {
    $kode = $_POST['kode_hapus'];

    if (isset($_SESSION['coupons'])) {
        $_SESSION['coupons'] = array_filter($_SESSION['coupons'], fn($c) => $c['kode'] !== $kode);
    }
}

header("Location: keranjang.php");
exit();
