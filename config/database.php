<?php
// config/database.php

class Database {
    // Konfigurasi database (sesuaikan jika password MySQL kamu berbeda)
    private $host = "localhost";
    private $db_name = "financetrack_db";
    private $username = "root";
    private $password = ""; // Kosongkan jika menggunakan default Laragon/XAMPP
    
    // Properti untuk menyimpan objek koneksi
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            // 1. Membuat koneksi PDO
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            
            // 2. Set error mode ke Exception (Best Practice)
            // Jika ada error database, PHP akan langsung "berteriak" (throw exception)
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // 3. Set default fetch mode ke Associative Array
            // Memudahkan kita mengambil data hasil query dalam bentuk array asosiatif ['key' => 'value']
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch(PDOException $exception) {
            // 4. Handle error jika koneksi gagal
            // Untuk saat ini kita echo saja, nanti di produksi ini harus di-log, bukan di-echo.
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

?>