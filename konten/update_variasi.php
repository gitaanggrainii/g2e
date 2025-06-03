<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    // Ambil data lama
    $old = mysqli_query($conn, "SELECT * FROM product_variants WHERE id = $id");
    $old_data = mysqli_fetch_assoc($old);
    if (!$old_data) {
        echo "Variasi tidak ditemukan."; exit;
    }

    if (isset($_FILES['gambar_baru']) && $_FILES['gambar_baru']['error'] === UPLOAD_ERR_OK) {
        $nama_baru = basename($_FILES['gambar_baru']['name']);
        $target = "../img/" . $nama_baru;

        if (move_uploaded_file($_FILES["gambar_baru"]["tmp_name"], $target)) {
            mysqli_query($conn, "UPDATE product_variants SET gambar_variasi = '$nama_baru' WHERE id = $id");
            header("Location: admin_tambah_variasi.php?product_id=" . $old_data['product_id'] . "&edited=1");
            exit;
        } else {
            echo "Gagal upload gambar.";
        }
    } else {
        echo "Gambar tidak valid.";
    }
}
?>
