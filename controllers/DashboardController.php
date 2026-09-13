<?php 
// controllers/DashboardController.php

// Panggil middleware satpam kita

require_once __DIR__ . '/../middleware/Auth.php';

class DashboardController {

        public function __construct() {
        // PANGGIL SATPAM DI SINI!
        // Setiap kali controller ini dibuat, dia akan mengecek apakah user sudah login.
        requireLogin(); 
    }

     /**
     * Menampilkan halaman utama dashboard
     */

         public function index() {
        // Siapkan data untuk View
        $pageTitle = "Dashboard";
        $userName = $_SESSION['user_name'] ?? "User";
        
        // Nanti di sini kita akan ambil data transaksi dari database
        // Untuk sekarang, kita tampilkan halaman kosong dulu
        
        require_once __DIR__ . '/../views/dashboard/index.php';
    }


}


?>