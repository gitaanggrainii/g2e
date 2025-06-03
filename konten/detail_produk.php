<?php
session_start();
include 'koneksi.php';

// Cek apakah id produk dikirim
if (!isset($_GET['id'])) {
    echo "Produk tidak ditemukan.";
    exit;
}

$product_id = intval($_GET['id']);
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Ambil data produk
$product = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
$data = mysqli_fetch_assoc($product);
if (!$data) {
    echo "Produk tidak ditemukan.";
    exit;
}

// Ambil variasi
$variants = mysqli_query($conn, "SELECT * FROM product_variants WHERE product_id = $product_id");

// Cek wishlist
$in_wishlist = false;
if ($user_id) {
    $wish = mysqli_query($conn, "SELECT * FROM favorites WHERE user_id = $user_id AND product_id = $product_id");
    if ($wish && mysqli_num_rows($wish) > 0) {
        $in_wishlist = true;
    }
}


// Cek promo aktif
$promo_active = false;
$today = date('Y-m-d');
if (!empty($data['harga_diskon']) && $data['harga_diskon'] < $data['price'] &&
    (!empty($data['promo_mulai']) && !empty($data['promo_akhir']) &&
     $today >= $data['promo_mulai'] && $today <= $data['promo_akhir'])) {
    $promo_active = true;
}

// Ambil ulasan untuk produk ini
$reviews = mysqli_query($conn, "SELECT u.*, us.email FROM ulasan u JOIN users us ON u.user_id = us.id WHERE produk_id = $product_id ORDER BY created_at DESC");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/makeup.css">
    <title><?= htmlspecialchars($data['name']) ?> - Detail Produk</title>
    <style>
        .container { display: flex; max-width: 1000px; margin: auto; gap: 30px; margin-top: 50px; }
        .left { flex: 1; }
        .right { flex: 1; display: flex; flex-direction: column; gap: 15px; }
        .thumbnail { width: 60px; height: 60px; object-fit: cover; margin-right: 10px; border: 1px solid #ccc; cursor: pointer; }
        .main-image { width: 100%; max-height: 400px; object-fit: cover; border-radius: 10px; }
        .variant-row { display: flex; margin-top: 10px; }
        .wishlist { font-size: 24px; color: <?= $in_wishlist ? 'red' : '#aaa' ?>; cursor: pointer; }
        .price { font-size: 15px; }
        .btn { padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; }
        .cart-btn { background-color: aliceblue; color: black; }
        .buy-btn { background-color: aliceblue; color: black; }
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
                <a href="search.php"><img id="search-icon" src="https://img.icons8.com/ios/50/search--v1.png" alt="search--v1"/>
                <input id="search-bar" type="text" placeholder="Type to search..." /></a>
            </div>
            <div class="profil-container">
                <a href="<?= isset($_SESSION['email']) ? 'profile.php' : 'login.php' ?>">
                    <img id="user-icon" src="https://img.icons8.com/ios/50/user--v1.png" alt="user--v1" />
                </a>
            </div>
            <div class="cart-container">
                <a href="keranjang.php"><img id="cart-icon" src="https://img.icons8.com/ios/50/online-shop-shopping-bag.png" alt="online-shop-shopping-bag"/></a>
                <span>5</span>
            </div>
            <div>
                <div class="favorite-container">
                  <a href="favorit.php"><img width="20" height="20" id="fav-icon" src="https://img.icons8.com/ios/50/like--v1.png" alt="like--v1"/></a>
                  <span></span>
              </div>
        </section>
    </header>
<div class="container">
    <div class="left">
        <img src="../img/<?= htmlspecialchars($data['image_url']) ?>" class="main-image" id="mainImage">
        <div class="variant-row">
            <?php while ($v = mysqli_fetch_assoc($variants)) { ?>
                <img src="../img/<?= htmlspecialchars($v['gambar_variasi']) ?>" class="thumbnail" onclick="document.getElementById('mainImage').src='../img/<?= htmlspecialchars($v['gambar_variasi']) ?>'">
            <?php } ?>
        </div>
    </div>

    <div class="right">
        <h2><?= htmlspecialchars($data['name']) ?></h2>
        <p><?= nl2br(htmlspecialchars($data['description'])) ?></p>

        <div class="price">
            <?php if ($promo_active): ?>
                <span style="text-decoration: line-through; color: gray;">Rp <?= number_format($data['price'], 0, ',', '.') ?></span><br>
                <strong style="color: black;">Rp <?= number_format($data['harga_diskon'], 0, ',', '.') ?></strong>
            <?php else: ?>
                <strong>Rp <?= number_format($data['price'], 0, ',', '.') ?></strong>
            <?php endif; ?>
        </div>

        <div style="display: flex;">
                <form action="add_to_cart.php" method="post">
                    <input type="hidden" name="product_id" value="<?= $data['id'] ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn cart-btn">Add to Cart</button>
                </form>

            <a href="pembayaran.php?buy_now=<?= $data['id'] ?>" class="btn buy-btn" style="text-decoration: none; margin-left: 20px;">Buy Now</a>
        </div>
    </div>
</div>


<div style="max-width: 1000px; margin: 60px auto 40px; padding: 20px;">
    <h3 style="margin-bottom: 20px;">Ulasan Pengguna</h3>
    <?php if (mysqli_num_rows($reviews) > 0): ?>
        <?php while ($r = mysqli_fetch_assoc($reviews)) : ?>
            <div style="margin-bottom: 20px; padding: 15px 20px; background: #fdfdfd; border: 1px solid #e0e0e0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <strong><?= htmlspecialchars($r['email']) ?></strong> 
                <div style="color: gold; font-size: 16px; margin: 5px 0;">
                  <?php for ($i = 1; $i <= 5; $i++) echo $i <= $r['rating'] ? '★' : '☆'; ?>
                </div>
                <small style="color: #777;"><?= date('d M Y', strtotime($r['created_at'])) ?></small>
                <p style="margin-top: 10px; line-height: 1.5;"><?= nl2br(htmlspecialchars($r['komentar'])) ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="color: #777;">Belum ada ulasan untuk produk ini.</p>
    <?php endif; ?>
</div>


</body>
</html>
