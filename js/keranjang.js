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


