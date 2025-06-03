<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
$tanggal = date('Y-m-d');

// Ambil alamat pengguna
$alamat_query = $conn->prepare("SELECT * FROM alamat WHERE email = ?");
$alamat_query->bind_param("s", $email);
$alamat_query->execute();
$alamat_result = $alamat_query->get_result();
$data_alamat = $alamat_result->fetch_assoc();

// Ambil isi keranjang
$query = "SELECT cart.*, products.name, products.price, products.diskon_persen, products.image_url 
          FROM cart 
          JOIN products ON cart.produk_id = products.id 
          WHERE cart.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$keranjang = $stmt->get_result();

$total_keranjang = 0;
$item_count = 0;
$items = [];

while ($item = $keranjang->fetch_assoc()) {
  $diskon_persen = $item['diskon_persen'] ?? 0;
  $harga_asli = $item['price'];
  $harga_diskon = $diskon_persen > 0 ? $harga_asli * (1 - $diskon_persen / 100) : $harga_asli;
  $subtotal = $harga_diskon * $item['jumlah'];
  $total_keranjang += $subtotal;
  $item_count += $item['jumlah'];
  $items[] = array_merge($item, ['harga_diskon' => $harga_diskon, 'subtotal' => $subtotal]);
}

$daftar_kupon = $_SESSION['coupons'] ?? [];
$total_diskon_kupon = 0;
foreach ($daftar_kupon as $index => $kupon) {
  if ($total_keranjang >= ($kupon['minimal_belanja'] ?? 0)) {
    $potongan = ($kupon['tipe_diskon'] ?? '') === 'persen'
      ? $total_keranjang * ($kupon['nilai_diskon'] ?? 0) / 100
      : ($kupon['nilai_diskon'] ?? 0);
    $daftar_kupon[$index]['potongan'] = $potongan;
    $total_diskon_kupon += $potongan;
  } else {
    $daftar_kupon[$index]['potongan'] = 0;
  }
}

$total_setelah_diskon = max(0, $total_keranjang - $total_diskon_kupon);

include '../header/header_pembayaran.php';
?>

