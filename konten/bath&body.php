<?php
include '../header/header.php'; ?>
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

$query = "SELECT * FROM products WHERE kategori_id = 5";
$result = mysqli_query($conn, $query);

$today = date('Y-m-d');

echo '<div style="display: flex; flex-wrap: wrap;">';

while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="product-card" style="position: relative;">'; // pastikan position relative agar badge diskon posisi tepat
    echo '<img src="../img/' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['name']) . '">';

    // Cek promo aktif berdasar tanggal
    $promoActive = false;
    if (!empty($row['promo_mulai']) && !empty($row['promo_akhir'])) {
        if ($row['promo_mulai'] <= $today && $today <= $row['promo_akhir']) {
            $promoActive = true;
        }
    }

    // Tampilkan label diskon jika promo aktif dan diskon > 0
    if ($promoActive && !empty($row['diskon_persen']) && intval($row['diskon_persen']) > 0) {
        echo '<div class="discount-badge" style="position: absolute; background: aliceblue; color: black; padding: 5px; top: 10px; left: 10px; border-radius: 5px; font-size: 12px;">' 
             . intval($row['diskon_persen']) . '%</div>';
    }

    echo '<div class="favorite-icon">';
    echo '<a href="tambah_favorit.php?product_id=' . $row['id'] . '&redirect=favorit.php" style="color: red; font-size: 20px; text-decoration: none;">♥</a>';
    echo '</div>';

    echo '<div class="details">';
    echo '<h4>' . htmlspecialchars($row['name']) . '</h4>';
    echo '<p>' . htmlspecialchars($row['description']) . '</p>';

    // Harga diskon dan harga asli (dicoret) jika promo aktif
    if ($promoActive && !empty($row['harga_diskon']) && $row['harga_diskon'] < $row['price']) {
        echo '<div class="price">';
        echo '<span style="text-decoration: line-through; color: gray;">Rp ' . number_format($row['price'], 0, ',', '.') . '</span><br>';
        echo 'Rp ' . number_format($row['harga_diskon'], 0, ',', '.') . '';
        echo '</div>';
    } else {
        // Tidak ada promo aktif, tampilkan harga normal
        echo '<div class="price">Rp ' . number_format($row['price'], 0, ',', '.') . '</div>';
    }

    echo '<form method="get" action="add_to_cart.php">';
    echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
    echo '<button type="submit" class="blue-button">Add To Cart</button>';
    echo '</form>';
    echo '</div></div>';
}
echo '</div>';
?>
        <div class="motivasi-1" >

            <h2>Get started with our curated Bath & Body Sets!</h2>
            <img src="https://img.icons8.com/forma-thin/24/face-powder.png" alt="face-powder"/>
            <img src="https://img.icons8.com/forma-thin/24/cosmetic-brush.png" alt="cosmetic-brush"/>
            <img src="https://img.icons8.com/forma-thin/24/lip-gloss.png" alt="lip-gloss"/>
            <img src="https://img.icons8.com/forma-thin/24/mascara.png" alt="mascara"/>
            <img src="https://img.icons8.com/forma-thin/24/lipstick.png" alt="lipstick"/>
        </div>
    </main>
    <script src="../js/bath&body.js"></script>
    <?php include '../footer/footer.php'; ?>