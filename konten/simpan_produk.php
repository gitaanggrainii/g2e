<?php
include 'koneksi.php';

// Ambil data dari form
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$kategori_id = $_POST['kategori_id'];

// Cek apakah file gambar dikirim
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $targetDir = "../img/";
    $image_name = basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $image_name;

    // Pindahkan file ke folder img/
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Simpan data ke database
        $sql = "INSERT INTO products (name, description, price, kategori_id, image_url) 
                VALUES ('$name', '$description', '$price', '$kategori_id', '$image_name')";

        if (mysqli_query($conn, $sql)) {
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
                    header("Location: admin.php"); // fallback jika kategori tidak dikenal
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
