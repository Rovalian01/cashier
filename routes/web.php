<?php
$page = $_GET['page'] ?? 'indexA';

$allowed = [
    'indexA' => '../views/layout/dashboard.php',
    'produk' => '../views/layout/produk.php',
    'riwayat' => '../views/layout/riwayat.php',
    'masukan' => '../views/layout/masukan.php',

    'add_to_invoice' => '../views/layout/add_to_invoice.php',

    // Auth
    'login' => '../views/auth/login.php',
    'logout' => '../views/auth/logout.php'
];

if (array_key_exists($page, $allowed)) {
    include $allowed[$page];
} else {
    include '../views/templates/404page.php';
}