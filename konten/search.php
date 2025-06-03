
<?php
session_start();
include 'koneksi.php';

$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$result = false;
$today = date('Y-m-d');

if (!empty($search)) {
    if (!isset($_SESSION['search_history'])) {
        $_SESSION['search_history'] = [];
    }
    $_SESSION['search_history'][] = $search;

    $safe_search = mysqli_real_escape_string($conn, $search);
    $query = "SELECT * FROM products WHERE name LIKE '%$safe_search%' OR description LIKE '%$safe_search%'";
    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="../css/search.css">
    <script src="https://kit.fontawesome.com/8e0e948c6d.js" crossorigin="anonymous"></script>
</head>
<body>
    <header class="logo-web" style="width: 100%;">
        <div class="nama-web" style="margin-top: 35px;">
            <a href="start.php"><h1>G2E</h1></a>
        </div>
        <nav class="navbar-menu">
            <a href="rekomendasi.php">RECOMMENDATION</a>
            <a href="makeup.php">MAKEUP</a>
            <a href="skincare.php">SKINCARE</a>
            <a href="haircare.php">HAIRCARE</a>
            <a href="nails.php">NAILS</a>
            <a href="bath&body.php">BATH & BODY</a>
        </nav>
        <section class="B">
            <div class="search-container" style="margin-top: 3px;">
                <img id="search-icon" src="https://img.icons8.com/ios/50/search--v1.png" alt="search--v1"/>
                <input id="search-bar" type="text" placeholder="Type to search..." />
            </div>
            <div class="profil-container">
                <a href="Login.php"><img id="user-icon" src="https://img.icons8.com/ios/50/user--v1.png" alt="user--v1"/></a> 
            </div>
            <div class="cart-container">
                <a href="keranjang.php"><img id="cart-icon" src="https://img.icons8.com/ios/50/online-shop-shopping-bag.png" alt="online-shop-shopping-bag"/></a>
                <span>5</span>
            </div>
            <div>
                <div class="favorite-container">
                  <a href="favorit.php"><img width="20" height="20" src="https://img.icons8.com/ios/50/like--v1.png" alt="like--v1"/></a>
              </div>
        </section>
    </header>

    <div class="container">
    <div class="search-bar-container">
        <form method="get" action="search.php">
            <input type="text" name="q" placeholder="Cari produk..." value="<?= htmlspecialchars($search) ?>" style="width: 98%; padding: 15px;">
        </form>
    </div>

    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        echo '<div style="display: flex; flex-wrap: wrap; gap: 30px;">';
        while ($row = mysqli_fetch_assoc($result)) {
            $promoActive = !empty($row['promo_mulai']) && !empty($row['promo_akhir']) && ($row['promo_mulai'] <= $today && $today <= $row['promo_akhir']);
            $hasDiscount = $promoActive && intval($row['diskon_persen']) > 0 && $row['harga_diskon'] < $row['price'];

            echo '<div class="item" style="width: 220px; border: 1px solid #ccc; border-radius: 10px; overflow: hidden; padding: 10px; background: #fff; position: relative; margin-bottom: 25px; margin-top:25px;">';
            if ($hasDiscount) {
                echo '<div class="discount-badge" style="position: absolute; top: 10px; left: 10px; background-color: aliceblue; color: black; padding: 4px 6px; font-size: 12px; border-radius: 4px;">' . $row['diskon_persen'] . '% UP</div>';
            }
            echo '<img src="../img/' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['name']) . '" style="width: 100%; height: 180px; object-fit: cover;">';
            echo '<div class="item-content" style="margin-top: 10px;">';
            echo '<h3 style="font-size: 16px; margin: 5px 0;">' . htmlspecialchars($row['name']) . '</h3>';
            echo '<p style="font-size: 14px; color: #555;">' . htmlspecialchars($row['description']) . '</p>';
            echo '<p class="price" style="margin: 10px 0;">';
            if ($hasDiscount) {
                echo '<del style="color:gray;">Rp ' . number_format($row['price'], 0, ',', '.') . '</del><br>';
                echo 'Rp ' . number_format($row['harga_diskon'], 0, ',', '.') . '';
            } else {
                echo 'Rp ' . number_format($row['price'], 0, ',', '.');
            }
            echo '</p>';
            echo '<a href="tambah_favorit.php?product_id=' . $row['id'] . '&redirect=search.php?q=' . urlencode($search) . '">';
            echo '<button class="blue-button" style="width: 100%;  color: white; border: none; padding: 8px; border-radius: 5px;">Add to Cart</button></a>';
            echo '</div></div>';
        }
        echo '</div>';
    } elseif (!empty($search)) {
        echo "<p>Tidak ada produk yang cocok untuk: <strong>" . htmlspecialchars($search) . "</strong></p>";
        if (!$result) {
            echo "<p>Error detail: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p>Silakan masukkan kata kunci pencarian.</p>";
    }
    ?>
    </div>
 <?php include '../footer/footer.php'; ?>