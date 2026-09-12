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
        $controller->register();
        break;

    case 'store-register':
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->store();
        break;

    case 'login':
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;

    case 'authenticate':
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->authenticate();
        break;

    case 'logout':
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'dashboard':
        // sementara, sampai kamu buat DashboardController
        echo "Halaman dashboard (belum dibuat)";
        break;

    default:
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;
}
?>