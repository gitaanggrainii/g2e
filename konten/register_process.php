<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // supaya aman

    $cek = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $cek->bind_param("s", $email);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows > 0) {
        echo "Email sudah digunakan!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        if ($stmt->execute()) {
            echo "Register berhasil! <a href='Login.php'>Login di sini</a>";
            header("Location: Registerr.php?success=1");
            exit();
        } else {
            echo "Terjadi kesalahan saat menyimpan data.";
            header("Location: Registerr.php?error=gagal");
            exit();
        }

    }
    $stmt->close();
    $cek->close();
    $conn->close();
}
?>
