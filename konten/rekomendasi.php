<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rekomendasi</title>
    <link rel="stylesheet" href="../css/Rekomendasi.css">
    <script src="https://kit.fontawesome.com/9de9498044.js" crossorigin="anonymous"></script>
</head>
<body>
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
            <a href="search.php">
              <img id="search-icon" src="https://img.icons8.com/ios/50/search--v1.png" alt="search--v1" />
              <input id="search-bar" type="text" placeholder="Type to search..." />
            </a>
          </div>
          
          <div class="profil-container" id="profileContainer">
            <img id="user-icon" src="https://img.icons8.com/ios/50/user--v1.png" alt="User Icon" />
            <div class="sub-menu-wrap" id="subMenu">
              <div class="sub-menu">
                <hr>
                <a href="Login.php" class="sub-menu-link">
                  <img src="login.jpg" width="30">
                  <p>Login</p>
                </a> 
                <a href="profile.php" class="sub-menu-link" onclick="toggleMenu()">
                  <img src="edit profile.jpg" width="30">
                  <p>Profile</p>
                </a>
                <a href="logout.php" class="sub-menu-link" onclick="toggleMenu()">
                  <img src="logout.jpg" width="30">
                  <p>Logout</p>
                </a>
              </div>
            </div>
          </div>
          
          <!-- JavaScript untuk Hover -->
          <script>

  const userIcon = document.getElementById("user-icon");
  const subMenu = document.getElementById("subMenu");
  let isMenuPinned = false;

  // Tampilkan menu saat hover pertama
  document.getElementById("profileContainer").addEventListener("mouseenter", () => {
    if (!isMenuPinned) {
      subMenu.classList.add("open-menu");
    }
  });

  userIcon.addEventListener("click", () => {
    isMenuPinned = !isMenuPinned;
    subMenu.classList.toggle("open-menu");
  });

  
  function toggleMenu() {
    isMenuPinned = false;
    subMenu.classList.remove("open-menu");
  }
