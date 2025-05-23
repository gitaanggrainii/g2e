<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';
include '../header/header_favorite.php'; ?>
    <main>
<div class="wishlist">

<?php

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login terlebih dahulu untuk melihat favorit.'); window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// Query untuk mengambil produk favorit
$query = "SELECT p.* FROM products p 
          INNER JOIN favorites f ON p.id = f.product_id 
          WHERE f.user_id = $user_id";

$result = mysqli_query($conn, $query);
echo '<main>';
echo '<div class="wishlist" style="margin-top: 5px;">';
if (mysqli_num_rows($result) > 0) {
    while ($product = mysqli_fetch_assoc($result)) {
        echo '<div class="item" style="margin-top: 70px; margin-bottom: 25px; margin-top: 2px;">';
        echo '<div class="badge">New</div>';
        echo '<img src="../img/' . htmlspecialchars($product['image_url']) . '" alt="' . htmlspecialchars($product['name']) . '">';
        echo '<div class="item-content" style="text-align: center;">';
        echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
        echo '<p>' . htmlspecialchars($product['description']) . '</p>';
        echo '<p class="price">Rp ' . number_format($product['price'], 0, ',', '.') . '</p>';
        echo '<a href="keranjang.php"><button>Add to Cart</button></a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "<p>Tidak ada produk favorit.</p>";
}

mysqli_close($conn);
?>


</div>
	</main>
    <?php include '../footer/footer_favorite.php'; ?>