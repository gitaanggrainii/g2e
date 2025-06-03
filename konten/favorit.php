<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';
include '../header/header_favorite.php';
?>
<main>
<div class="wishlist" style="margin-top: 5px;">
<?php
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login terlebih dahulu untuk melihat favorit.'); window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$today = date('Y-m-d');

// Ambil produk favorit
$query = "SELECT p.*, f.id as fav_id FROM products p 
          INNER JOIN favorites f ON p.id = f.product_id 
          WHERE f.user_id = $user_id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($product = mysqli_fetch_assoc($result)) {
        // Cek promo aktif
        $promoActive = !empty($product['promo_mulai']) && !empty($product['promo_akhir']) && $product['promo_mulai'] <= $today && $today <= $product['promo_akhir'];
        $hasDiscount = $promoActive && intval($product['diskon_persen']) > 0 && $product['harga_diskon'] < $product['price'];

        echo '<div class="item" style="margin: 20px; border: 1px solid #ddd; border-radius: 10px; padding: 15px; width: 220px; display: inline-block; vertical-align: top; position: relative;">';

        if ($hasDiscount) {
            echo '<div class="discount-badge" style="position: absolute; top: 10px; left: 10px; background-color: aliceblue; color: black; padding: 4px 6px; font-size: 12px; border-radius: 4px;">' . $product['diskon_persen'] . '%</div>';
        }

        echo '<img src="../img/' . htmlspecialchars($product['image_url']) . '" alt="' . htmlspecialchars($product['name']) . '" style="width: 100%; height: 180px; object-fit: cover;">';
        echo '<div class="item-content" style="text-align: center; margin-top: 10px;">';
        echo '<h3 style="font-size: 16px;">' . htmlspecialchars($product['name']) . '</h3>';
        echo '<p style="font-size: 14px; color: #666;">' . htmlspecialchars($product['description']) . '</p>';

        echo '<p class="price" style="margin: 10px 0;">';
        if ($hasDiscount) {
            echo '<del style="color:gray;">Rp ' . number_format($product['price'], 0, ',', '.') . '</del><br>';
            echo 'Rp ' . number_format($product['harga_diskon'], 0, ',', '.') . '';
        } else {
            echo 'Rp ' . number_format($product['price'], 0, ',', '.');
        }
        echo '</p>';

        echo '<div style="display: flex; justify-content: center; gap: 10px;">';
        echo '<form action="add_to_cart.php" method="get">';
        echo '<input type="hidden" name="id" value="' . $product['id'] . '">';
        echo '<button type="submit" class="blue-button" style="padding: 6px 10px; color:black; border: none; border-radius: 5px;">Add to Cart</button>';
        echo '</form>';

        echo '<form action="hapus_favorit.php" method="post" onsubmit="return confirm(\'Yakin ingin menghapus dari favorit?\')">';
        echo '<input type="hidden" name="fav_id" value="' . $product['fav_id'] . '">';
        echo '<button type="submit" style="padding: 6px 10px; background-color:rgb(149, 169, 210); color: white; border: none; border-radius: 5px;">Hapus</button>';
        echo '</form>';
        echo '</div>';

        echo '</div></div>';
    }
} else {
    echo "<p>Tidak ada produk favorit.</p>";
}
mysqli_close($conn);
?>
</div>
</main>
<?php include '../footer/footer_favorite.php'; ?>
