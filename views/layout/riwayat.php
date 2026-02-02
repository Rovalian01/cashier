<?php
require_once __DIR__ . '/../../bootstrap/app.php';
$data = $invoiceController->showInvoiceAll();
?>

<main>
    <h1>Daftar Riwayat</h1>

    <div class="table-container">
        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No Invoice</th>
                <th>Total</th>
                <th>Detail</th>
            </tr>

            <?php foreach($data as $index => $row): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $row['nama_pelanggan'] ?></td>
                <td><?= $row['id'] ?></td>
                <td><?= $row['total'] ?></td>
                <td>
                    
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</main>