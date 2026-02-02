<?php
require_once __DIR__ . '/../../bootstrap/app.php';
require_once __DIR__ . '/../../app/models/Invoice.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) {
    echo 'Invoice ID tidak valid';
    exit;
}

$invoiceModel = new Invoice($connection);
$invoice = $invoiceModel->getInvoiceById($id);
$details = $invoiceModel->getInvoiceDetails($id);

// Paid and kembalian may be passed via GET for display only (not stored)
$paid = isset($_GET['paid']) ? intval($_GET['paid']) : null;
$kembalian_get = isset($_GET['kembalian']) ? intval($_GET['kembalian']) : null;

if (!$invoice) {
    echo 'Invoice tidak ditemukan';
    exit;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk - Invoice #<?= htmlspecialchars($invoice['id']) ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { padding: 8px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: #f5f5f5; font-weight: bold; }
        .total { text-align: right; font-weight: bold; margin: 10px 0; }
        .payment-info { background-color: #f9f9f9; padding: 10px; margin: 10px 0; border-radius: 4px; }
        .payment-info p { margin: 5px 0; }
        .divider { border-top: 2px dashed #ccc; margin: 15px 0; }
    </style>
    <script>
        window.onload = function() { window.print(); };
    </script>
</head>
<body>
    <h2 style="text-align: center;">STRUK PEMBELIAN</h2>
    
    <p><strong>Invoice ID:</strong> #<?= htmlspecialchars($invoice['id']) ?></p>
    <p><strong>Nama Pelanggan:</strong> <?= htmlspecialchars($invoice['nama_pelanggan'] ?? '-') ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars(ucfirst($invoice['status'] ?? 'pending')) ?></p>

    <div class="divider"></div>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Harga</th>
                <th style="text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($details as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['nama_produk'] ?? 'Produk') ?></td>
                <td style="text-align: center;"><?= htmlspecialchars($row['jumlah_produk']) ?></td>
                <td style="text-align: right;">Rp. <?= htmlspecialchars(number_format($row['harga'], 0, ',', '.')) ?></td>
                <td style="text-align: right;">Rp. <?= htmlspecialchars(number_format($row['subtotal'], 0, ',', '.')) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="divider"></div>

    <div class="total">
        Total: Rp. <?= htmlspecialchars(number_format($invoice['total'], 0, ',', '.')) ?>
    </div>

    <?php if ($paid !== null || ($invoice['status'] ?? '') === 'completed'): ?>
        <div class="payment-info">
            <p><strong>Pembayaran</strong></p>
            <p>Jumlah Pembayaran: Rp. <?= htmlspecialchars(number_format($paid !== null ? $paid : ($invoice['jumlah_pembayaran'] ?? 0), 0, ',', '.')) ?></p>
            <p>Kembalian: Rp. <?= htmlspecialchars(number_format($kembalian_get !== null ? $kembalian_get : ($invoice['kembalian'] ?? 0), 0, ',', '.')) ?></p>
        </div>
    <?php endif; ?>

    <div style="text-align: center; margin-top: 30px; font-size: 12px; color: #999;">
        <p>Terima kasih telah berbelanja</p>
        <p><?= date('d/m/Y H:i:s') ?></p>
    </div>
</body>
</html>