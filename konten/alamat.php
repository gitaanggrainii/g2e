<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
include '../header/header.php';
?>

<div class="isi" style="padding: 40px;">
    <div style="max-width: 700px; margin: auto; background: #f7f9fc; border: 2px solid #d0d9e1; border-radius: 12px; padding: 30px;">
        <h2 style="text-align:center; color: #3378b4;">Alamat Pengiriman</h2>
        <p style="font-size: 18px; text-align: center; margin-top: 20px;">
            <?= htmlspecialchars($_SESSION['alamat'] ?? 'Belum ada alamat yang disimpan.') ?>
        </p>
        <div style="text-align: center; margin-top: 20px;">
            <a href="edit_profile.php" class="btn" style="padding: 10px 25px; background: #6b9dcf; color: white; border-radius: 6px; text-decoration: none;">Ubah Alamat</a>
        </div>
    </div>
</div>

<?php include '../footer/footer.php'; ?>
