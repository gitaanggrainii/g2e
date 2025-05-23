<?php
include '../konten/koneksi.php';

// Ambil semua produk dengan kategori_id 1 (makeup)
$query = "SELECT * FROM products WHERE kategori_id = 3";
$result = mysqli_query($conn, $query);
?>
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
include '../header/header_haircare.php'; ?>
    <main class="isi">
        <div class="deskripsi">
            <h2>START YOUR BEAUTY JOURNEY</h2>
            <p>"Start your beauty journey with confidence and elegance. 
            <p>Discover the perfect products to enhance your natural glow and redefine your look.</p> 
            <p>Embrace the power of beauty, one step at a time."</p>
            <hr>
        </div>
<?php
include 'koneksi.php';

$query = "SELECT * FROM products WHERE kategori_id = 3";
$result = mysqli_query($conn, $query);
echo '<div style="display: flex; ">';
while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="product-card">';
    echo '<img src="../img/' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['name']) . '">';
    echo '<div class="favorite-icon">';
	echo '<a href="tambah_favorit.php?product_id=' . $row['id'] . '&redirect=favorit.php" style="color: red; font-size: 20px; text-decoration: none;">♥</a>';
	echo '</div>';
	echo '<div class="details">';
    echo '<h4>' . htmlspecialchars($row['name']) . '</h4>';
    echo '<p>' . htmlspecialchars($row['description']) . '</p>';
    echo '<div class="price">Rp ' . number_format($row['price'], 0, ',', '.') . '</div>';
    echo '<form method="get" action="add_to_cart.php">';
    echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
    echo '<button type="submit" class="blue-button">Add To Cart</button>';
    echo '</form>';
    echo '</div></div>';
}
echo '</div>';
?>
        <div class="motivasi-1">
            <h2>Get started with our curated Haircare Sets!</h2>
            <img src="https://img.icons8.com/fluency-systems-regular/50/powder.png" alt="powder"/>
            <img src="https://img.icons8.com/forma-thin/24/cosmetic-brush.png" alt="cosmetic-brush"/>
            <img src="https://img.icons8.com/windows/32/shaving-cream.png" alt="shaving-cream"/>
            <img src="https://img.icons8.com/windows/32/clean-hands.png" alt="clean-hands"/>
            <img src="https://img.icons8.com/forma-thin/24/lipstick.png" alt="lipstick"/>
        </div>
    </main>
<?php include '../footer/footer.php'; ?>