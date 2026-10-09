<?php 
// middleware/Auth.php

/**
 * Memastikan user SUDAH login sebelum mengakses halaman tertentu.
 * Jika belum login, tendang ke halaman login.
 */ 

function requireLogin() {
    if (!isset($_SESSION['user_id'])){
        $_SESSION['error_id'] = "silahkan login terlebih dahulu"; 

        header("Location: index.php?page=login"); 
        exit(); 
    }

    if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)){
        session_unset(); 
        session_destroy(); 
        header("Location: index.php?page=login&timeout=1"); 
        exit(); 
    }

     // Update waktu aktivitas terakhir
    $_SESSION['last_activity'] = time();

}

/**
 * Memastikan user BELUM login (untuk halaman register/login).
 * Jika sudah login, tendang ke dashboard.
 */
function requireGuest() {
    if (isset($_SESSION['user_id'])) {
        header("Location: index.php?page=dashboard");
        exit();
    }
}

?>