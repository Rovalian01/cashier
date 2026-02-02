<?php
session_start();
require_once __DIR__ . '/../../bootstrap/app.php';

try {
    $invoice_id = $invoiceController->checkout();
    // Return JSON with invoice_id for payment form to use
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'invoice_id' => $invoice_id,
        'message' => 'Invoice berhasil dibuat. Silakan lakukan pembayaran.'
    ]);
} catch (Exception $e) {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Transaksi gagal: ' . $e->getMessage()
    ]);
}