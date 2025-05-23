<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'];
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Validasi kesamaan password baru dan konfirmasi
if ($new_password !== $confirm_password) {
    echo "<script>alert('Konfirmasi password baru tidak cocok.'); window.history.back();</script>";
    exit;
}

// Cek password lama dari database
$query = "SELECT password FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // Verifikasi password lama
    if (password_verify($old_password, $row['password'])) {
        // Enkripsi password baru dan update
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $update->bind_param("ss", $hashed_password, $email);
        $update->execute();

        echo "<script>alert('Password berhasil diubah.'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Password lama salah.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Akun tidak ditemukan.'); window.location.href='login.php';</script>";
}
?>
