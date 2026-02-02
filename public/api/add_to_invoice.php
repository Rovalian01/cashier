<?php
session_start();
require_once __DIR__ . '/../../bootstrap/app.php';

header('Content-Type: application/json');

$id = $_POST['id'] ?? null;

if (!$id) {
    echo json_encode(['error' => 'ID tidak valid']);
    exit;
}

$product = $productController->getProductById($id);

if (!$product) {
    echo json_encode(['error' => 'Produk tidak ditemukan']);
    exit;
}

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
