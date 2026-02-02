<?php
$page = $_GET['page'] ?? 'dashboard';
?>

<aside>
    <h2>Kasir Online Arcana</h2>

    <nav class="menu">
        <a href="?page=indexA" class="<?= $page === 'indexA' ? 'active' : '' ?>">Dashboard</a>
        <a href="?page=produk" class="<?= $page === 'produk' ? 'active' : '' ?>">Produk</a>
        <a href="?page=riwayat" class="<?= $page === 'riwayat' ? 'active' : '' ?>">Riwayat</a>
        <a href="?page=masukan" class="<?= $page === 'masukan' ? 'active' : '' ?>">Masukan</a>
    </nav>

    <a href="?page=logout" class="logout">Logout</a>
</aside>