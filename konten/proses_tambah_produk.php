<?php
include 'koneksi.php';

$nama = $_POST['nama_produk'];
$kategori = $_POST['kategori'];
$deskripsi = $_POST['deskripsi'];
$harga = $_POST['harga'];

$nama_file = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];
$folder = "gambar_produk/";

move_uploaded_file($tmp, $folder . $nama_file);

mysqli_query($conn, "INSERT INTO products (nama_produk, kategori, deskripsi, harga, gambar) 
VALUES ('$nama', '$kategori', '$deskripsi', '$harga', '$nama_file')");

echo "Produk berhasil ditambahkan!";
?>
