<?php
session_start();
require_once __DIR__ . '/../../bootstrap/app.php';

header('Content-Type: application/json');

$id = $_POST['id'] ?? null;

$product = $productController->getProductById($id);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['qty']++;
} else {
    $_SESSION['cart'][$id] = [
        'id'    => $product['id'],
        'nama'  => $product['nama_produk'],
        'harga' => $product['harga'],
        'qty'   => 1
    ];
}

echo json_encode($_SESSION['cart']);
