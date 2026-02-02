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

    public function createProduct()
    {
        if (isset($_POST['create-product'])) {
            $nama_produk = $_POST['nama-produk'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];
            $kategori = $_POST['kategori'];

            $this->product->createProduct($nama_produk, $harga, $stok, $kategori);

            header('Location: ?page=produk');
            exit();
        }
    }

    public function updateProduct($id)
    {
        if (isset($_POST['update-product'])) {
            $nama_produk = $_POST['nama-produk'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];
            $kategori = $_POST['kategori'];

            $this->product->updateProduct($nama_produk, $harga, $stok, $kategori, $id);

            header('Location: ?page=produk');
            exit();
        }
    }

    public function deleteProduct($id)
    {
        $this->product->deleteProduct($id);

        header('Location: ?page=produk');
        exit();
    }
}