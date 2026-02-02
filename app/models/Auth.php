<?php
require_once __DIR__ . '/../../config/database.php';

class Auth {
    private $db;

    public function __construct($connection)
    {
        $this->db = $connection;
    }

    public function getAllUser()
    {
        $query = "SELECT * FROM pelanggans";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserByUsername($username)
    {
        $query = "SELECT * FROM pelanggans WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAdminByUsername($username)
    {
        $query = "SELECT * FROM admins WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}