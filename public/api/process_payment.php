<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../bootstrap/app.php';

try {
    $id = isset($_POST['invoice_id']) ? intval($_POST['invoice_id']) : 0;
    $jumlah_pembayaran = isset($_POST['jumlah_pembayaran']) ? intval($_POST['jumlah_pembayaran']) : 0;

    if (!$id || !$jumlah_pembayaran) {
        echo json_encode(['success' => false, 'message' => 'Invoice ID atau jumlah pembayaran tidak valid']);
        exit;
    }

    // Get invoice total
    $invoice = $invoiceController->getInvoiceById($id);
    if (!$invoice) {
        echo json_encode(['success' => false, 'message' => 'Invoice tidak ditemukan']);
        exit;
    }

    $total = intval($invoice['total']);
    
    if ($jumlah_pembayaran < $total) {
        echo json_encode(['success' => false, 'message' => 'Pembayaran kurang', 'kurang' => $total - $jumlah_pembayaran]);
        exit;
    }

    // Calculate kembalian (change)
    $kembalian = $jumlah_pembayaran - $total;

    // Do not persist payment amount or kembalian to database — only return for display
    // Clear session cart after successful payment
    unset($_SESSION['cart']);

    echo json_encode([
        'success' => true,
        'message' => 'Pembayaran berhasil',
        'invoice_id' => $id,
        'total' => $total,
        'jumlah_pembayaran' => $jumlah_pembayaran,
        'kembalian' => $kembalian
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
