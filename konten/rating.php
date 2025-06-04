<?php
session_start();
$conn = new mysqli("localhost", "root", "", "g2e");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $comment = $conn->real_escape_string($_POST['comment']);

    // Ambil user_id dari sesi login
    if (!isset($_SESSION['user_id'])) {
        die("Anda harus login terlebih dahulu.");
    }
    $user_id = $_SESSION['user_id'];

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO product_ratings (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $product_id, $user_id, $rating, $comment);
    
    if ($stmt->execute()) {
        echo "<script>alert('Terima kasih atas ulasan Anda!'); window.location.href='produk.php';</script>";
    } else {
        echo "Gagal menyimpan ulasan: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/rating.css">
</head>
<body>

     <header class="logo-web">
        <div class="nama-web">
            <a href="start.html"><h1>G2E</h1></a>
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
            <a href="search.html">
              <img id="search-icon" src="https://img.icons8.com/ios/50/search--v1.png" alt="search--v1" />
              <input id="search-bar" type="text" placeholder="Type to search..." />
            </a>
          </div>
          
          <div class="profil-container" id="profileContainer">
            <img id="user-icon" src="https://img.icons8.com/ios/50/user--v1.png" alt="User Icon" />
            <div class="sub-menu-wrap" id="subMenu">
              <div class="sub-menu">
                <hr>
                <a href="Login.html" class="sub-menu-link">
                  <img src="login.jpg" width="30">
                  <p>Login</p>
                </a> 
                <a href="profile.html" class="sub-menu-link" onclick="toggleMenu()">
                  <img src="edit profile.jpg" width="30">
                  <p>Profile</p>
                </a>
                <a href="settings.html" class="sub-menu-link" onclick="toggleMenu()">
                  <img src="setting.jpg" width="30">
                  <p>Settings</p>
                </a>
                <a href="logout.html" class="sub-menu-link" onclick="toggleMenu()">
                  <img src="logout.jpg" width="30">
                  <p>Logout</p>
                </a>
                <a href="admin.html" class="sub-menu-link" onclick="toggleMenu()">
                  <img src="adminpict.png" width="30">
                  <p>Admin</p>
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

  // JavaScript Rating ke Input Hidden
const bintangSpan = document.querySelectorAll('#bintangContainer span');
const ratingInput = document.getElementById('ratingInput');

bintangSpan.forEach((star, index) => {
    star.addEventListener('click', () => {
        bintangSpan.forEach(s => s.textContent = '☆');
        for (let i = 0; i <= index; i++) {
            bintangSpan[i].textContent = '★';
        }
        ratingInput.value = index + 1;
    });
});

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
    <title>Beri Rating Produk</title>
    <link rel="stylesheet" href="style.css">

      <form action="rating.php" method="POST">
        <input type="hidden" name="product_id" value="1"> <!-- Sesuaikan ID produk -->
        <input type="hidden" name="rating" id="ratingInput" value="0">

      <div class="container">
        <h1>Rating Produk</h1>
        <hr>

        <!-- Bagian Info Produk -->
        <div class="produk">
            <img src="bedak makeover.jpg" alt="Gambar Produk">
            <div class="info">
                <h3>Make Over Powerstay</h3>
                <p>Harga: Rp 180.000</p>
            </div>
        </div>
        
        <!-- Bagian Rating Bintang -->
        <div class="rating">
            <p>Berikan bintang:</p>
            <div class="bintang">
                <span>☆</span>
                <span>☆</span>
                <span>☆</span>
                <span>☆</span>
                <span>☆</span>
            </div>
        </div>
        
        <!-- Bagian Komentar -->
        <div class="komentar">
            <p>Tulis komentar:</p>
            <textarea rows="4"></textarea>
        </div>
        
        <!-- Tombol Kirim -->
        <button class="tombol">Kirim Review</button>
    </div>

<script>
    const bintangSpan = document.querySelectorAll('#bintangContainer span');
    const ratingInput = document.getElementById('ratingInput');

    bintangSpan.forEach((star, index) => {
        star.addEventListener('click', () => {
            // Reset semua bintang ke kosong
            bintangSpan.forEach(s => s.textContent = '☆');

            // Isi bintang sampai indeks yang diklik
            for (let i = 0; i <= index; i++) {
                bintangSpan[i].textContent = '★';
            }

            // Simpan nilai rating ke input hidden
            ratingInput.value = index + 1;
        });
    });
</script>


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