<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="../css/Register.css">
  <script src="https://kit.fontawesome.com/8e0e948c6d.js" crossorigin="anonymous"></script>
</head>
    <body>
    <div class="body">
        <header class="logo-web">
            
            <div class="nama-web">
                <a href="start.php"><h1>G2E</h1></a>
            </div>
            <nav class="navbar-menu">
                <a href="makeup.php">MAKEUP</a>
                <a href="skincare.php">SKINCARE</a>
                <a href="haircare.php">HAIRCARE</a>
                <a href="nails.php">NAILS</a>
                <a href="bath&body.php">BATH & BODY</a>
            </nav>
        <section class="B">
            <div class="search-container">
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
        </section>
        </header>

        <div class="container">
            <span class="icon-close"><a href="start.php"><ion-icon name="close"></ion-icon></a></span>
            <div class="form-login">
                <h2> Register</h2>
                <form action="register_process.php" method="POST" onsubmit="return validateForm()">
                    <div id="notif" style="color:red; margin-bottom: 10px;"></div>
                
                    <div class="input-box">
                        <span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span>
                        <input type="text" name="username" id="username" required>
                        <label>Username</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="mail"></ion-icon></span>
                        <input type="email" name="email" id="email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                        <input type="password" name="password" id="password" required>
                        <label>Password</label>
                    </div>
                    <div class="remember-forgot">
                        <label><input type="checkbox" id="terms" required> Agree to the terms & conditions</label>
                    </div>
                    <button type="submit" class="btn">Register</button>
                    <div class="login-register">
                        <p> Already have an account? <a href="Login.php"> Login</a></p>
                    </div>
                </form>
                <script>
                    function validateForm() {
                        const email = document.getElementById("email").value.trim();
                        const password = document.getElementById("password").value;
                        const terms = document.getElementById("terms").checked;
                        const notif = document.getElementById("notif");
                    
                        notif.innerText = ""; // reset pesan
                    
                        // Validasi email
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(email)) {
                            notif.innerText = "Email tidak valid.";
                            return false;
                        }
                    
                        // Validasi password
                        if (password.length < 6) {
                            notif.innerText = "Password minimal 6 karakter.";
                            return false;
                        }
                    
                        // Validasi checkbox
                        if (!terms) {
                            notif.innerText = "Kamu harus menyetujui syarat & ketentuan.";
                            return false;
                        }
                    
                        return true;
                    }
                    </script>
                               <script>
                                window.onload = () => {
                                    const params = new URLSearchParams(window.location.search);
                                    const notif = document.getElementById("notif");
                                
                                    if (params.get("success") === "1") {
                                        notif.style.color = "green";
                                        notif.innerText = "Registrasi berhasil! Silakan login.";
                                    } else if (params.get("error")) {
                                        notif.style.color = "red";
                                        notif.innerText = "Registrasi gagal. Silakan coba lagi.";
                                    }
                                };
                                </script>
                                     
            </div>
        </div>
    </div>

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

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> 
    </body>
</html>