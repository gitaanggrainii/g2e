<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


// Ambil riwayat pembelian dari user, join ke products
$query = "
    SELECT 
        r.purchase_id,
        r.product_name,
        r.quantity,
        r.price,
        r.purchase_date,
        r.status,
        p.image_url
    FROM riwayat r
    LEFT JOIN products p ON r.product_name = p.name
    WHERE r.user_id = $user_id
    ORDER BY r.purchase_date DESC
";
$result = mysqli_query($conn, $query);
?>

 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Riwayat Pembelian</title>
  <link rel="stylesheet" href="../css/riwayatpembelian.css" />
  <style>
    body {
      margin: 0;
      font-family: sans-serif;
    }

    .container {
      display: flex;
    }

    .sidebar {
      width: 250px;
      background-color: #f4f4f4;
      padding: 20px;
      height: 100vh;
      box-sizing: border-box;
    }

    .sidebar .profile-img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 10px;
    }

    .sidebar input[type="file"] {
      margin-bottom: 15px;
    }

    .sidebar button {
      width: 100%;
      margin-bottom: 10px;
      padding: 10px;
      cursor: pointer;
    }

    .main-content {
      flex: 1;
      padding: 20px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .purchase-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border: 1px solid #ccc;
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 20px;
    }

    .product-image {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 10px;
      margin-right: 20px;
    }

    .purchase-details {
      display: flex;
      flex: 1;
      justify-content: space-between;
      align-items: center;
    }

    .product-info {
      flex: 1;
    }

    .product-name {
      font-size: 18px;
      margin: 0 0 8px;
    }

    .product-price {
      font-size: 16px;
      color: #666;
    }

    .right-side {
      text-align: right;
    }

    .status-tracker {
      font-size: 14px;
      margin-bottom: 10px;
    }

    .btn-action {
      padding: 8px 12px;
      margin-left: 5px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn-action:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <img src="default.png" alt="Foto Profil" class="profile-img" id="sidebarPreview" />
      <input type="file" id="fotoInput" />
      <a href="profile.php"><button type="button">My Profile</button></a>
      <a href="edit.php"><button type="button">Edit Profile</button></a>
      <a href="riwayat.php"><button type="button">Riwayat Pembelian</button></a>
      <a href="login.php"><button type="button">Logout</button></a>
    </div>

    <!-- Konten utama -->
   <div class="main-content">
      <div class="header">
        <h2>Riwayat Pembelian</h2>
        <a href="makeup.php"><button type="button">Kembali</button></a>
      </div>

      <div class="purchase-history">
  <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <div class="purchase-item">
      <img src="../img/<?= htmlspecialchars($row['image_url'] ?? 'default.png') ?>" alt="Produk" class="product-image" />
      <div class="purchase-details">
        <div class="product-info">
          <h3 class="product-name"><?= htmlspecialchars($row['product_name']) ?></h3>
          <div class="product-price">Rp <?= number_format($row['price'], 0, ',', '.') ?></div>
        </div>
        <div class="right-side">
          <div class="status-tracker">📦 <?= ucfirst($row['status']) ?></div>
          <div class="user-actions">
            <a href="rating.php?product=<?= urlencode($row['product_name']) ?>">
              <button type="button">Pembelian Selesai</button>
            </a>
            <button class="btn-action">Produk Tidak Sampai</button>
          </div>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>

      </div>
    </div>
  </div>

  <script>
    const fotoInput = document.getElementById("fotoInput");
    const sidebarPreview = document.getElementById("sidebarPreview");

    fotoInput.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          sidebarPreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
  </script>
</body>