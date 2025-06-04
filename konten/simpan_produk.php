<?php
include 'koneksi.php';

$name = mysqli_real_escape_string($conn, $_POST['name']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$price = $_POST['price'];
$kategori_id = $_POST['kategori_id'];
$diskon_persen = !empty($_POST['diskon_persen']) ? $_POST['diskon_persen'] : null;
$harga_diskon = !empty($_POST['harga_diskon']) ? $_POST['harga_diskon'] : null;
$promo_mulai = !empty($_POST['promo_mulai']) ? $_POST['promo_mulai'] : null;
$promo_akhir = !empty($_POST['promo_akhir']) ? $_POST['promo_akhir'] : null;

$targetDir = "../img/";
$image_name = isset($_FILES['image']) ? basename($_FILES["image"]["name"]) : null;
$targetFile = $targetDir . $image_name;

if ($image_name && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $sql = "INSERT INTO products (
                    name, description, price, kategori_id, image_url, harga_diskon, promo_mulai, promo_akhir, diskon_persen
                ) VALUES (
                    '$name', '$description', '$price', '$kategori_id', '$image_name', " .
                    ($harga_diskon !== null ? "'$harga_diskon'" : "NULL") . ", " .
                    ($promo_mulai ? "'$promo_mulai'" : "NULL") . ", " .
                    ($promo_akhir ? "'$promo_akhir'" : "NULL") . ", " .
                    ($diskon_persen !== null ? "'$diskon_persen'" : "NULL") .
                ")";

        if (mysqli_query($conn, $sql)) {
            $new_product_id = mysqli_insert_id($conn);
            header("Location: admin_variasi.php?product_id=$new_product_id");
            exit;
        } else {
            echo "Gagal menyimpan ke database: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal mengupload gambar.";
    }
} else {
    echo "Tidak ada gambar yang diunggah atau terjadi kesalahan upload.";
}
?>
