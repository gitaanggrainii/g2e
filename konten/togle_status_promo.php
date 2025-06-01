<?php
session_start();
include '../configdb.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = mysqli_query($conn, "SELECT status FROM promo WHERE id = $id");
    if ($promo = mysqli_fetch_assoc($result)) {
        $status_baru = ($promo['status'] === 'aktif') ? 'nonaktif' : 'aktif';
        mysqli_query($conn, "UPDATE promo SET status = '$status_baru' WHERE id = $id");
    }
}

header("Location: daftar-promo.php"); // ganti sesuai nama file kamu
exit;
?>
