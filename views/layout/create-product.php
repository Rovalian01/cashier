<?php
require_once __DIR__ . '/../../bootstrap/app.php';
$productController->createProduct();
?>

<main>
    <form method="post">
        <label for="nama-produk">Nama Prodok</label>
        <input type="text" name="nama-produk">
        
        <label for="harga">Harga</label>
        <input type="number" name="harga">

        <label for="stok">Stok</label>
        <input type="number" name="stok">

        <label for="kategori">Kategori</label>
        <select name="kategori">
            <option value="1">Makanan</option>
            <option value="2">Minuman</option>
        </select>

        <button type="submit" name="create-product">Submit</button>
    </form>
</main>