 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Riwayat Pembelian</title>
  <link rel="stylesheet" href="riwayatpembelian.css" />
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
      <a href="profil.php"><button type="button">My Profile</button></a>
      <a href="edit.php"><button type="button">Edit Profile</button></a>
      <a href="riwayat.php"><button type="button">Riwayat Pembelian</button></a>
    </div>

    <!-- Konten utama -->
   <div class="main-content">
      <div class="header">
        <h2>Riwayat Pembelian</h2>
        <button class="back-btn" onclick="alert('Kembali ke profil')">Kembali ke Profil</button>
      </div>

      <div class="purchase-history">
        <div class="purchase-item">
          <img src="bedak makeover.jpg" alt="Produk" class="product-image" />
          <div class="purchase-details">
            <div class="product-info">
              <h3 class="product-name">Make Over Powerstay</h3>
              <div class="product-price">Rp 180.000</div>
            </div>
            <div class="right-side">
              <div class="status-tracker">📦 Pembelian diproses</div>
              <div class="user-actions">
                <a href="rating.php"><button type="button">Pembelian Selesai</button></a>
                <button class="btn-action">Produk Tidak Sampai</button>
              </div>
            </div>
          </div>
        </div>

        <div class="purchase-item">
          <img src="eye.jpg" alt="Produk" class="product-image" />
          <div class="purchase-details">
            <div class="product-info">
              <h3 class="product-name">Eyeshadow Palette</h3>
              <div class="product-price">Rp 55.000</div>
            </div>
            <div class="right-side">
              <div class="status-tracker">📦 Barang dikemas</div>
              <div class="user-actions">
              <a href="rating.html"><button type="button">Pembelian Selesai</button></a>
                <button class="btn-action">Produk Tidak Sampai</button>
              </div>
            </div>
          </div>
        </div>

        <div class="purchase-item">
          <img src="skintific.jpg" alt="Produk" class="product-image" />
          <div class="purchase-details">
            <div class="product-info">
              <h3 class="product-name">SKINTIFIC - Niacinamide Brightening Serum 50ML | Serum Mencerahkan Dark Spot</h3>
              <div class="product-price">Rp 159.000</div>
            </div>
            <div class="right-side">
              <div class="status-tracker">📦 Barang dikirim</div>
              <div class="user-actions">
                <a href="rating.html"><button type="button">Pembelian Selesai</button></a>
                <button class="btn-action">Produk Tidak Sampai</button>
              </div>
            </div>
          </div>
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
</html>