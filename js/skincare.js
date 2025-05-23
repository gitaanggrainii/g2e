function toggleFavorite(icon) {
    icon.classList.toggle("active");
    if (icon.classList.contains("active")) {
      alert("Ditambahkan ke Favorit!");
    } else {
      alert("Dihapus dari Favorit!");
    }
  }
  