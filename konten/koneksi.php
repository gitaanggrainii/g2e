<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "g2e";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
