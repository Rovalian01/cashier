<?php
session_start();
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;

if (!$id || !isset($_SESSION['cart'][$id])) {
    echo json_encode($_SESSION['cart'] ?? []);
    exit;
}

$_SESSION['cart'][$id]['qty']--;

if ($_SESSION['cart'][$id]['qty'] <= 0) {
    unset($_SESSION['cart'][$id]);
}

echo json_encode($_SESSION['cart']);