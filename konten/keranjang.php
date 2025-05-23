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
$query = "SELECT cart.*, products.name, products.price, products.image_url 
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
                        $subtotal = $row['price'] * $row['jumlah'];
                        $total_keranjang += $subtotal;
                    ?>
                    <tr>
                        <td><a href="hapus_cart.php?id=<?= $row['id'] ?>"><i class='bx bxs-checkbox-minus'></i></a></td>
                        <td><img src="../img/<?= htmlspecialchars($row['image_url']) ?>" alt=""></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td>Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
						<td>
    <div class="quantity-control" data-id="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>">
        <button class="btn-decrease">-</button>
        <input type="text" value="<?= $row['jumlah'] ?>" readonly style="width: 30px; text-align: center; border: none; background: transparent;" class="quantity-display">
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
                <input type="text" name="coupon_code" placeholder="Enter Your Coupon">
                <button type="submit" class="normal">Apply</button>
            </div>
        </form>
    </div>

    <div id="subtotal">
        <h3>Cart Totals</h3>
        <table>
            <tr>
                <td>Cart Total</td>
                <td><span id="cart-total">Rp <?= number_format($total_keranjang, 0, ',', '.') ?></span></td>
            </tr>
            <tr>
                <td>Shipping</td>
                <td>Rp 30.000</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong><span id="grand-total">Rp <?= number_format($total_keranjang + 30000, 0, ',', '.') ?></span></strong></td>
            </tr>
        </table>
        <a href="pembayaran.php"><button class="normal">Checkout</button></a>
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