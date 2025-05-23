<?php
// Menampilkan token yang ada di URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    echo "<script>alert('Token tidak ditemukan.'); window.location.href='forgot_password.php';</script>";
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Password</title>
  <link rel="stylesheet" href="../css/forgot_password.css" />
  <script src="https://kit.fontawesome.com/8e0e948c6d.js" crossorigin="anonymous"></script>
</head>
    <body>
    <div class="body"> 
    <header class="logo-web">
        <div class="nama-web">
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
                  <span></span>
              </div>
        </section>
    </header>
    <div class="container">
      <span class="icon-close"><a href="Login.php"><ion-icon name="close"></ion-icon></a></span>
      <div class="form-login">
        <h2>Reset Password</h2>
        <form action="change_password_process.php" method="POST">
    <input type="hidden" name="token" value="<?php echo $token; ?>">
    <div class="input-box">
        <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
        <input type="password" name="new_password" required />
        <label>New Password</label>
    </div>
    <div class="input-box">
        <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
        <input type="password" name="confirm_password" required />
        <label>Confirm Password</label>
    </div>
    <button type="submit" class="btn">Reset Password</button>
</form>

      </div>
    </div>
  </div>`

  <footer>
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
                 G2e Beauty Store offers a wide range of products, 
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
    </footer>

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
