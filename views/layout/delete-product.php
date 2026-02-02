<?php
require_once __DIR__ . '/../../bootstrap/app.php';

$id = $_GET['id'];
$productController->deleteProduct($id);