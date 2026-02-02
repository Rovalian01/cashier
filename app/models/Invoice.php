<?php
require_once __DIR__ . '/../../config/database.php';

class Invoice {
    private $db;

    public function __construct($connection)
    {
        $this->db = $connection;
    }

    public function getAllInvoice()
    {
        $query = "SELECT * FROM invoices";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addInvoice($id_pelanggan, $total_invoice)
    {
        $query = "INSERT INTO invoices (id_pelanggan, total)
                    VALUES (:id_pelanggan, :total)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_pelanggan', $id_pelanggan);
        $stmt->bindParam(':total', $total_invoice);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function addInvoiceDetail($id_invoice, $id_produk, $harga, $jumlah_produk, $subtotal)
    {
        $query = "INSERT INTO invoice_details (id_invoice, id_produk, harga, jumlah_produk, subtotal)
                    VALUES (:id_invoice, :id_produk, :harga, :jumlah_produk, :subtotal)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_invoice', $id_invoice);
        $stmt->bindParam(':id_produk', $id_produk);
        $stmt->bindParam(':harga', $harga);
        $stmt->bindParam(':jumlah_produk', $jumlah_produk);
        $stmt->bindParam(':subtotal', $subtotal);
        $stmt->execute();
        return $stmt;
    }

    public function getInvoiceById($id)
    {
        $query = "SELECT i.*, p.nama_pelanggan
                    FROM invoices i
                    LEFT JOIN pelanggans p ON i.id_pelanggan = p.id
                    WHERE i.id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getInvoice()
    {
        $query = "SELECT i.*, p.nama_pelanggan
                    FROM invoices i
                    LEFT JOIN pelanggans p ON i.id_pelanggan = p.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInvoiceDetails($id)
    {
        $query = "SELECT d.*, p.nama_produk
                    FROM invoice_details d
                    LEFT JOIN produks p ON d.id_produk = p.id
                    WHERE d.id_invoice = :id_invoice";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_invoice', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}