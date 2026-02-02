<?php
$page = $_GET['page'] ?? 'indexA';

$allowed = [
    'indexA' => '../views/layout/dashboard.php',

    //  Product
    'produk' => '../views/layout/produk.php',
    'create-product' => '../views/layout/create-product.php',
    'update-product' => '../views/layout/update-product.php',
    'delete-product' => '../views/layout/delete-product.php',

    'riwayat' => '../views/layout/riwayat.php',
    'masukan' => '../views/layout/masukan.php',

    // Auth
    'login' => '../views/auth/login.php',
    'logout' => '../views/auth/logout.php'
];

if (array_key_exists($page, $allowed)) {
    include $allowed[$page];
} else {
    include '../views/templates/404page.php';
}