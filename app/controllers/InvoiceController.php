<?php
require_once __DIR__ . '/../models/Invoice.php';
require_once __DIR__ . '/../models/Produk.php';
require_once __DIR__ . '/../models/User.php';

class InvoiceController {
    private $invoice;
    private $produk;
    private $user;

    public function __construct($connection)
    {
        $this->invoice = new Invoice($connection);
        $this->produk = new Product($connection);
        $this->user = new User($connection);

    }

    public function checkout()
    {
        // Ensure this is a POST request and read customer name
        $user_name = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_name = isset($_POST['nama_pelanggan']) ? trim($_POST['nama_pelanggan']) : '';
        }

        $cart = $_SESSION['cart'] ?? '';

        if (empty($cart)) {
            throw new Exception("Keranjang Kosong");
        }

        $total_invoice = 0;
        foreach ($cart as $item) {
            $total_invoice += $item['qty'] * $item['harga'];
            }
            
        // If no logged-in user id, create or find pelanggan and use its id
        if (empty($id_pelanggan)) {
            if (!empty($user_name)) {
                $id_pelanggan = $this->user->addUser($user_name);
            } else {
                // require a name when not logged in
                throw new Exception('Nama pelanggan diperlukan');
            }
        }

        $invoice_id = $this->invoice->addInvoice($id_pelanggan, $total_invoice);

        foreach($cart as $item) {
            $subtotal = $item['qty'] * $item['harga'];

            $this->invoice->addInvoiceDetail(
                $invoice_id,
                $item['id'],
                $item['harga'],
                $item['qty'],
                $subtotal
            );

            $this->produk->kurangiProduk($item['id'], $item['qty']);
        }

        unset($_SESSION['cart']);

        return $invoice_id;
    }

    public function showInvoiceAll()
    {
        return $this->invoice->getInvoice();
    }

    public function getInvoiceById($id)
    {
        return $this->invoice->getInvoiceById($id);
    }

}