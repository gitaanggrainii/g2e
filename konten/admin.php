
    <form action="simpan_produk.php" method="POST" enctype="multipart/form-data" 
      style="max-width: 500px; margin: 30px auto; padding: 30px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9; font-family: Arial, sans-serif;">
    
    <h2 style="text-align: center; color: black;">Tambah Produk Baru</h2><br>

    <label for="name" style="display: block; margin-bottom: 5px;">Nama Produk:</label>
    <input type="text" name="name" required 
           style="width: 100%; padding: 8px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #ccc;">

    <label for="description" style="display: block; margin-bottom: 5px;">Deskripsi:</label>
    <textarea name="description" required 
              style="width: 100%; padding: 8px; height: 100px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #ccc;"></textarea>

    <label for="price" style="display: block; margin-bottom: 5px;">Harga:</label>
    <input type="number" name="price" required 
           style="width: 100%; padding: 8px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #ccc;">

    <label for="kategori_id" style="display: block; margin-bottom: 5px;">Kategori:</label>
    <select name="kategori_id" required 
            style="width: 100%; padding: 8px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #ccc;">
        <option value="1">Makeup</option>
        <option value="2">Skincare</option>
        <option value="3">Haircare</option>
        <option value="4">Nails</option>
        <option value="5">Bath & Body</option>
    </select>

    <label for="image" style="display: block; margin-bottom: 5px;">Gambar Produk:</label>
    <input type="file" name="image" accept="image/*" required 
           style="margin-bottom: 20px;">

    <button type="submit" 
            style="padding: 10px 20px; background-color: black; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
        Tambah Produk
    </button>
</form>


</body>
</html>
