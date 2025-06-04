<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = strtoupper(trim($_POST['coupon_code']));


    $query = mysqli_query($conn, "SELECT * FROM promo WHERE kode = '$kode' AND status = 'aktif'");
    $kupon = mysqli_fetch_assoc($query);

    if (!$kupon) {
        $_SESSION['notif'] = 'Kupon tidak ditemukan atau tidak aktif.';
    } else {

        if (!isset($_SESSION['coupons'])) {
            $_SESSION['coupons'] = [];
        }

        $user_id = $_SESSION['user_id'];
        $total_belanja = 0;
        $query_cart = mysqli_query($conn, "
            SELECT c.jumlah, p.price, p.diskon_persen 
            FROM cart c 
            JOIN products p ON c.produk_id = p.id 
            WHERE c.user_id = $user_id
        ");

        while ($row = mysqli_fetch_assoc($query_cart)) {
            $harga = $row['price'];
            if ($row['diskon_persen'] > 0) {
                $harga -= ($row['diskon_persen'] / 100) * $row['price'];
            }
            $total_belanja += $harga * $row['jumlah'];
        }

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
            $_SESSION['notif'] = 'Kupon tidak bisa ditambahkan lebih dari 2.';
        } elseif ($total_belanja < $kupon['minimal_belanja']) {
            $selisih = $kupon['minimal_belanja'] - $total_belanja;
            $_SESSION['notif'] = 'Rp ' . number_format($selisih, 0, ',', '.') . ' lagi untuk bisa pakai kupon ini.';
        } else {
            $_SESSION['coupons'][] = $kupon;
        }
    }

    header('Location: pembayaran.php');
    exit;
}
?>
