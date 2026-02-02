<?php
require_once __DIR__ . '/../../bootstrap/app.php';

$id = $_GET['id'];

$product = $productController->getProductById($id);
$productController->updateProduct($id);
?>

<main>
    <form method="post">
        <label for="nama-produk">Nama Prodok</label>
        <input type="text" name="nama-produk" value="<?= $product['nama_produk'] ?>">
        
        <label for="harga">Harga</label>
        <input type="number" name="harga" value="<?= $product['harga'] ?>">

        <label for="stok">Stok</label>
        <input type="number" name="stok" value="<?= $product['stok'] ?>">

        <label for="kategori">Kategori</label>
        <select name="kategori">
            <option value="1">Makanan</option>
            <option value="2">Minuman</option>
        </select>

        <button type="submit" name="update-product">Submit</button>
    </form>
</main>