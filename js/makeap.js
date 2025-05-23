function toggleFavorite(icon) {
    if (!icon) return;
      icon.classList.toggle("active");
      if (icon.classList.contains("active")) {
        alert("Ditambahkan ke favorit!");
      } else {
        alert("Dihapus dari favorit!");
      }
    }
    function toggleFavorite(element) {
        const productId = element.getAttribute('data-product-id');
    
        fetch('add_to_wishlist.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'product_id=' + productId
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Ganti ini dengan SweetAlert jika ingin lebih menarik
            element.classList.toggle('favorited'); // untuk ubah warna ikon, jika pakai CSS
        })
        .catch(error => {
            alert("Terjadi kesalahan.");
            console.error(error);
        });
    }  
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', async function (e) {
            e.preventDefault();


            const name = this.dataset.name;
            const price = this.dataset.price;
            const image = this.dataset.image;

            // Animasi ke keranjang
            const img = this.closest('.product-card').querySelector('img');
            const clone = img.cloneNode(true);
            const cartIcon = document.getElementById('cart-icon');
            const imgRect = img.getBoundingClientRect();
            const cartRect = cartIcon.getBoundingClientRect();

            clone.style.position = 'fixed';
            clone.style.left = imgRect.left + 'px';
            clone.style.top = imgRect.top + 'px';
            clone.style.width = imgRect.width + 'px';
            clone.style.height = imgRect.height + 'px';
            clone.style.transition = 'all 0.8s ease-in-out';
            clone.style.zIndex = 9999;
            document.body.appendChild(clone);

            setTimeout(() => {
                clone.style.left = cartRect.left + 'px';
                clone.style.top = cartRect.top + 'px';
                clone.style.width = '0px';
                clone.style.height = '0px';
                clone.style.opacity = '0.5';
            }, 10);

            setTimeout(() => {
                clone.remove();
            }, 900);

            // Kirim data ke keranjang.php
            try {
                const response = await fetch('keranjang.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `name=${encodeURIComponent(name)}&price=${encodeURIComponent(price)}&image=${encodeURIComponent(image)}`
                });

                const result = await response.text();
                alert("Produk berhasil ditambahkan ke keranjang!");
            } catch (error) {
                alert("Gagal menambahkan ke keranjang.");
                console.error(error);
            }
        });
    });
});
