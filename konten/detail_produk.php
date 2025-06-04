<?php
session_start();
$conn = new mysqli("localhost", "root", "", "g2e");

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = $conn->query("SELECT * FROM products WHERE id = $product_id")->fetch_assoc();

if (!$product) {
    die("Produk tidak ditemukan.");
}

// Ambil variasi produk (jika ada)
$variants = mysqli_query($conn, "SELECT * FROM product_variants WHERE product_id = $product_id");

// Ambil rating & komentar
$stmt = $conn->prepare("SELECT rating, comment FROM product_ratings WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$res = $stmt->get_result();

$total = 0;
$jumlah = 0;
$komentar = [];

while ($row = $res->fetch_assoc()) {
    $total += $row['rating'];
    $jumlah++;
    $komentar[] = $row;
}
$rata2 = $jumlah > 0 ? round($total / $jumlah, 1) : "Belum ada rating";

// Cek promo aktif
$promo_active = false;
$today = date('Y-m-d');
if (!empty($product['harga_diskon']) && $product['harga_diskon'] < $product['price'] &&
    (!empty($product['promo_mulai']) && !empty($product['promo_akhir']) &&
     $today >= $product['promo_mulai'] && $today <= $product['promo_akhir'])) {
    $promo_active = true;
}

// Ambil ulasan untuk produk ini
$reviews = mysqli_query($conn, "
    SELECT pr.rating, pr.comment, u.email 
    FROM product_ratings pr 
    JOIN users u ON pr.user_id = u.id 
    WHERE pr.product_id = $product_id 
    ORDER BY pr.id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/makeup.css">
    <title><?= htmlspecialchars($product['name']) ?> - Detail Produk</title>
    <style>
        .container { display: flex; max-width: 1000px; margin: auto; gap: 30px; margin-top: 50px; }
        .left { flex: 1; }
        .right { flex: 1; display: flex; flex-direction: column; gap: 15px; }
        .thumbnail { width: 60px; height: 60px; object-fit: cover; margin-right: 10px; border: 1px solid #ccc; cursor: pointer; }
        .main-image { width: 100%; max-height: 400px; object-fit: cover; border-radius: 10px; }
        .variant-row { display: flex; margin-top: 10px; }
        .wishlist { font-size: 24px; color: #aaa; cursor: pointer; }
        .price { font-size: 15px; }
        .btn { padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; }
        .cart-btn, .buy-btn { background-color: aliceblue; color: black; }
    </style>
</head>
<body>
<header class="logo-web" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 40px; background-color: #f0f8ff; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
    <div class="nama-web">
        <a href="start.php"><h1>G2E</h1></a>
    </div>
    <nav class="navbar-menu" style="display: flex; gap: 90px;">
        <a href="rekomendasi.php">RECOMMENDATION</a>
        <a href="makeup.php">MAKEUP</a>
        <a href="skincare.php">SKINCARE</a>
        <a href="haircare.php">HAIRCARE</a>
        <a href="nails.php">NAILS</a>
        <a href="bath&body.php">BATH & BODY</a>
    </nav>
    <section class="B" style="display: flex; align-items: center;">
        <div class="search-container">
            <a href="search.php"><img id="search-icon" src="https://img.icons8.com/ios/50/search--v1.png" alt="search"/><input id="search-bar" type="text" placeholder="Type to search..." /></a>
        </div>
        <div class="profil-container">
            <a href="<?= isset($_SESSION['email']) ? 'profile.php' : 'login.php' ?>">
                <img id="user-icon" src="https://img.icons8.com/ios/50/user--v1.png" alt="user" />
            </a>
        </div>
        <div class="cart-container">
            <a href="keranjang.php"><img id="cart-icon" src="https://img.icons8.com/ios/50/online-shop-shopping-bag.png" alt="cart"/></a>
            <span>5</span>
        </div>
        <div class="favorite-container">
            <a href="favorit.php"><img width="20" height="20" id="fav-icon" src="https://img.icons8.com/ios/50/like--v1.png" alt="like"/></a>
            <span></span>
        </div>
    </section>
</header>
<div class="container">
    <div class="left">
        <img src="../img/<?= htmlspecialchars($product['image_url']) ?>" class="main-image" id="mainImage">
        <div class="variant-row">
            <?php while ($v = mysqli_fetch_assoc($variants)) { ?>
                <img src="../img/<?= htmlspecialchars($v['gambar_variasi']) ?>" class="thumbnail" onclick="document.getElementById('mainImage').src='../img/<?= htmlspecialchars($v['gambar_variasi']) ?>'">
            <?php } ?>
        </div>
    </div>
    <div class="right">
        <h2><?= htmlspecialchars($product['name']) ?></h2>
        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
        <div class="price">
            <?php if ($promo_active): ?>
                <span style="text-decoration: line-through; color: gray;">Rp <?= number_format($product['price'], 0, ',', '.') ?></span><br>
                <strong style="color: black;">Rp <?= number_format($product['harga_diskon'], 0, ',', '.') ?></strong>
            <?php else: ?>
                <strong>Rp <?= number_format($product['price'], 0, ',', '.') ?></strong>
            <?php endif; ?>
        </div>
        <div style="display: flex;">
            <form action="add_to_cart.php" method="post">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <button type="submit" class="btn cart-btn">Add to Cart</button>
            </form>
            <a href="pembayaran.php?buy_now=<?= $product['id'] ?>" class="btn buy-btn" style="text-decoration: none; margin-left: 20px;">Buy Now</a>
        </div>
        <form action="favorit.php" method="post">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <button type="submit" class="wishlist" style="background:none; border:none;">♥</button>
        </form>
    </div>
</div>

<div style="max-width: 1000px; margin: 60px auto 40px; padding: 20px;">
    <h3>Ulasan Pengguna</h3>
    <?php while ($row = mysqli_fetch_assoc($reviews)): ?>
        <div style="border-top: 1px solid #ccc; padding: 10px 0;">
            <p><strong><?= htmlspecialchars($row['email']) ?></strong></p>
            <p><?= str_repeat("★", $row['rating']) ?> (<?= $row['rating'] ?>/5)</p>
            <p><?= htmlspecialchars($row['comment']) ?></p>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
