<?php
require_once __DIR__ . '/../../bootstrap/app.php';
$products = $productController->showProduct();
$productController->sendProduct();
$productController->updateProduct($id);
$productController->deleteProduct($id);
?>

<main>
    <h1>Daftar Produk</h1>

    <button onclick="openModal()">Tambah Barang</button>
    
    <!-- Modal -->
    <div class="modal" id="modal">
        <div class="modal-content">
            <span onclick="closeModal()" class="close">&times;</span>

            <h3>Tambah Produk</h3>
            <form method="post">
                <input type="text" name="nama_produk" placeholder="Nama Produk" required>
                <input type="number" name="harga" placeholder="Harga" required>
                <input type="number" name="stok" placeholder="Stok" required>
                <button type="submit">Tambah Produk</button>
            </form>
        </div>
    </div>

    <!-- End Modal -->
    <div class="table-container">
        <table>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>

            <?php foreach ($products as $index => $row): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $row['nama_produk'] ?></td>
                <td><?= $row['harga'] ?></td>
                <td><?= $row['stok'] ?></td>
                <td>
                    <button onclick="openModal()">Edit</button>

                    <!-- Modal -->
                    <div class="modal" id="modal">
                        <div class="modal-content">
                            <span onclick="closeModal()" class="close">&times;</span>

                            <h3>Edit Produk</h3>
                            <form method="post">
                                <input type="text" name="nama_produk" placeholder="Nama Produk"
                                value="<?= $row['nama_produk'] ?>" required>
                                <input type="number" name="harga" placeholder="Harga" value="<?= $row['harga'] ?>" required>
                                <input type="number" name="stok" placeholder="Stok" value="<?= $row['stok'] ?>" required>
                                <button type="submit">Edit Produk</button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</main>

<script>
function openModal() {
    document.getElementById('modal').style.display = 'block';
}
function closeModal() {
    document.getElementById('modal').style.display = 'none';
}
</script>