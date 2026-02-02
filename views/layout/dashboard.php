<?php
require_once __DIR__ . '/../../bootstrap/app.php';
$dataKategori = $productController->showKategori();
$dataProduk = $productController->showProductbyKategori();
?>

<main>
    <h1>Dashboard Admin</h1>

    <div class="content">
        <section class="left-panel">
            <div class="row">
                
                <a href="?kategori=0" class="card">Semua</a>

                <?php foreach($dataKategori as $row): ?>
                <a href="?kategori=<?= $row['id'] ?>" class="card"><?= $row['nama_kategori'] ?></a>
                <?php endforeach; ?>

            </div>

            <div class="table-container">
                <table>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>

                    <?php foreach($dataProduk as $index => $row): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $row['nama_produk'] ?></td>
                        <td><?= $row['stok'] ?></td>
                        <td><?= $row['harga'] ?></td>
                        <td>
                            <button class="add-to-invoice" data-id="<?= $row['id'] ?>" data-nama="<?= $row['nama_produk'] ?>" data-harga="<?= $row['harga'] ?>">+</button>
                            <button class="delete-from-invoice" data-id="<?= $row['id'] ?>">-</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </section>

        <section class="right-panel">
            <h2>Invoice</h2>

            <div class="invoices">
                <div class="invoices-details">
                    <table class="table-container">
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>

                    </table>

                    <div class="total">
                        <span>Total Pembelian: </span>
                        <span id="total-amount">0</span>
                    </div>

                    <!-- Checkout Section -->
                    <form id="checkout-form" class="checkout-form">
                        <input type="text" id="nama_pelanggan" name="nama_pelanggan" placeholder="Nama Pelanggan" required>
                        <button type="submit" id="checkout-btn">Checkout</button>
                    </form>

                    <!-- Payment Section (hidden by default) -->
                    <div id="payment-section" class="payment-section">
                        <h3>Pembayaran</h3>
                        <div>
                            <label>Total: <span id="payment-total">0</span></label><br>
                            <input type="number" id="jumlah-pembayaran" placeholder="Jumlah Pembayaran" min="0">
                            <button type="button" id="payment-btn">Bayar</button>
                        </div>
                        <div id="kembalian-display">
                            <p><strong>Kembalian: <span id="kembalian-amount">0</span></strong></p>
                        </div>
                    </div>

                    <!-- Success Message (hidden by default) -->
                    <div id="success-message" style="display:none; padding:10px; background-color:#c8e6c9; border-radius:4px; margin-top:10px;">
                        <p><strong>Transaksi Berhasil!</strong></p>
                        <p>Invoice ID: <span id="success-invoice-id"></span></p>
                        <p>Kembalian: <span id="success-kembalian"></span></p>
                        <button type="button" id="print-invoice-btn">Cetak Struk</button>
                        <button type="button" id="new-transaction-btn">Transaksi Baru</button>
                    </div>

                </div>
            </div>
        </section>
    </div>
</main>

<script>
document.getElementById('checkout-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const nama_pelanggan = document.getElementById('nama_pelanggan').value;
    if (!nama_pelanggan) {
        alert('Nama pelanggan wajib diisi');
        return;
    }

    try {
        const response = await fetch('api/checkout.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'nama_pelanggan=' + encodeURIComponent(nama_pelanggan) + '&checkout=1'
        });

        const data = await response.json();
        if (data.success) {
            document.getElementById('payment-total').textContent = document.getElementById('total-amount').innerText.split(': ')[1];
            
            // Store invoice_id for payment
            window.currentInvoiceId = data.invoice_id;
        } else {
            alert(data.message);
        }
    } catch (err) {
        console.error(err);
        alert('Gagal melakukan checkout');
    }
});

document.getElementById('payment-btn').addEventListener('click', async () => {
    const jumlah = parseInt(document.getElementById('jumlah-pembayaran').value);
    const total = parseInt(document.getElementById('payment-total').textContent);

    if (!jumlah || jumlah <= 0) {
        alert('Masukkan jumlah pembayaran');
        return;
    }

    if (jumlah < total) {
        alert('Pembayaran kurang ' + (total - jumlah));
        return;
    }

    try {
        const response = await fetch('api/process_payment.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'invoice_id=' + window.currentInvoiceId + '&jumlah_pembayaran=' + jumlah
        });

        const data = await response.json();
        if (data.success) {
            document.getElementById('success-message').style.display = 'block';
            document.getElementById('success-invoice-id').textContent = data.invoice_id;
            document.getElementById('success-kembalian').textContent = 'Rp. ' + data.kembalian.toLocaleString('id-ID');
            
            // Clear cart display
            const table = document.querySelector(".invoices-details table");
            table.innerHTML = '<tr><th>Produk</th><th>Jumlah</th><th>Harga</th><th>Total</th></tr>';
            document.getElementById('total-amount').innerText = '0';
        } else {
            alert(data.message);
        }
    } catch (err) {
        console.error(err);
        alert('Gagal memproses pembayaran');
    }
});

document.getElementById('print-invoice-btn').addEventListener('click', () => {
    // include payment info in querystring for display-only printing
    const paid = document.getElementById('jumlah-pembayaran').value || 0;
    const kembalianText = document.getElementById('success-kembalian').textContent || '';
    // parse numeric kembalian from displayed formatted string (e.g. 'Rp. 1.000')
    let kembalian = 0;
    if (kembalianText) {
        kembalian = kembalianText.replace(/[^0-9]/g, '');
    }
    window.open('api/print_invoice.php?id=' + window.currentInvoiceId + '&paid=' + encodeURIComponent(paid) + '&kembalian=' + encodeURIComponent(kembalian));
});

document.getElementById('new-transaction-btn').addEventListener('click', () => {
    // Reset form and display
    document.getElementById('checkout-form').reset();
    document.getElementById('checkout-form').style.display = 'block';
    document.getElementById('success-message').style.display = 'none';
    document.getElementById('kembalian-display').style.display = 'none';
    document.getElementById('jumlah-pembayaran').value = '';
    window.currentInvoiceId = null;
});
</script>