</script>

          <div class="cart-container">
            <a href="keranjang.html">
              <img id="cart-icon" src="https://img.icons8.com/ios/50/online-shop-shopping-bag.png" alt="online-shop-shopping-bag" />
            </a>
            <span class="cart-badge">5</span>
          </div>
        
          <div class="favorite-container">
            <a href="favorit.html">
              <img src="https://img.icons8.com/ios/50/like--v1.png" alt="like--v1" width="24" height="24" />
            </a>
          </div>
        
          <div class="edit-container">
            <a href="editprofile.html">
              <img id="akun-icon" src="https://img.icons8.com/forma-thin/24/user-male-circle.png" alt="user-male-circle" />
            </a>
          </div>
        </section>
        
    </header>
    <div class="container">
        <h1><i class="fa-regular fa-star"></i> Product Recommendations<i class="fa-regular fa-star"></i> <i class="fa-sharp fa-light fa-star"></i></h1>
    </div>
    <div class="deskripsi">
        <p>"Beauty starts with the right choice 
             here are our TOP product recommendations for you!"</p>
        <hr>
    </div>
    <div class="product-grid">
        <div class="product-card">
          <div class="product-image">
            <img src="bedakmake.jpg" alt="LipCream GogoTales">
          </div>
          <div class="product-info">
            <h3>Powerstay Total Cover Matte Cream Foundation 12 g - Cream Foundation</h3>
            <p>Make Over Powerstay</p>
            <p class="price">Rp 180.000</p>
            <button class="checkout-btn">Checkout</button>
          </div>
        </div>
    
        <div class="product-card">
          <div class="product-image">
            <img src="lipt barenbliss.jpg" alt="Liptint bnb">
          </div>
          <div class="product-info">
            <h3>BNB barenbliss Peach Makes Perfect Lip Tint Korea</h3>
            <p>Glossy</p>
            <p class="price">Rp 69.999</p>
            <button class="checkout-btn">Checkout</button>
          </div>
        </div>
          
            <div class="product-card">
              <div class="product-image">
                <img src="eye.jpg" alt="LipCream GogoTales">
              </div>
              <div class="product-info">
                <h3>PINKFLASH PinkDessert 12 Shades Eyeshadow Palette High Pigment And Smooth Powder Long Lasting</h3>
                <p>Eyeshadow Palette </p>
                <p class="price">Rp 55.000</p>
                <button class="checkout-btn">Checkout</button>
              </div>
            </div>

            <div class="product-card">
                <div class="product-image">
                  <img src="skintific.jpg" alt="LipCream GogoTales">
                </div>
                <div class="product-info">
                  <h3>SKINTIFIC - Niacinamide Brightening Serum 50ML | Serum Mencerahkan Dark Spot</h3>
                  <p>Brightening Serum </p>
                  <p class="price">Rp 159.000</p>
                  <button class="checkout-btn">Checkout</button>
                </div>
              </div>
          
              <div class="product-card">
                <div class="product-image">
                  <img src="skintific1.jpg" alt="Liptint bnb">
                </div>
                <div class="product-info">
                  <h3>SKINTIFIC - Niacinamide Bright Boost Clay Stick 40g | Brightening Glowing Masker Wajah Komedo Skincare </h3>
                  <p> Bright Boost Clay Stick</p>
                  <p class="price">Rp 79.999</p>
                  <button class="checkout-btn">Checkout</button>
                </div>
              </div>
                
                  <div class="product-card">
                    <div class="product-image">
                      <img src="skincare2.jpg" alt="LipCream GogoTales">
                    </div>
                    <div class="product-info">
                      <h3>SPECIAL BUNDLE 5 in1 Glad2Glow 5pcs Paket Skincare Moisturizer Serum Clay Mask Face Wash Toner-ACNE KIT</h3>
                      <p>GLOWING SET </p>
                      <p class="price">Rp 189.999</p>
                      <button class="checkout-btn">Checkout</button>
                    </div>
                  </div>

                  <div class="product-card">
                    <div class="product-image">
                      <img src="lulur1.jpg" alt="LipCream GogoTales">
                    </div>
                    <div class="product-info">
                      <h3>Lulur Purbasari Original/ Mencerahkan Tubuh/Body Scrub/Perawatan Kulit</h3>
                      <p>Scrub & peel body</p>
                      <p class="price">Rp 15.000</p>
                      <button class="checkout-btn">Checkout</button>
                    </div>
                  </div>
              
                  <div class="product-card">
                    <div class="product-image">
                      <img src="lulur2.jpg" alt="Liptint bnb">
                    </div>
                    <div class="product-info">
                      <h3>Shinzui Skin Lightening Body Scrub 110gr & 200gr Lulur Shinzu'i</h3>
                      <p>Scrub & peel body</p>
                      <p class="price">Rp 17.000</p>
                      <button class="checkout-btn">Checkout</button>
                    </div>
                  </div>
                    
                      <div class="product-card">
                        <div class="product-image">
                          <img src="bodyshop.jpg" alt="LipCream GogoTales">
                        </div>
                        <div class="product-info">
                          <h3>BPOM Grace & Glow Rouge 540 Glow & Firm Scrub Solution Body Wash Niacinamide + Collagen</h3>
                          <p>Sabun Mandi</p>
                          <p class="price">Rp 54.999</p>
                          <button class="checkout-btn">Checkout</button>
                        </div>
                      </div>
                      <div class="product-card">
                        <div class="product-image">
                          <img src="shampo.jpg" alt="LipCream GogoTales">
                        </div>
                        <div class="product-info">
                          <h3>(ORIGINAL) NATUR SHAMPOO ALOE VERA 270ML – MELEBATKAN & MENYEHATKAN RAMBUT</h3>
                          <p>NATUR SHAMPOO ALOE VERA</p>
                          <p class="price">Rp139.000 - Rp189.000
                          </p>
                          <button class="checkout-btn">Checkout</button>
                        </div>
                      </div>
                  
                      <div class="product-card">
                        <div class="product-image">
                          <img src="serum rmbt.jpg" alt="Liptint bnb">
                        </div>
                        <div class="product-info">
                          <h3>MAKARIZO - ADVISOR HAIR RECOVERY VITAMAX 
                            ( 3 x 8 ml ) - Hair Treatment</h3>
                          <p>Vitamin Rambut Multivitamin</p>
                          <p class="price">Rp 29.500</p>
                          <button class="checkout-btn">Checkout</button>
                        </div>
                      </div>
                        
                          <div class="product-card">
                            <div class="product-image">
                              <img src="elips.jpg" alt="LipCream GogoTales">
                            </div>
                            <div class="product-info">
                              <h3>ELLIPS Hair Vitamin (6 Capsules) - ( 50 Capsules)</h3>
                              <p>Hair Vitamin </p>
                              <p class="price">Rp 12.500 - 89.999</p>
                              <button class="checkout-btn">Checkout</button>
                            </div>
                          </div>
      </div>
    

<div class="footer">
    <div class="footer-left">
     <h3>Payment Method</h3>

     <div class="credit-card">
         <img src="bri.png" alt="">
         <img src="mandiri.png" alt="">
         <img src="bca.png" alt="">
         <img src="visa.png" alt="">    
         <img src="shopeepay.png" alt="">
         <img src="ovo.png" alt="">
         <img src="gopay.png" alt="">
         <img src="bni.png" alt="">
         <img src="indomaret.png" alt="">
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

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> 

</body>
</html>