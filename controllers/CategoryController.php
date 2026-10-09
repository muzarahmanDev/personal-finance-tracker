<?php
// controllers/CategoryController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../middleware/Auth.php';

class CategoryController {
    private $db;
    private $category;

    public function __construct() {
        // 1. Panggil Satpam (Middleware)
        requireLogin();
        
        // 2. Setup Database dan Model
        $database = new Database();
        $this->db = $database->getConnection();
        $this->category = new Category($this->db);
        
        // 3. Set user_id dari session ke Model (PENTING untuk keamanan multi-tenant)
        $this->category->user_id = $_SESSION['user_id'];
    }

    // READ: Tampilkan daftar kategori
    public function index() {
        $stmt = $this->category->readAll();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pageTitle = "Manajemen Kategori";
        
        require_once __DIR__ . '/../views/categories/index.php';
    }

    // CREATE: Tampilkan form tambah kategori
    public function create() {
        $pageTitle = "Tambah Kategori";
        require_once __DIR__ . '/../views/categories/create.php';
    }

    // STORE: Proses simpan kategori baru
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->category->name = $_POST['name'];
            $this->category->type = $_POST['type'];

            if ($this->category->create()) {
                header("Location: index.php?page=categories&success=created");
                exit();
            } else {
                $error = "Gagal menambahkan kategori.";
                $pageTitle = "Tambah Kategori";
                require_once __DIR__ . '/../views/categories/create.php';
            }
        }
    }

    // EDIT: Tampilkan form edit kategori
    public function edit() {
        if (isset($_GET['id'])) {
            $this->category->id = $_GET['id'];
            
            // Cek apakah kategori ada dan milik user ini
            if ($this->category->readOne()) {
                $pageTitle = "Edit Kategori";
                require_once __DIR__ . '/../views/categories/edit.php';
            } else {
                // Jika tidak ada atau bukan milik user, lempar ke list
                header("Location: index.php?page=categories&error=notfound");
                exit();
            }
        }
    }

    // UPDATE: Proses update kategori
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->category->id = $_POST['id'];
            $this->category->name = $_POST['name'];
            $this->category->type = $_POST['type'];

            if ($this->category->update()) {
                header("Location: index.php?page=categories&success=updated");
                exit();
            } else {
                $error = "Gagal mengupdate kategori.";
                $pageTitle = "Edit Kategori";
                require_once __DIR__ . '/../views/categories/edit.php';
            }
        }
    }

    // DELETE: Hapus kategori
    public function destroy() {
        if (isset($_GET['id'])) {
            $this->category->id = $_GET['id'];
            
            if ($this->category->delete()) {
                header("Location: index.php?page=categories&success=deleted");
                exit();
            } else {
                header("Location: index.php?page=categories&error=delete_failed");
                exit();
            }
        }
    }
}
?>