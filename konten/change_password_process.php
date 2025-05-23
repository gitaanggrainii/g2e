<?php
session_start();
include 'koneksi.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST["new_password"] ?? '';
    $confirm_password = $_POST["confirm_password"] ?? '';
    $token = $_POST["token"] ?? '';

    // Validasi kesamaan password
    if ($new_password !== $confirm_password) {
        echo "<script>alert('Password tidak cocok!'); window.history.back();</script>";
        exit();
    }

    // Validasi token kosong
    if (empty($token)) {
        echo "<script>alert('Token tidak ditemukan.'); window.location.href='forgot_password.php';</script>";
        exit();
    }

    // Cek token di database
    $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);

    if ($stmt->execute()) {
        // Gunakan bind_result jika get_result tidak tersedia
        $stmt->bind_result($email);
        if ($stmt->fetch()) {
            // Token valid, lanjut update password
            $stmt->close();

            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update password di tabel users
            $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $update->bind_param("ss", $hashed_password, $email);
            $update->execute();

            if ($update->affected_rows > 0) {
                echo "<script>alert('Password berhasil diperbarui. Silakan login kembali.'); window.location.href='Login.php';</script>";
            } else {
                echo "<script>alert('Gagal memperbarui password.'); window.location.href='forgot_password.php';</script>";
            }

        } else {
            // Token tidak valid
            echo "<script>alert('Token tidak valid.'); window.location.href='forgot_password.php';</script>";
        }
    } else {
        echo "Query gagal dijalankan: " . $stmt->error;
    }
}
?>
