<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

if ($product_id <= 0) {
    die("Produk tidak valid.");
}

// === Proses saat form disubmit ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = intval($_POST['rating']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    $stmt = $conn->prepare("INSERT INTO product_ratings (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $product_id, $user_id, $rating, $comment);

    if ($stmt->execute()) {
        echo "<script>alert('Terima kasih atas ulasan Anda!'); window.location.href='detail_produk.php?id={$product_id}';</script>";
        exit;
    } else {
        echo "Gagal menyimpan ulasan: " . $conn->error;
    }
}

// Ambil produk berdasarkan riwayat user
$query = "
    SELECT 
        r.purchase_id,
        r.product_name,
        r.quantity,
        r.price,
        r.purchase_date,
        r.status,
        p.id AS product_id,
        p.image_url,
        p.name
    FROM riwayat r
    JOIN products p ON r.product_name = p.name
    WHERE r.user_id = ? AND p.id = ?
    LIMIT 1
";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product || !$product['product_id']) {
    die("Produk tidak ditemukan atau bukan milik Anda.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Rating Produk</title>
  <style>
    body {
      font-family: sans-serif;
      margin: 20px;
    }

    .produk {
      border: 1px solid #ccc;
      padding: 20px;
      border-radius: 10px;
      display: flex;
      align-items: center;
    }

    .produk img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 8px;
      margin-right: 20px;
    }

    .info {
      flex: 1;
    }

    .bintang span {
      font-size: 24px;
      cursor: pointer;
    }

    .komentar textarea {
      width: 100%;
      padding: 8px;
      margin-top: 10px;
      resize: vertical;
    }

    .tombol {
      margin-top: 10px;
      padding: 10px 16px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .tombol:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<h1>Rating Produk</h1>

<form action="" method="POST">
  <input type="hidden" name="rating" class="rating-input" value="0">

  <div class="produk">
    <img src="../img/<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
    <div class="info">
      <h3><?= htmlspecialchars($product['name']) ?></h3>
      <p>Harga: Rp <?= number_format($product['price'], 0, ',', '.') ?></p>

      <div class="rating">
        <p>Berikan bintang:</p>
        <div class="bintang">
          <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
        </div>
      </div>

      <div class="komentar">
        <p>Komentar:</p>
        <textarea name="comment" rows="3" placeholder="Tulis komentar..." required></textarea>
      </div>

      <button type="submit" class="tombol">Kirim Review</button>
    </div>
  </div>
</form>

<script>
  const stars = document.querySelectorAll('.bintang span');
  const ratingInput = document.querySelector('.rating-input');

  stars.forEach((star, index) => {
    star.addEventListener('click', () => {
      stars.forEach((s, i) => {
        s.textContent = i <= index ? '★' : '☆';
      });
      ratingInput.value = index + 1;
    });
  });
</script>

</body>
</html>
