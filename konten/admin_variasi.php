<?php
include 'koneksi.php';

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : null;
?>

<h2 style="text-align: center;">Tambah Variasi Produk</h2>
<form action="simpan_variasi.php" method="POST" enctype="multipart/form-data" style="max-width: 500px; margin: auto; padding: 20px; border: 1px solid #ccc; background: #f9f9f9; border-radius: 10px;">

    <?php if ($product_id): ?>
        <!-- Mode: langsung dari simpan_produk -->
        <input type="hidden" name="product_id" value="<?= $product_id ?>">
        <?php
        $res = mysqli_query($conn, "SELECT name FROM products WHERE id = $product_id");
        $data = mysqli_fetch_assoc($res);
        ?>
        <p><strong>Produk:</strong> <?= htmlspecialchars($data['name']) ?></p>
    <?php else: ?>
        <!-- Mode: dari menu -->
        <label for="product_id">Pilih Produk:</label>
        <select name="product_id" required style="width:100%; padding:8px; margin-bottom:15px;">
            <option value="">-- Pilih Produk --</option>
            <?php
            $result = mysqli_query($conn, "SELECT id, name FROM products");
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</option>';
            }
            ?>
        </select>
    <?php endif; ?>

    <label for="gambar_variasi">Upload Gambar Variasi:</label>
   <input type="file" name="gambar_variasi[]" accept="image/*" multiple required style="margin-bottom: 20px; display:block;">


    <button type="submit" style="padding:10px 20px; background:#000; color:#fff; border:none; border-radius:5px;">Simpan Variasi</button>
</form>
<?php if ($product_id): ?>
    <div style="text-align: center; margin-top: 20px;">
        <a href="dashboard.php" 
           style="padding: 10px 20px; background-color: #eee; border: 1px solid #ccc; border-radius: 5px; text-decoration: none; color: black;">
           + Tambah Produk Lain
        </a>
    </div>
<?php endif; ?>

