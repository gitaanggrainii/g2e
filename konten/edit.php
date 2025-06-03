<?php
session_start();
$conn = new mysqli("localhost", "root", "", "g2e");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Jika form disubmit
if (isset($_POST['update'])) {
    // Ambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $address = $_POST['address'];
    $id = $_SESSION['users'];

    // Buat query untuk update data
    $sql = "UPDATE users SET username='$username', email='$email', telepon='$telepon', address='$address' WHERE id=$id";

    // Jalankan query
    mysqli_query($conn, $sql);

    // Redirect
    header("Location: profile.php");
    exit();
}

// Ambil data user untuk ditampilkan
$user_id = $_SESSION['users'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Profil</title>
  <link rel="stylesheet" href="../css/edit.css">
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <img src="default.png" alt="Foto Profil" class="profile-img" id="sidebarPreview">
      <input type="file" id="fotoInput">
     <a href="profile.php"><button type="button">My Profile</button></a>
     <a href="edit.php"><button type="button">Edit Profile</button></a>
     <a href="riwayat.php"><button type="button">Riwayat Pembelian</button></a>
     <a href="login.php"><button type="button">Logout</button></a>

    </div>

    <!-- Konten utama -->
    <div class="main-content">
      <div class="header">
        <h2>Edit profile</h2>
        <a href="makeup.php"><button type="button">kembali</button></a>
      </div>

      <form id="profileForm" method="POST" action="edit.php">
        <div class="photo-wrapper">
          <img src="default.png" id="preview" class="profile-img">
        </div>

        <label>Nama Lengkap</label>
        <input type="text" id="nama" name="username">

        <label>No HP</label>
        <input type="text" id="nohp" name="telepon">

        <label>Alamat</label>
        <textarea id="alamat" name="address"></textarea>


       <input type="submit" name="update" value="Simpan">

      </form>
    </div>
  </div>

  <script>
    const fotoInput = document.getElementById("fotoInput");
    const preview = document.getElementById("preview");
    const sidebarPreview = document.getElementById("sidebarPreview");

    fotoInput.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          preview.src = e.target.result;
          sidebarPreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
    
  </script>
</body>
</html>
