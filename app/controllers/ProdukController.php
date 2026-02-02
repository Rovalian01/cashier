<?php
require_once __DIR__ . '/../models/Produk.php';

class ProductController {
    private $product;

    public function __construct($connection)
    {
        $this->product = new Product($connection);
    }

    public function showProduct()
    {
        return $this->product->allProduk();
    }

    public function showProductbyKategori()
    {
        if (isset($_GET['kategori']) && $_GET['kategori'] != 0) {
            $id = $_GET['kategori'];

            return $this->product->allProdukByKategoris($id);
        } else {
            return $this->product->allProduk();
        }
    }

    public function showKategori()
    {
        return $this->product->allKategori();
    }

    public function getProductById($id)
    {
        return $this->product->productById($id);
    }
}