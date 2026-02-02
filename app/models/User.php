<?php
require_once __DIR__ . '/../../config/database.php';

class User {
    private $db;

    public function __construct($connection)
    {
        $this->db = $connection;
    }

    public function addUser($user_name)
    {
        // // Try to find existing pelanggan by exact name first
        // $existing = $this->getByName($user_name);
        // if ($existing) {
        //     return $existing['id'];
        // }

        $query = "INSERT INTO pelanggans (nama_pelanggan)
                    VALUES (:nama_pelanggan)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nama_pelanggan', $user_name);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function getByName($name)
    {
        $query = "SELECT * FROM pelanggans WHERE nama_pelanggan = :name LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}