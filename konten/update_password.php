<?php
include 'koneksi.php';

$token = $_POST['token'] ?? '';
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

if ($password !== $confirm) {
    echo "<script>alert('Konfirmasi password tidak cocok.'); window.history.back();</script>";
    exit();
}

$hash = password_hash($password, PASSWORD_DEFAULT);

// Gunakan prepared statement
$stmt = $koneksi->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE reset_token = ?");
$stmt->bind_param("ss", $hash, $token);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo "<script>alert('Password berhasil diubah. Silakan login.'); window.location.href='Login.php';</script>";
} else {
    echo "<script>alert('Token tidak valid atau sudah digunakan.'); window.location.href='forgot_password.php';</script>";
}
?>
