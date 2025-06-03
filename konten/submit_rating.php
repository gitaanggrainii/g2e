<?php
session_start();
$conn = new mysqli("localhost", "root", "", "g2e");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $comment = $conn->real_escape_string($_POST['comment']);

    if (!isset($_SESSION['user_id'])) {
        die("Anda harus login terlebih dahulu.");
    }

    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO product_ratings (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $product_id, $user_id, $rating, $comment);

    if ($stmt->execute()) {
        echo "<script>alert('Terima kasih atas ulasan Anda!'); window.location.href='produk.php?id=$product_id';</script>";
    } else {
        echo "Gagal menyimpan ulasan: " . $conn->error;
    }

    $stmt->close();
}
$conn->close();
?>
 