<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../css/skincare.css">
    <script src="https://kit.fontawesome.com/8e0e948c6d.js" crossorigin="anonymous"></script>
</head>
<body>
	<header class="logo-web" style="justify-content: space-between;">
        <div class="nama-web">
            <a href="start.php"><h1>G2E</h1></a>
        </div>
        <nav class="navbar-menu">
            <h2>Kelola Produk</h2>
        </nav>
        <section class="B">
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
                  <a href="favorit.php"><img width="20" height="20" src="https://img.icons8.com/ios/50/like--v1.png" alt="like--v1"/></a>
            </div>
        </section>
    </header>
    <form action="simpan_produk.php" method="POST" enctype="multipart/form-data" 
      style="max-width: 500px; margin: 30px auto; padding: 30px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9; font-family: Arial, sans-serif;">
    
    <h2 style="text-align: center; color: black;">Tambah Produk Baru</h2><br>

    <label for="name" style="display: block; margin-bottom: 5px;">Nama Produk:</label>
    <input type="text" name="name" required 
           style="width: 100%; padding: 8px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #ccc;">

    <label for="description" style="display: block; margin-bottom: 5px;">Deskripsi:</label>
    <textarea name="description" required 
              style="width: 100%; padding: 8px; height: 100px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #ccc;"></textarea>

    <label for="price" style="display: block; margin-bottom: 5px;">Harga:</label>
    <input type="number" name="price" required 
           style="width: 100%; padding: 8px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #ccc;">

    <label for="kategori_id" style="display: block; margin-bottom: 5px;">Kategori:</label>
    <select name="kategori_id" required 
            style="width: 100%; padding: 8px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #ccc;">
        <option value="1">Makeup</option>
        <option value="2">Skincare</option>
        <option value="3">Haircare</option>
        <option value="4">Nails</option>
        <option value="5">Bath & Body</option>
    </select>

    <label for="image" style="display: block; margin-bottom: 5px;">Gambar Produk:</label>
    <input type="file" name="image" accept="image/*" required 
           style="margin-bottom: 20px;">

    <button type="submit" 
            style="padding: 10px 20px; background-color: black; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
        Tambah Produk
    </button>
</form>


</body>
</html>
