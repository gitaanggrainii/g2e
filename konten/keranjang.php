<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
// Jika ada data yang dikirim dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item = [
        'name' => $_POST['name'],
        'price' => $_POST['price'],
        'image' => $_POST['image'],
        'quantity' => 1  // Set default quantity to 1
    ];

    // Cek apakah produk sudah ada di keranjang
    $found = false;
    foreach ($_SESSION['cart'] as &$cart_item) {
        if ($cart_item['name'] === $item['name']) {
            // Jika produk sudah ada, tambahkan quantity
            $cart_item['quantity'] += 1;
            $found = true;
            break;
        }
    }

    // Jika produk belum ada, tambahkan produk baru
    if (!$found) {
        $_SESSION['cart'][] = $item;
    }
}
include '../header//header_keranjang.php';

$user_id = $_SESSION['user_id'];

// Ambil data dari keranjang user
$query = "SELECT cart.*, products.name, products.price, products.diskon_persen, products.image_url 
          FROM cart 
          JOIN products ON cart.produk_id = products.id 
          WHERE cart.user_id = $user_id";

$result = mysqli_query($conn, $query);

$total_keranjang = 0;

?>

<body>

    <section id="cart" class="section-p1">
        <form method="post" action="update_cart.php">
            <table width="90%">
                <thead>
                    <tr>
                        <td>Remove</td>
                        <td>Item</td>
                        <td>Product</td>
                        <td>Price</td>
                        <td>Quantity</td>
                        <td>Subtotal</td>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <?php
                        $diskon = $row['diskon_persen'];
                        $harga_diskon = $row['price'] * (1 - ($diskon / 100));
                        $subtotal = $harga_diskon * $row['jumlah'];
                        $total_keranjang += $subtotal;
                        ?>
                        <tr>
                            <td><a href="hapus_cart.php?id=<?= $row['id'] ?>"><i class='bx bxs-checkbox-minus'></i></a></td>
                            <td><img src="../img/<?= htmlspecialchars($row['image_url']) ?>" alt=""></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td>
                                <?php if ($diskon > 0): ?>
                                    <del style="font-size: 0.85em; color: #888;">Rp
                                        <?= number_format($row['price'], 0, ',', '.') ?></del><br>
                                    <strong style="font-size: 1em;">Rp <?= number_format($harga_diskon, 0, ',', '.') ?></strong>
                                <?php else: ?>
                                    Rp <?= number_format($row['price'], 0, ',', '.') ?>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="quantity-control" data-id="<?= $row['id'] ?>"
                                    data-price="<?= round($harga_diskon) ?>">
                                    <button class="btn-decrease">-</button>
                                    <input type="text" value="<?= $row['jumlah'] ?>" readonly
                                        style="width: 30px; text-align: center; border: none; background: transparent;"
                                        class="quantity-display">
                                    <button class="btn-increase">+</button>
                                </div>
                            </td>
                            <td id="subtotal-<?= $row['id'] ?>">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>

            </table>

        </form>
    </section>

    <section id="cart-add" class="section-p2">
        <div id="coupon">
            <h3>Apply Coupon</h3>
            <form method="post" action="apply_coupon.php">
                <div>
                    <input type="text" name="coupon_code" placeholder="Enter Your Coupon" required>
                    <button type="submit" class="normal">Apply</button>
                </div>
            </form>
            <?php if (isset($_SESSION['notif'])): ?>
                <div style="color: red; margin-top: 8px; font-size: 0.9em;">
                    <?= htmlspecialchars($_SESSION['notif']) ?>
                </div>
                <?php unset($_SESSION['notif']); ?>
            <?php endif; ?>
        </div>

        <div id="subtotal" class="mt-4">
            <?php
            $total_asli = $total_keranjang;
            $total_diskon = 0;
            $daftar_kupon = [];

            if (!empty($_SESSION['coupons'])) {
                foreach ($_SESSION['coupons'] as $coupon) {
                    if ($total_keranjang >= $coupon['minimal_belanja']) {
                        $potongan = $coupon['tipe_diskon'] === 'persen'
                            ? $total_keranjang * ($coupon['nilai_diskon'] / 100)
                            : $coupon['nilai_diskon'];
                        $daftar_kupon[] = [
                            'kode' => $coupon['kode'],
                            'potongan' => $potongan
                        ];
                        $total_diskon += $potongan;
                    }
                }
            }

            $total_setelah_diskon = max(0, $total_asli - $total_diskon);
            ?>

            <h3>Total</h3>
            <table style="width:100%; border-collapse: collapse; border: 1px solid #999;">
                <?php if (!empty($daftar_kupon)): ?>
                    <tr>
                        <td style="padding: 8px; width:50%; border-right: 1px solid #999;">
                            <strong>Voucher:</strong>
                            <?php foreach ($daftar_kupon as $kupon): ?>
                                <span style="margin-left: 8px; display: inline-block; font-size: 0.95em;">
                                    <strong><?= htmlspecialchars($kupon['kode']) ?></strong>
                                    <form method="post" action="hapus_kupon.php" style="display:inline;">
                                        <input type="hidden" name="kode_hapus" value="<?= $kupon['kode'] ?>">
                                        <button type="submit"
                                            style="border:none; background:none; color:red; font-weight:bold; font-size:14px; cursor:pointer;"
                                            title="Hapus kupon">×</button>
                                    </form>
                                </span>
                            <?php endforeach; ?>
                        </td>
                        <td style="padding: 8px;">
                            - Rp <?= number_format($total_diskon, 0, ',', '.') ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td style="padding: 8px;"><strong>Total</strong></td>
                    <td style="padding: 8px; text-align: left; padding-left: 16px;">
                        <?php if ($total_diskon > 0): ?>
                            <del style="font-size: 0.9em; color: #777;">Rp
                                <?= number_format($total_asli, 0, ',', '.') ?></del><br>
                            <strong style="font-size: 1.1em;">Rp
                                <?= number_format($total_setelah_diskon, 0, ',', '.') ?></strong>
                        <?php else: ?>
                            <strong>Rp <?= number_format($total_asli, 0, ',', '.') ?></strong>
                        <?php endif; ?>
                    </td>
                </tr>

            </table>
            <a href="pembayaran.php"><button class="normal mt-2">Checkout</button></a>
        </div>


    </section>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let totalKeranjang = 0; // Variabel untuk total harga keranjang

            // Ambil semua elemen input jumlah
            const inputs = document.querySelectorAll('.quantity-input');
            inputs.forEach(input => {
                input.addEventListener('input', function () {
                    const price = parseInt(this.getAttribute('data-price'));  // Ambil harga per item
                    const quantity = parseInt(this.value) || 0;  // Ambil jumlah produk
                    const subtotal = price * quantity;  // Hitung subtotal untuk produk ini
                    const subtotalElementId = this.getAttribute('data-subtotal-id');  // ID subtotal
                    const subtotalElement = document.getElementById(subtotalElementId);

                    // Update subtotal untuk item ini
                    if (subtotalElement) {
                        subtotalElement.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                    }

                    // Reset total keranjang dan hitung ulang
                    totalKeranjang = 0;
                    const allSubtotals = document.querySelectorAll('[id^="subtotal-"]'); // Ambil semua subtotal
                    allSubtotals.forEach(subtotal => {
                        totalKeranjang += parseInt(subtotal.textContent.replace('Rp ', '').replace('.', '').trim()); // Tambahkan subtotal
                    });

                    // Update cart total
                    const cartTotalElement = document.querySelector('#cart-total');
                    if (cartTotalElement) {
                        cartTotalElement.textContent = 'Rp ' + totalKeranjang.toLocaleString('id-ID');
                    }

                    // Update grand total (total keranjang + biaya pengiriman)
                    const shippingCost = 30000;
                    const grandTotalElement = document.querySelector('#grand-total');
                    if (grandTotalElement) {
                        grandTotalElement.textContent = 'Rp ' + (totalKeranjang + shippingCost).toLocaleString('id-ID');
                    }
                });
            });

            // Hitung ulang total keranjang saat halaman dimuat pertama kali
            const allSubtotals = document.querySelectorAll('[id^="subtotal-"]');
            allSubtotals.forEach(subtotal => {
                totalKeranjang += parseInt(subtotal.textContent.replace('Rp ', '').replace('.', '').trim());
            });

            // Update total keranjang dan grand total pertama kali
            const cartTotalElement = document.querySelector('#cart-total');
            const grandTotalElement = document.querySelector('#grand-total');
            const shippingCost = 30000;
            if (cartTotalElement) {
                cartTotalElement.textContent = 'Rp ' + totalKeranjang.toLocaleString('id-ID');
            }
            if (grandTotalElement) {
                grandTotalElement.textContent = 'Rp ' + (totalKeranjang + shippingCost).toLocaleString('id-ID');
            }
        });
        document.querySelectorAll('.quantity-control').forEach(control => {
            const cartId = control.getAttribute('data-id');
            const price = parseInt(control.getAttribute('data-price'));
            const input = control.querySelector('.quantity-display');
            const subtotalEl = document.getElementById(`subtotal-${cartId}`);

            control.querySelector('.btn-increase').addEventListener('click', () => updateQuantity('increase'));
            control.querySelector('.btn-decrease').addEventListener('click', () => updateQuantity('decrease'));

            function updateQuantity(action) {
                fetch('update_cart_ajax.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `cart_id=${cartId}&action=${action}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            input.value = data.new_quantity;
                            subtotalEl.textContent = 'Rp ' + (data.new_quantity * price).toLocaleString('id-ID');
                            updateTotals();
                        }
                    });
            }

            function updateTotals() {
                let total = 0;
                document.querySelectorAll('[id^="subtotal-"]').forEach(el => {
                    const val = parseInt(el.textContent.replace(/[^\d]/g, '')) || 0;
                    total += val;
                });
                const shipping = 30000;
                document.getElementById('cart-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
                document.getElementById('grand-total').textContent = 'Rp ' + (total + shipping).toLocaleString('id-ID');
            }
        });



    </script>

    <?php include '../footer/footer.php'; ?>