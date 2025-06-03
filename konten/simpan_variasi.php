<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);

    $folder = "../img/";
    $jumlah_berhasil = 0;

    if (!empty($_FILES['gambar_variasi']['name'][0])) {
        foreach ($_FILES['gambar_variasi']['tmp_name'] as $key => $tmp_name) {
            $nama_file = basename($_FILES['gambar_variasi']['name'][$key]);
            $tujuan = $folder . $nama_file;

            if (move_uploaded_file($tmp_name, $tujuan)) {
                $query = "INSERT INTO product_variants (product_id, gambar_variasi) VALUES ('$product_id', '$nama_file')";
                if (mysqli_query($conn, $query)) {
                    $jumlah_berhasil++;
                }
            }
        }

        header("Location: admin_variasi.php?product_id=$product_id&success=$jumlah_berhasil");
        exit;
    } else {
        echo "Tidak ada gambar yang dipilih.";
    }
} else {
    echo "Metode tidak valid.";
}
?>
