<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembayaran</title>
  <link rel="stylesheet" href="../css/pembayaran.css">
  <script src="https://kit.fontawesome.com/8e0e948c6d.js" crossorigin="anonymous"></script>
</head>

<body>
  <header class="logo-web">
    <div class="nama-web">
      <a href="start.html">
        <h1>G2E</h1>
      </a>
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
      <div class="search-container">
        <img id="search-icon" src="https://img.icons8.com/ios/50/search--v1.png" alt="search--v1" />
        <input id="search-bar" type="text" placeholder="Type to search..." />
      </div>
      <div class="profil-container">
                <a href="<?= isset($_SESSION['email']) ? 'profile.php' : 'login.php' ?>">
                    <img id="user-icon" src="https://img.icons8.com/ios/50/user--v1.png" alt="user--v1" />
                </a>
            </div>
      <div class="cart-container">
        <a href="keranjang.php"><img id="cart-icon" src="https://img.icons8.com/ios/50/online-shop-shopping-bag.png"
            alt="online-shop-shopping-bag" /></a>
        <span>5</span>
      </div>
      <div class="favorite-container">
        <a href="favorit.php"><img width="20" height="20" src="https://img.icons8.com/ios/50/like--v1.png"
            alt="like--v1" /></a>
      </div>
    </section>
  </header>