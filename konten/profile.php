<?php
session_start();

// Hanya koneksi ke satu database
$conn = new mysqli("localhost", "root", "", "g2e");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data user yang sedang login
$user = ['full_name' => '', 'email' => '', 'phone_number' => '', 'address' => '', 'profile_picture' => 'default.png'];

if (isset($_SESSION['users'])) {
    $id = $_SESSION['users'];
    $result = $conn->query("SELECT * FROM users WHERE id = $id");
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
}
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

      <a href="profile.php"><button type="button">My Profile</button></a>
      <a href="edit.php"><button type="button">Edit Profile</button></a>
      <a href="riwayat.php"><button type="button">Riwayat Pembelian</button></a>

    </div>

    <!-- Konten utama -->
    <div class="main-content">
      <div class="header">
        <h2>Profil Pengguna</h2>
        <button class="back-btn">Kembali ke Profil</button>
      </div>

      <form id="profileForm" action="update_profile.php" method="POST" enctype="multipart/form-data">
        <div class="photo-wrapper">
          <img src="default.png" id="preview" class="profile-img">
        </div>

        <label>Nama Lengkap</label>
        <input type="text" name="full_name" id="full_name" ...>

        <label>Email</label>
        <input type="email" name="email" id="email" ...>

        <label>No HP</label>
        <input type="tel" name="telepon" id="telepon" ...>

        <label>Alamat</label>
        <input type="text" name="address" id="address" ...>


        <button type="submit">Simpan</button>
      </form>

      <div id="result" class="result">
        <img src="uploads/profiles/<?php echo htmlspecialchars($user['profile_picture']); ?>" id="savedFoto" class="profile-img">
       <p><strong>Nama:</strong> <span id="outfull_name"><?php echo htmlspecialchars($user['full_name']); ?></span></p>
      <p><strong>Email:</strong> <span id="outemail"><?php echo htmlspecialchars($user['email']); ?></span></p>
      <p><strong>No HP:</strong> <span id="outNoHP"><?php echo htmlspecialchars($user['telepon']); ?></span></p>
      <p><strong>Alamat:</strong> <span id="outaddress"><?php echo htmlspecialchars($user['address']); ?></span></p>

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
  // Jangan preventDefault kalau mau submit ke server, kecuali kamu mau pakai AJAX
  // e.preventDefault();

  const nama = document.getElementById("full_name").value;
  const nohp = document.getElementById("telepon").value;
  const email = document.getElementById("email").value;
  const alamat = document.getElementById("address").value;

  if (!nama || !nohp || !email || !alamat) {
    alert("Harap isi semua bidang!");
    e.preventDefault();  // baru cegah submit kalau data tidak lengkap
  }
});


      document.getElementById("outNama").textContent = nama;
      document.getElementById("outNoHp").textContent = nohp;
      document.getElementById("outEmail").textContent = email;
      document.getElementById("outAlamat").textContent = alamat;
      document.getElementById("result").style.display = "block";
    ;
  </script>
</body>
</html>