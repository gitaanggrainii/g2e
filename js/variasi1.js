// Fungsi untuk meningkatkan jumlah produk
function increaseQuantity() {
    const quantityInput = document.getElementById("quantity");
    quantityInput.value = parseInt(quantityInput.value) + 1;
  }
  
  // Fungsi untuk mengurangi jumlah produk
  function decreaseQuantity() {
    const quantityInput = document.getElementById("quantity");
    if (quantityInput.value > 1) {
      quantityInput.value = parseInt(quantityInput.value) - 1;
    }
  }
  