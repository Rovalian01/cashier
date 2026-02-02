<?php
require_once __DIR__ . '/../../bootstrap/app.php';
$products = $productController->showProduct();
?>

<main>
    <h1>Daftar Produk</h1>

    <a href="?page=create-product">Tambah Produk</a>

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
                    <?= ($row['id_kategori'] == 1 ) ? 'Makanan' : 'Minuman' ?>
                </td>
                <td>
                    <a href="?page=update-product&id=<?= $row['id'] ?>">Edit</a>
                    <a href="?page=delete-product&id=<?= $row['id'] ?>">Hapus</a>
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