<?php
include 'koneksi.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM products WHERE id=$id");
header("Location: dashboard.php?page=daftar");
exit;

