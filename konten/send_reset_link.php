<?php
include 'koneksi.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';

    if (empty($email)) {
        echo "Email wajib diisi.";
        exit;
    }

    // Cek apakah email ada di tabel users
    $cek = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $cek->bind_param("s", $email);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows === 0) {
        echo "Email tidak terdaftar.";
        exit;
    }

    // Hapus token lama (jika ada)
    $update = $conn->prepare("UPDATE password_resets SET status = 'used', used_at = NOW() WHERE token = ?");
    $update->bind_param("s", $token);
    $update->execute();    

    // Buat dan simpan token baru
    $token = bin2hex(random_bytes(32));
    $simpan = $conn->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
    $simpan->bind_param("ss", $email, $token);

    if ($simpan->execute()) {
        echo "Link reset: <a href='reset_password.php?token=$token'>Klik untuk reset password</a>";
    } else {
        echo "Gagal menyimpan token: " . $conn->error;
    }
} else {
    echo "Akses tidak valid.";
}
?>
