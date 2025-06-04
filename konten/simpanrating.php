<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION['user_id'])) {
        die("Anda harus login terlebih dahulu.");
    }

    $product_id = intval($_POST['product_id']);
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO product_ratings (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $product_id, $user_id, $rating, $comment);

    if ($stmt->execute()) {
        echo "<script>
            alert('Terima kasih atas ulasan Anda!');
            window.location.href = 'details.php?id=$product_id';
        </script>";
        exit;
    } else {
        echo "Gagal menyimpan rating.";
    }
}
?>
