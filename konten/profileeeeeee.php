<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    $query = $conn->prepare("SELECT * FROM users WHERE email = ?");
$query->bind_param("s", $_SESSION['email']);
$query->execute();
$user = $query->get_result()->fetch_assoc();

    exit;
    
}

include '../header/header_keranjang.php'; // header yang kamu upload
?>
<link rel="stylesheet" type="text/css" href="keranjang.css">
<style>
    .profil-wrapper {
        max-width: 800px;
        margin: 100px auto 60px;
        background-color: #f0f4fa;
        border: 2px solid rgb(177, 196, 212);
        border-radius: 15px;
        padding: 40px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .profil-wrapper h2 {
        text-align: center;
        color: rgb(51, 120, 180);
        margin-bottom: 30px;
    }

    .profil-info {
        font-size: 18px;
        line-height: 2;
    }

    .profil-info strong {
        display: inline-block;
        width: 150px;
        color: rgb(73, 73, 160);
    }

    .profil-buttons {
        margin-top: 40px;
        text-align: center;
    }

    .profil-buttons a {
        text-decoration: none;
        background-color: rgb(155, 155, 224);
        color: black;
        padding: 12px 24px;
        margin: 0 10px;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.3s;
    }

    .profil-buttons a:hover {
        background-color: rgb(51, 120, 180);
        color: white;
    }
</style>

<div class="profil-wrapper">
<h2>Profil Pengguna</h2>
    <p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($_SESSION['username'] ?? '') ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email'] ?? '') ?></p>
    <p><strong>Alamat:</strong> <?= htmlspecialchars($_SESSION['alamat'] ?? '') ?></p>
    <div class="profil-buttons">
        <a href="edit_profil.php">Edit Profil</a>
        <a href="ubah_password.php">Ubah Password</a>
        <a href="riwayat_pembelian.php">Riwayat Pembelian</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<?php include '../footer/footer.php'; ?>
