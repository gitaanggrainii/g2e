<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      min-height: 100vh;
    }
    .sidebar {
      width: 250px;
      background-color: #343a40;
      color: white;
      padding-top: 2rem;
      position: fixed;
      height: 100%;
    }
    .sidebar a {
      display: block;
      padding: 12px 20px;
      color: white;
      text-decoration: none;
    }
    .sidebar a:hover,
    .sidebar a.active {
      background-color: #495057;
    }
    .content {
      flex: 1;
      margin-left: 250px;
      padding: 2rem;
      background-color: #f8f9fa;
    }


  </style>
</head>
<body>

<div class="sidebar">
  <h4 class="text-center">Dashboard Admin</h4>
  <a href="?page=kelola" class="<?= !isset($_GET['page']) || $_GET['page'] === 'kelola' ? 'active' : '' ?>">Tambah Produk</a>
  <a href="?page=daftar" class="<?= isset($_GET['page']) && $_GET['page'] === 'daftar' ? 'active' : '' ?>">Daftar Produk</a>
  <a href="?page=promo" class="<?= isset($_GET['page']) && $_GET['page'] === 'promo' ? 'active' : '' ?>">Daftar Promo</a>
  <a href="?page=pengaturan_promo" class="<?= isset($_GET['page']) && $_GET['page'] === 'pengaturan_promo' ? 'active' : '' ?>">Pengaturan Promo</a>
  <a href="?page=logout">Logout</a>
</div>

<div class="content">
  <?php
    if (isset($_GET['page'])) {
        switch ($_GET['page']) {
            case 'daftar':
                include 'daftar-produk.php';
                break;
            case 'promo':
                include 'promo.php';
                break;
            case 'pengaturan_promo':
                include 'pengaturan_promo.php';
                break;
            case 'logout':
                session_destroy();
                header("Location: login.php");
                exit;
            default:
                include 'admin.php';
        }
    } else {
        include 'admin.php';
    }
  ?>
</div>

</body>
</html>
