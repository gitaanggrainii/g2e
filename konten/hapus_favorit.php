<?php
session_start();
include 'koneksi.php';

if (isset($_POST['fav_id'])) {
    $fav_id = intval($_POST['fav_id']);
    mysqli_query($conn, "DELETE FROM favorites WHERE id = $fav_id");
}

header("Location: favorit.php");
exit;
?>
