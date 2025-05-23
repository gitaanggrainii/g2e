function toggleFavorite(icon) {
    // Toggle class "active" untuk menandai produk sebagai favorit
    icon.classList.toggle("active");
    if (icon.classList.contains("active")) {
      alert("Ditambahkan ke Favorit!");
    } else {
      alert("Dihapus dari Favorit!");
    }
  }
  