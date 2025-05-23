<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liptint SADA</title>
  <link rel="stylesheet" href="../css/variasi1.css">
  <script src="https://kit.fontawesome.com/8e0e948c6d.js" crossorigin="anonymous"></script>
</head>
<body>
  <header class="logo-web">
    <div class="nama-web">
        <h1>G2E</h1>
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
            <a href="search.php"><img id="search-icon" src="https://img.icons8.com/ios/50/search--v1.png" alt="search--v1"/>
            <input id="search-bar" type="text" placeholder="Type to search..." /></a>
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
            <a href="favorit.php"><img width="20" height="20" id="fav-icon" src="https://img.icons8.com/ios/50/like--v1.png" alt="like--v1"/></a>
        </div>
        
    </section>
</header>
<main class="details">
  <div class="product-detail">
    <div class="product-images">
      <div class="thumbnail">
        <img src="../img/sada1.webp" alt="Thumbnail 1">
      </div>
      <div class="thumbnail">
        <img src="../img/sada2.webp" alt="Thumbnail 2">
      </div>
      <div class="thumbnail">
        <img src="../img/sada3.webp" alt="Thumbnail 3">
      </div>
      <div class="thumbnail">
        <img src="../img/sada4.webp" alt="Thumbnail 4">
      </div>
    </div>

    <div class="main-image">
      <img src="../img/lips1.jpeg" alt="Main Product">
    </div>

    <div class="product-info">
      <h1 class="product-title">Liptint SADA</h1>
      <p class="product-subtitle">Glossy</p>
      <p class="product-rating">★★★★★ (1 Review)</p>

      <div class="price-section">
        <span class="discounted-price">Rp 81.000</span>
      </div>

      <div class="quantity-section">
        <button class="quantity-btn" onclick="decreaseQuantity()">−</button>
        <input type="number" id="quantity" value="1" min="1">
        <button class="quantity-btn" onclick="increaseQuantity()">+</button>
      </div>

      <button class="add-to-cart">Add to Cart</button>

      <div class="product-description">
        <h3>Details</h3>
        <p>
            Liptint SADA dirancang khusus untuk Anda yang menginginkan tampilan bibir natural, segar, dan bercahaya sepanjang hari.
            Dengan tekstur ringan dan hasil akhir glossy, produk ini memastikan bibir tetap lembap tanpa terasa lengket.
        </p>
      </div>
    </div>
  </div>
</main>
  <div class="footer">
    <div class="footer-left">
     <h3>Payment Method</h3>

     <div class="credit-card">
         <img src="../img/bri.png" alt="">
         <img src="../img/mandiri.png" alt="">
         <img src="../img/bca.png" alt="">
         <img src="../img/visa.png" alt="">
         <img src="../img/shopeepay.png" alt="">
         <img src="../img/ovo.png" alt="">
         <img src="../img/gopay.png" alt="">
         <img src="../img/bni.png" alt="">
         <img src="../img/indomaret.png" alt="">
    </div>
    <p class="footer-copyright">beauty store G2E</p>
  </div>

<div class="footer-center">
  <div>
      <i class="fa fa-map-marker"></i>
      <p><span>Indonesia</span>JawaBarat, Bandung</p>
     </div>
     <div>
         <i class="fa-regular fa-phone fa-2xs"></i>
         <p>+62 95-0413-6744</p>
     </div>
     <div>
      <i class="fa fa-envelope"></i>
      <p><a href="#">G2eBeauty@gmail.com</a></p>
  </div>
</div>
<div class="footer-right">
  <p class="footer-about">
      <span>About Us</span>
      G2E Beauty Store offers a wide range of products, 
      including beauty, skincare, and much more!
      Enjoy shopping here!
  </p>

  <div class="footer-media">
      <a href="#"><i class="fa fa-youtube"></i></a>
      <a href="#"><i class="fa fa-instagram"></i></a>
      <a href="#"><i class="fa fa-twitter"></i></a>
  </div>
</div>
</div>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> 
  <script src="variasi1.js"></script>
</body>
</html>
