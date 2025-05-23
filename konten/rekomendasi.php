<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/rekomendasi.css">
    <script src="https://kit.fontawesome.com/9de9498044.js" crossorigin="anonymous"></script>
</head>

<body>
    <header class="logo-web">
        <div class="nama-web">
            <a href="start.php">
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
                <a href="search.php"><img id="search-icon" src="https://img.icons8.com/ios/50/search--v1.png"
                        alt="search--v1" />
                    <input id="search-bar" type="text" placeholder="Type to search..." /></a>
            </div>
            <div class="profil-container">
                <a href="<?= isset($_SESSION['email']) ? 'profile.php' : 'login.php' ?>">
                    <img id="user-icon" src="https://img.icons8.com/ios/50/user--v1.png" alt="user--v1" />
                </a>
            </div>
            <div class="cart-container">
                <a href="keranjang.php"><img id="cart-icon"
                        src="https://img.icons8.com/ios/50/online-shop-shopping-bag.png"
                        alt="online-shop-shopping-bag" /></a>
                <span>5</span>
            </div>
            <div>
                <div class="favorite-container">
                    <a href="favorit.php"><img width="20" height="20" src="https://img.icons8.com/ios/50/like--v1.png"
                            alt="like--v1" /></a>
                </div>
        </section>
    </header>
    <div class="container">
        <i class="fa-solid fa-circle-arrow-left"></i>
        <h1><i class="fa-regular fa-star"></i> Product Recommendations!<i class="fa-regular fa-star"></i> <i
                class="fa-sharp fa-light fa-star"></i></h1>
    </div>
    <div class="grid" id="productGrid">

    </div>

    <div class="overlay" id="overlay">
        <div class="popup" id="popup">
            <h3 id="popupTitle">Product Name</h3>
            <p id="popupDescription">Product description goes here...</p>
            <p class="price" id="popupPrice">$0.00</p>
            <button class="close-btn" id="closePopup">Shop</button>
        </div>
    </div>

    <script>
        const products = [
            { id: 1, name: "NARS Liquid BlushOn ", description: "BlushOn ", price: "Rp 200.000", image: "../img/liq.png" },
            { id: 2, name: "FIT ME Foundation", description: " Poreless Liquid Foundation  Makeup Ringan High Cover 16 Jam Oil Control", price: " Rp 150.000", image: "../img/fiit.png" },

            { id: 6, name: "Product 6", description: "Description for Product 6", price: "Rp 125.000", image: "../img/lip.png" },
            { id: 7, name: "Product 7", description: "Description for Product 7", price: "Rp 95.000", image: "../img/g2g.png" },

            { id: 11, name: "Product 11", description: "Description for Product 11", price: "$60.00", image: "../img/cust.png" },
            { id: 12, name: "Product 12", description: "Description for Product 12", price: "$65.00", image: "../img/bth.png" },

        ];


        const productGrid = document.getElementById('productGrid');
        const overlay = document.getElementById('overlay');
        const popup = document.getElementById('popup');
        const popupTitle = document.getElementById('popupTitle');
        const popupDescription = document.getElementById('popupDescription');
        const popupPrice = document.getElementById('popupPrice');
        const closePopup = document.getElementById('closePopup');

        function showPopup(product) {
            popupTitle.textContent = product.name;
            popupDescription.textContent = product.description;
            popupPrice.textContent = product.price;
            overlay.style.display = 'flex';
        }

        function hidePopup() {
            overlay.style.display = 'none';
        }

        products.forEach(product => {
            const productElement = document.createElement('div');
            productElement.classList.add('product');
            productElement.innerHTML = `
                <img src="${product.image}" alt="${product.name}">
                <div class="product-details">
                    <h3>${product.name}</h3>
                    <p>${product.description.substring(0, 20)}...</p>
                    <p class="price">${product.price}</p>
                </div>
            `;

            productElement.addEventListener('click', () => showPopup(product));
            productGrid.appendChild(productElement);
        });

        closePopup.addEventListener('click', hidePopup);
        overlay.addEventListener('click', hidePopup);
    </script>
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