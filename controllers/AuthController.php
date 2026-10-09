<?php
// controllers/AuthController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $db;
    private $user;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    // 1. Menampilkan halaman form registrasi
    public function register()
    {
        require_once __DIR__ . '/../views/auth/register.php';
    }

    // 2. Memproses data registrasi
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->name = $_POST['name'];
            $this->user->email = $_POST['email'];
            $this->user->password = $_POST['password'];

            // Validasi kosong (Perbaiki $eror jadi $error)
            if (empty($this->user->name) || empty($this->user->email) || empty($this->user->password)) {
                $error = "Semua field wajib diisi!";
                require_once __DIR__ . '/../views/auth/register.php';
                return;
            }

            // Cek email terdaftar
            if ($this->user->emailExists()) {
                $error = "Email sudah terdaftar, gunakan email lain!";
                require_once __DIR__ . '/../views/auth/register.php';
                return;
            }

            // Simpan ke database
            if ($this->user->create()) {
                // PERBAIKAN: 'success' (bukan succes) dan 'Location' (kapital L)
                header("Location: index.php?page=login&success=registered");
                exit(); // Wajib ada untuk menghentikan eksekusi skrip
            } else {
                $error = "Registrasi gagal, silakan coba lagi.";
                require_once __DIR__ . '/../views/auth/register.php';
            }
        }
    }

    // 3. Menampilkan halaman login
    public function login()
    {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    // 4. Memproses autentikasi login
    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->email = $_POST['email'];
            $this->user->password = $_POST['password'];

            if (empty($this->user->email) || empty($this->user->password)) {
                $error = "Email dan password wajib diisi!";
                require_once __DIR__ . '/../views/auth/login.php';
                return;
            }

            if ($this->user->login()) {
                // Security: Regenerate session ID untuk mencegah Session Fixation
                session_regenerate_id(true);

                $_SESSION['user_id'] = $this->user->id;
                $_SESSION['user_name'] = $this->user->name;
                $_SESSION['last_activity'] = time();

                header("Location: index.php?page=dashboard");
                exit();
            } else {
                $error = "Email atau password salah!";
                require_once __DIR__ . '/../views/auth/login.php';
            }
        }
    }

    // 5. Logout
    public function logout()
    {
        // Hapus semua data session
        $_SESSION = array();
        session_destroy();

        // Redirect ke login
        header("Location: index.php?page=login");
        exit();
    }
}
?>