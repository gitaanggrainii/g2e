<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "G2E";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";
if (mysqli_query($conn, $sql)) {
    echo "Registrasi berhasil!";
} else {
    echo "Gagal: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
