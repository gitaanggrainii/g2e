<?php
session_start();
$conn = new mysqli("localhost", "root", "", "g2e"); // Ganti sesuai database kamu

$email = $_POST['email'];
$password = $_POST['password'];

// Ambil user berdasarkan email
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verifikasi password (plain text)
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['alamat'] = $user['alamat']; // opsional
        $_SESSION['role'] = $user['role'];     // tambahkan ini

        // Arahkan berdasarkan role
        if ($user['role'] === 'admin') {
            header("Location: dashboard.php");
        } else {
            header("Location: rekomendasi.php"); // atau ../user/home.php jika kamu punya
        }
        exit;
    } else {
        echo "<script>alert('Password salah!'); window.location.href='login.php';</script>";
    }
} else {
    echo "<script>alert('Email tidak ditemukan!'); window.location.href='login.php';</script>";
}

$stmt->close();
$conn->close();
