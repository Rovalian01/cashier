<?php
require_once __DIR__ . '/../app/controllers/ProdukController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/InvoiceController.php';

$productController = new ProductController($connection);
$authController = new AuthController($connection);
$invoiceController = new InvoiceController($connection);