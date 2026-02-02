<?php

class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'cashier';

    private $dsn;
    private $connection;

    public function connect()
    {
        $this->connection = null;
        $this->dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;

        try {
            $this->connection = new PDO($this->dsn, $this->user, $this->pass);
            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $e) {
            die("Koneksi Gagal: " . $e->getMessage());
        }

        return $this->connection;
    }
}

$database = new Database();
$connection = $database->connect();
