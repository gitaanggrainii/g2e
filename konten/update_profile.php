<?php
session_start();

$conn = new mysqli("localhost", "root", "", "g2e");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_SESSION['users'])) {
    $id = $_SESSION['users'];

    // Ambil data dari form
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $telepon = $conn->real_escape_string($_POST['telepon']);
    $address = $conn->real_escape_string($_POST['address']);

    // Upload foto jika ada
    $profile_picture = '';
    if (isset($_FILES['fotoInput']) && $_FILES['fotoInput']['error'] == 0) {
        $ext = pathinfo($_FILES['fotoInput']['name'], PATHINFO_EXTENSION);
        $profile_picture = 'user_' . $id . '.' . $ext;
        move_uploaded_file($_FILES['fotoInput']['tmp_name'], 'uploads/profiles/' . $profile_picture);
    }

    // Query update
    $sql = "UPDATE users SET 
                full_name='$full_name', 
                email='$email', 
                telepon='$telepon', 
                address='$address'";

    if (!empty($profile_picture)) {
        $sql .= ", profile_picture='$profile_picture'";
    }

    $sql .= " WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: profil.php"); // kembali ke halaman profil
    } else {
        echo "Gagal memperbarui profil: " . $conn->error;
    }
} else {
    echo "User belum login.";
}

$conn->close();
?>
