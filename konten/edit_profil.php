 <?php
session_start();
include 'koneksi.php';
include '../header/header.php';

$email = $_SESSION['email'] ?? '';
if (!$email) {
    header("Location: login.php");
    exit;
}

// Ambil data user dari database
$query = $conn->prepare("SELECT * FROM users WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

// Proses form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = $_POST['nama'] ?? '';
    $alamat = $_POST['alamat'] ?? '';

    $update = $conn->prepare("UPDATE users SET nama = ?, alamat = ? WHERE email = ?");
    $update->bind_param("sss", $nama, $alamat, $email);

    if ($update->execute()) {
        $_SESSION['username'] = $nama;
        $_SESSION['alamat'] = $alamat; // update alamat juga jika ditampilkan dari session
        header("Location: profile.php");
        exit;
    } else {
        echo "Gagal memperbarui profil: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profil</title>
    <link rel="stylesheet" href="keranjang.css">
    <style>
        .profil-wrapper {
            max-width: 800px;
            margin: 100px auto 60px;
            background-color: #f0f4fa;
            border: 2px solid rgb(177, 196, 212);
            border-radius: 15px;
            padding: 40px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .profil-wrapper h2 {
            text-align: center;
            color: rgb(51, 120, 180);
            margin-bottom: 30px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 15px;
            color: #2d4b7a;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .submit-btn {
            margin-top: 30px;
            text-align: center;
        }

        .submit-btn input[type="submit"] {
            background-color: rgb(155, 155, 224);
            color: black;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-btn input[type="submit"]:hover {
            background-color: rgb(51, 120, 180);
            color: white;
        }
    </style>
</head>
<body>
    <div class="profil-wrapper">
        <h2>Edit Profil</h2>
        <form method="POST" action="">
            <label>Nama Lengkap:</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($user['nama'] ?? '') ?>" required>

            <label>Alamat:</label>
            <textarea name="alamat" rows="3" required><?= htmlspecialchars($user['alamat'] ?? '') ?></textarea>

            <div class="submit-btn">
                <input type="submit" value="Simpan Perubahan">
            </div>
        </form>
    </div>
<?php include '../footer/footer.php'; ?>