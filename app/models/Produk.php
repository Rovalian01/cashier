<?php
require_once __DIR__ . '/../../config/database.php';

class Product {
    private $db;

    public function __construct($connection)
    {
        $this->db = $connection;
    }

    public function allProduk()
    {
        $query = "SELECT produks.*, kategoris.nama_kategori
                    FROM produks
                    JOIN kategoris ON produks.id_kategori = kategoris.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function allProdukByKategoris($id)
    {
        $query = "SELECT produks.*, kategoris.nama_kategori
                    FROM produks
                    JOIN kategoris ON produks.id_kategori = kategoris.id
                    WHERE id_kategori = :id_kategori";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_kategori', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function allKategori()
    {
        $query = "SELECT * FROM Kategoris";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function productById($id)
    {
        $query = "SELECT * FROM produks WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function kurangiProduk($id, $qty)
    {
        // Decrease stok by :qty safely and prevent negative stock
        $query = "UPDATE produks SET stok = GREATEST(stok - :qty, 0) WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':qty', $qty);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt;
    }

    public function createProduct($nama_produk, $harga, $stok, $kategori)
    {
        $query = "INSERT INTO produks (nama_produk, harga, stok, id_kategori)
                    VALUES (:nama_produk, :harga, :stok, :id_kategori)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nama_produk', $nama_produk);
        $stmt->bindParam(':harga', $harga);
        $stmt->bindParam(':stok', $stok);
        $stmt->bindParam(':id_kategori', $kategori);
        $stmt->execute();
        return $stmt;
    }

    public function updateProduct($nama_produk, $harga, $stok, $kategori, $id)
    {
        $query = "UPDATE produks SET nama_produk = :nama_produk, harga = :harga, stok = :stok, id_kategori = :id_kategori WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nama_produk', $nama_produk);
        $stmt->bindParam(':harga', $harga);
        $stmt->bindParam(':stok', $stok);
        $stmt->bindParam(':id_kategori', $kategori);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt;
    }

    public function deleteProduct($id)
    {
        $query = "DELETE FROM produks WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt;
    }
}