<link rel="stylesheet" href="../css/pembayaran.css">
<div class="container">
  <form method="POST" action="proses_pembayaran.php" class="delivery-form">
    <h2>Alamat Pengiriman</h2>
    <div class="alamat-card">
      <strong><?= htmlspecialchars($data_alamat['nama']) ?> (+62<?= substr($data_alamat['telepon'], -10) ?>)</strong>
      <p><?= htmlspecialchars($data_alamat['alamat']) ?>, <?= htmlspecialchars($data_alamat['kota']) ?>,
        <?= htmlspecialchars($data_alamat['provinsi']) ?>, <?= htmlspecialchars($data_alamat['kode_pos']) ?>
      </p>
      <a href="edit_alamat.php">Ubah</a>
    </div>

    <input type="hidden" name="first_name" value="<?= explode(' ', $data_alamat['nama'])[0] ?>">
    <input type="hidden" name="last_name" value="<?= explode(' ', $data_alamat['nama'])[1] ?? '' ?>">
    <input type="hidden" name="address" value="<?= $data_alamat['alamat'] ?>">
    <input type="hidden" name="sub_district" value="-">
    <input type="hidden" name="city" value="<?= $data_alamat['kota'] ?>">
    <input type="hidden" name="province" value="<?= $data_alamat['provinsi'] ?>">
    <input type="hidden" name="postal_code" value="<?= $data_alamat['kode_pos'] ?>">
    <input type="hidden" name="phone" value="<?= $data_alamat['telepon'] ?>">

    <div class="delivery-note">
      <h3>Delivery Service</h3>
      <div>
        <input type="radio" name="delivery" value="express" required>
        <span class="option-title">Express</span>
        <span class="option-detail">Estimated arrival 1 - 2 days</span>
      </div>
      <div>
        <input class="option" type="radio" name="delivery" value="regular" required>
        <span class="option-title">Regular</span>
        <span class="option-detail">Estimated arrival in 2 - 5 days</span>
      </div>
      <div>
        <input class="option" type="radio" name="delivery" value="nextday" required>
        <span class="option-title"> Nextday Service</span>
        <span class="option-detail">Estimated arrival 1 - 2 days</span>
      </div>
    </div>

    <!-- Metode Pembayaran -->
    <div class="payment-method">
      <h2>Metode Pembayaran</h2>
      <p>Semua pembayaran aman dan terenkripsi.</p>
      <form method="POST" action="profile.php">
        <div style="  margin-bottom: 5px; display: flex; align-items: center;">
          <input style="margin-right; 10px;" type="radio" id="virtual-account" name="payment-method"
            value="Virtual Account" required onclick="toggleSubMethod('virtual-account-sub-method')" required>
          <label style="  font-size: 16px; flex-grow: 1; margin-top: 5px; padding: 5px;" for="virtual-account">Virtual
            Account</label>
        </div>

        <div style="  display: none; margin-top: 10px; padding-left: 1rem; border-left: 2px solid #ddd;"
          id="virtual-account-sub-method">
          <div style="  margin-bottom: 5px; display: flex; align-items: center;">
            <input style="margin-right; 10px;" type="radio" id="bank-bri" name="sub-payment-method" required>
            <label style="  font-size: 16px; flex-grow: 1; margin-top: 5px; padding: 5px;" for="bank-bri">Bank
              BRI</label>
          </div>
          <div style="  margin-bottom: 5px; display: flex; align-items: center;">
            <input style="margin-right; 10px;" type="radio" id="bank-mandiri" name="sub-payment-method" required>
            <label style="  font-size: 16px; flex-grow: 1; margin-top: 5px; padding: 5px;" for="bank-mandiri">Bank
              Mandiri</label>
          </div>
          <div style="  margin-bottom: 5px; display: flex; align-items: center;">
            <input style="margin-right; 10px;" type="radio" id="bank-bca" name="sub-payment-method" required>
            <label style="  font-size: 16px; flex-grow: 1; margin-top: 5px; padding: 5px;" for="bank-bca">Bank
              BCA</label>
          </div>
          <div style="  margin-bottom: 5px; display: flex; align-items: center;">
            <input style="margin-right; 10px;" type="radio" id="bank-bni" name="sub-payment-method" required>
            <label style="  font-size: 16px; flex-grow: 1; margin-top: 5px; padding: 5px;" for="bank-bni">Bank
              BNI</label>
          </div>
        </div>

        <div style="  margin-bottom: 5px; display: flex; align-items: center;">
          <input style="margin-right; 10px;" type="radio" id="e-payment" name="payment-method" value="e-Payment"
            onclick="toggleSubMethod('e-payment-sub-method')" required>
          <label style=" font-size: 16px; flex-grow: 1; margin-top: 5px; padding: 5px;"
            for="e-payment">e-Payment</label>
        </div>

        <div style="  display: none; margin-top: 10px; padding-left: 1rem; border-left: 2px solid #ddd;"
          id="e-payment-sub-method">
          <div style="  margin-bottom: 5px; display: flex; align-items: center;">
            <input style="margin-right; 10px;" type="radio" id="gopay" name="sub-payment-method" required>
            <label style="  font-size: 16px; flex-grow: 1; margin-top: 5px; padding: 5px;" for="gopay">GoPay</label>
          </div>
          <div style="  margin-bottom: 5px; display: flex; align-items: center;">
            <input style="margin-right; 10px;" type="radio" id="ovo" name="sub-payment-method" required>
            <label style="  font-size: 16px; flex-grow: 1; margin-top: 5px; padding: 5px;" for="ovo">OVO</label>
          </div>
          <div style="  margin-bottom: 5px; display: flex; align-items: center;">
            <input style="margin-right; 10px;" type="radio" id="shopeepay" name="sub-payment-method" required>
            <label style="  font-size: 16px; flex-grow: 1; margin-top: 5px; padding: 5px;"
              for="shopeepay">ShopeePay</label>
          </div>
        </div>

        <div style="  margin-bottom: 5px; display: flex; align-items: center;">
          <input style="margin-right; 10px;" type="radio" id="retail" name="payment-method"
            value="Tunai di Gerai Retail" onclick="toggleSubMethod('retail-sub-method')" required>
          <label style=" font-size: 16px; flex-grow: 1; margin-top: 5px; padding: 5px;" for="retail">Tunai di Gerai
            Retail</label>
        </div>

        <div style="  display: none; margin-top: 10px; padding-left: 1rem; border-left: 2px solid #ddd;"
          id="retail-sub-method">
          <div style="  margin-bottom: 5px; display: flex; align-items: center;">
            <input style="margin-right; 10px;" type="radio" id="indomaret" name="sub-payment-method" required>
            <label style="  font-size: 16px; flex-grow: 1; margin-top: 5px; padding: 5px;"
              for="indomaret">Indomaret</label>
          </div>
        </div>

        <div style="  margin-bottom: 5px; display: flex; align-items: center;">
          <input style="margin-right; 10px;" type="radio" id="qris" name="payment-method" value="QRIS"
            onclick="toggleSubMethod('qris-sub-method')" required>
          <label style="  font-size: 16px; flex-grow: 1; margin-top: 5px; padding: 5px;" for="qris">QRIS</label>
        </div>

        <div style="  display: none; margin-top: 10px; padding-left: 1rem; border-left: 2px solid #ddd;"
          id="qris-sub-method">
          <div style="  margin-bottom: 5px; display: flex; align-items: center;">
            <input style="margin-right; 10px;" type="radio" id="qris-option" name="sub-payment-method">
            <label style="  font-size: 16px; flex-grow: 1; margin-top: 5px; padding: 5px;"
              for="qris-option">QRIS</label>
          </div>
        </div>

        <p class="error" id="error-message">Silakan pilih metode dan opsi pembayaran terlebih dahulu.</p>
        <button type="submit" name="bayar"
          style=" width: 100%; background: #948eaf; color: #fff; border: none; padding: 10px; border-radius: 5px; font-size: 16px; cursor: pointer; margin-top: 10px;">Pay
          Now</button>
      </form>
    </div>
    <div class="order-summary">
      <h2>Ringkasan Pesanan</h2>
      <ul class="items">
        <?php foreach ($items as $item): ?>
          <li>
            <img src="../img/<?= htmlspecialchars($item['image_url']) ?>" alt="" class="product-img">
            <span><?= htmlspecialchars($item['name']) ?><br>x<?= $item['jumlah'] ?></span>
            <span>
              <?php if ($item['diskon_persen'] > 0): ?>
                <del style="color: #888;">Rp <?= number_format($item['price'], 0, ',', '.') ?></del><br>
                <strong>Rp <?= number_format($item['harga_diskon'], 0, ',', '.') ?></strong>
              <?php else: ?>
                Rp <?= number_format($item['price'], 0, ',', '.') ?>
              <?php endif; ?>
            </span>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="discount" style="margin-bottom: 16px;">
        <form action="apply_coupon_pembayaran.php" method="post"
          style="display: flex; gap: 10px; align-items: center; width: 100%;">
          <input type="text" name="coupon_code" placeholder="Discount code or gift card" required
            style="flex-grow: 3; padding: 10px; border: 1px solid #ccc; border-radius: 4px; ">
          <button type="submit" style="  flex: 1; background-color: #948eaf; color: #fff; border: none; height: 40px; border-radius: 5px; cursor: pointer;">Apply</button>
        </form>

      </div>
                          <?php if (isset($_SESSION['notif'])): ?>
                <div style="color: red; margin-top: 8px; font-size: 0.9em;">
                    <?= htmlspecialchars($_SESSION['notif']) ?>
                </div>
                <?php unset($_SESSION['notif']); ?>
            <?php endif; ?>

      <div class="totals" style="margin-top: 10px;">
        <p>Subtotal · <?= $item_count ?> items
          <span style="float: right;">Rp <?= number_format($total_keranjang, 0, ',', '.') ?></span>
        </p>
        <p>Shipping
          <span style="float: right;">Free</span>
        </p>
    <?php if (!empty($daftar_kupon)): ?>
  <div style="margin-top: 10px;">
    <p>Voucher</p>
    <?php foreach ($daftar_kupon as $kupon): ?>
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
        <div style="display: flex; align-items: center; gap: 6px;">
          <span style="font-size: 0.9em; color: #333;"><?= htmlspecialchars($kupon['kode']) ?></span>
          <form method="post" action="hapus_kupon_pembayaran.php" style="margin: 0;">
            <input type="hidden" name="kode_hapus" value="<?= $kupon['kode'] ?>">
            <button type="submit" style="border:none; background:none; color:red; font-weight:bold; font-size: 1em; cursor:pointer;">×</button>
          </form>
        </div>
        <div style="text-align: right;">
          <span style="color: #000;">- Rp <?= number_format($kupon['potongan'], 0, ',', '.') ?></span>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

        <h3 style="margin-top: 10px;">
          Total
          <span style="float: right;">
            <?php if ($total_diskon_kupon > 0): ?>
              <del style="font-size: 0.9em; color: #777; margin-right: 5px;">Rp
                <?= number_format($total_keranjang + $total_diskon_kupon, 0, ',', '.') ?></del>
              <strong>Rp <?= number_format($total_setelah_diskon, 0, ',', '.') ?></strong>
            <?php else: ?>
              <strong>Rp <?= number_format($total_keranjang, 0, ',', '.') ?></strong>
            <?php endif; ?>
          </span>
        </h3>
      </div>
    </div>

</div>


<script src="../js/pembayaran.js"></script>
<?php include '../footer/footer.php'; ?>