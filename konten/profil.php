<?php
session_start();
include 'koneksi.php';

// Redirect ke login jika belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Pengguna</title>
  <link rel="stylesheet" href="../css/Myprofil.css">
</head>
<body>

<div class="container">
  <!-- Sidebar -->
  <div class="sidebar">
    <img src="uploads/profiles/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Foto Profil" class="profile-img" id="sidebarPreview">
    <input type="file" id="fotoInput" name="fotoInput">
    <a href="profil.php"><button type="button">My Profile</button></a>
    <a href="edit.php"><button type="button">Edit Profile</button></a>
    <a href="riwayat.php"><button type="button">Riwayat Pembelian</button></a>
  </div>

  <!-- Konten utama -->
  <div class="main-content">
    <div class="header">
      <h2>Profil Pengguna</h2>
      <button class="back-btn" onclick="window.location.href='index.php'">Kembali ke Beranda</button>
    </div>

    <form id="profileForm" action="update_profile.php" method="POST" enctype="multipart/form-data">
      <div class="photo-wrapper">
        <img src="uploads/profiles/<?php echo htmlspecialchars($user['profile_picture']); ?>" id="preview" class="profile-img">
      </div>

      <label>Nama Lengkap</label>
      <input type="text" name="full_name" id="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>">

      <label>Email</label>
      <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>">

      <label>No HP</label>
      <input type="tel" name="telepon" id="telepon" value="<?php echo htmlspecialchars($user['telepon']); ?>">

      <label>Alamat</label>
      <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($user['address']); ?>">

      <button type="submit">Simpan</button>
    </form>

    <div id="result" class="result" style="display: none;">
      <img src="uploads/profiles/<?php echo htmlspecialchars($user['profile_picture']); ?>" id="savedFoto" class="profile-img">
      <p><strong>Nama:</strong> <span id="outNama"><?php echo htmlspecialchars($user['full_name']); ?></span></p>
      <p><strong>Email:</strong> <span id="outEmail"><?php echo htmlspecialchars($user['email']); ?></span></p>
      <p><strong>No HP:</strong> <span id="outNoHp"><?php echo htmlspecialchars($user['telepon']); ?></span></p>
      <p><strong>Alamat:</strong> <span id="outAlamat"><?php echo htmlspecialchars($user['address']); ?></span></p>
    </div>
  </div>
</div>

<script>
const fotoInput = document.getElementById("fotoInput");
const preview = document.getElementById("preview");
const sidebarPreview = document.getElementById("sidebarPreview");
const savedFoto = document.getElementById("savedFoto");

fotoInput.addEventListener("change", function () {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
      sidebarPreview.src = e.target.result;
      savedFoto.src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
});

document.getElementById("profileForm").addEventListener("submit", function (e) {
  const nama = document.getElementById("full_name").value;
  const nohp = document.getElementById("telepon").value;
  const email = document.getElementById("email").value;
  const alamat = document.getElementById("address").value;

  if (!nama || !nohp || !email || !alamat) {
    alert("Harap isi semua bidang!");
    e.preventDefault();
    return;
  }

  // Jika semua terisi, tampilkan preview hasil
  document.getElementById("outNama").textContent = nama;
  document.getElementById("outNoHp").textContent = nohp;
  document.getElementById("outEmail").textContent = email;
  document.getElementById("outAlamat").textContent = alamat;
  document.getElementById("result").style.display = "block";
});
</script>

</body>
</html>
