<?php
session_start();
include 'koneksi.php';

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];

$sql = "DELETE FROM wishlist WHERE user_id = '$user_id' AND product_id = '$product_id'";
if (mysqli_query($conn, $sql)) {
    echo "Produk berhasil dihapus dari wishlist.";
} else {
    echo "Gagal menghapus dari wishlist: " . mysqli_error($conn);
}
?>
