<?php
// public/index.php 

// Memulai session (akan digunakan untuk login nanti)

session_start();

   require_once __DIR__ . '/../middleware/Auth.php';
// Mengambil parameter 'page' dari URL. Default ke 'register' jika tidak ad

$page = isset($_GET['page']) ? $_GET['page'] : 'register'; 

// Simple Routing (Switch Case) 

switch ($page) {
    // --- AUTH ROUTES ---
    case 'register':
        requireGuest();
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;

    case 'store-register':
        requireGuest();
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->store();
        break;

    case 'login':
        requireGuest();
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;

    case 'authenticate':
        requireGuest();
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->authenticate();
        break;

    case 'logout':
        // Logout tidak butuh controller khusus, bisa langsung di sini
        $_SESSION = array(); // Kosongkan array session
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_destroy(); // Hancurkan session
        
        header("Location: index.php?page=login&success=loggedout");
        exit();
        break;

    case 'dashboard':
        require_once __DIR__ . '/../controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->index();
        break;

    default:
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;
}
?>