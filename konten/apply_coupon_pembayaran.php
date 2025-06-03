<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = strtoupper(trim($_POST['coupon_code']));

    // Ambil info kupon dari database
    $query = mysqli_query($conn, "SELECT * FROM promo WHERE kode = '$kode' AND status = 'aktif'");
    $kupon = mysqli_fetch_assoc($query);

    if (!$kupon) {
        $_SESSION['notif'] = 'Kupon tidak ditemukan atau tidak aktif.';
    } else {
        // Siapkan array kupon jika belum ada
        if (!isset($_SESSION['coupons'])) {
            $_SESSION['coupons'] = [];
        }

        // Cek jika kupon sudah dipakai
        $sudah_ada = false;
        foreach ($_SESSION['coupons'] as $c) {
            if ($c['kode'] === $kode) {
                $sudah_ada = true;
                break;
            }
        }

        if ($sudah_ada) {
            $_SESSION['notif'] = 'Kupon sudah digunakan.';
        } elseif (count($_SESSION['coupons']) >= 2) {
            $_SESSION['notif'] = 'Penggunaan kupon melebihi batas.';
        } else {
            $_SESSION['coupons'][] = $kupon;
        }
    }

    header('Location: pembayaran.php');
    exit;
}


?>
