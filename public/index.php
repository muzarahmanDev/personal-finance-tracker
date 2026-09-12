<?php
// public/index.php 

// Memulai session (akan digunakan untuk login nanti)

session_start();

// Mengambil parameter 'page' dari URL. Default ke 'register' jika tidak ad

$page = isset($_GET['page']) ? $_GET['page'] : 'register'; 

// Simple Routing (Switch Case) 

switch ($page) {
    // --- AUTH ROUTES ---
    case 'register':
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register(); // Tampilkan form
        break;

    case 'store-register':
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->store(); // Proses form
        break;

    // --- DEFAULT / HOME ---
    default:
        // Untuk sementara, arahkan ke register
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;
}
?>