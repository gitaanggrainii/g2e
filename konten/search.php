
 <?php
include 'koneksi.php'; // Ganti sesuai dengan lokasi file koneksi Anda

// Cek apakah ada pencarian
$search = isset($_GET['q']) ? trim($_GET['q']) : '';

// Simpan ke riwayat pencarian (jika pakai session untuk demo)

if (!empty($search)) {
    $_SESSION['search_history'][] = $search;
    // Query pencarian produk
    $query = "SELECT * FROM products WHERE name LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
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
        echo '<div style="display: flex; gap: 30px; margin-top: 50px;">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="item">';
            echo '<img src="../img/' . $row['image_url'] . '" width="100">';
            echo '<div class="item-content">';
            echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
            echo '<p>' . htmlspecialchars($row['description']) . '</p>';
            echo '<p class="price">Rp ' . number_format($row['price'], 0, ',', '.') . '</p>';
            echo '<a href="tambah_favorit.php?product_id=' . $row['id'] . '&redirect=search.php?q=' . urlencode($search) . '"><button>Add to Cart</button></a>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo "<p>Tidak ada produk yang ditemukan atau terjadi kesalahan pada query.</p>";
        if (!$result) {
            echo "<p>Error detail: " . mysqli_error($conn) . "</p>";
        }
    }
    ?>
    </div>
 <?php include '../footer/footer.php'; ?>