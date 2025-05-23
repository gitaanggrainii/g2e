<?php
include 'koneksi.php';
$id = intval($_GET['id']);
mysqli_query($conn, "DELETE FROM cart WHERE id = $id");
header("Location: keranjang.php");
