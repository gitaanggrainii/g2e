<?php
include 'koneksi.php';

// Ambil data dari form
$name = mysqli_real_escape_string($conn, $_POST['name']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$price = $_POST['price'];
$kategori_id = $_POST['kategori_id'];
$harga_diskon = !empty($_POST['harga_diskon']) ? $_POST['harga_diskon'] : null;
$promo_mulai = !empty($_POST['promo_mulai']) ? $_POST['promo_mulai'] : null;
$promo_akhir = !empty($_POST['promo_akhir']) ? $_POST['promo_akhir'] : null;

// Cek apakah file gambar dikirim
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $targetDir = "../img/";
    $image_name = basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $image_name;

    // Pindahkan file ke folder img/
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {

        // Siapkan query SQL dengan promo
        $sql = "INSERT INTO products (
                    name, description, price, kategori_id, image_url, harga_diskon, promo_mulai, promo_akhir
                ) VALUES (
                    '$name', '$description', '$price', '$kategori_id', '$image_name', " .
                    ($harga_diskon !== null ? "'$harga_diskon'" : "NULL") . ", " .
                    ($promo_mulai ? "'$promo_mulai'" : "NULL") . ", " .
                    ($promo_akhir ? "'$promo_akhir'" : "NULL") .
                ")";

    if (mysqli_query($conn, $sql)) {
    $new_product_id = mysqli_insert_id($conn);
    header("Location: admin_variasi.php?product_id=$new_product_id");
    exit;
            // Redirect ke halaman sesuai kategori
            switch ($kategori_id) {
                case 1:
                    header("Location: makeup.php");
                    break;
                case 2:
                    header("Location: skincare.php");
                    break;
                case 3:
                    header("Location: haircare.php");
                    break;
                case 4:
                    header("Location: nails.php");
                    break;
                case 5:
                    header("Location: bath&body.php");
                    break;
                default:
                    header("Location: admin.php");
                    break;
            }
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
