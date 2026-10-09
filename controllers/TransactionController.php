<?php
// controllers/TransactionController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Transaction.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../middleware/Auth.php';

class TransactionController {
    private $db;
    private $transaction;
    private $category;

    public function __construct() {
        // 1. SATPAM: wajib login sebelum controller ini bisa dipakai
        requireLogin();

        // 2. Setup koneksi & model
        $database = new Database();
        $this->db = $database->getConnection();

        $this->transaction = new Transaction($this->db);
        $this->transaction->user_id = $_SESSION['user_id'];

        // 3. Model Category JUGA dibutuhkan (untuk dropdown di form transaksi)
        $this->category = new Category($this->db);
        $this->category->user_id = $_SESSION['user_id'];
    }

    /**
     * HELPER: Ambil tipe kategori berdasarkan ID-nya.
     * Sekaligus memvalidasi bahwa kategori itu BENAR milik user yang login.
     * Return: 'income' / 'expense', atau null jika tidak valid.
     */
    private function getCategoryType($categoryId) {
        $categories = $this->category->readAll()->fetchAll(PDO::FETCH_ASSOC);
        foreach ($categories as $cat) {
            if ((int)$cat['id'] === (int)$categoryId) {
                return $cat['type'];
            }
        }
        return null;
    }

    // READ: Daftar semua transaksi milik user
    public function index() {
        $transactions = $this->transaction->readAllByUser($_SESSION['user_id'])->fetchAll(PDO::FETCH_ASSOC);
        $pageTitle = "Manajemen Transaksi";
        require_once __DIR__ . '/../views/transactions/index.php';
    }

    // CREATE: Tampilkan form tambah transaksi
    public function create() {
        $categories = $this->category->readAll()->fetchAll(PDO::FETCH_ASSOC);
        $pageTitle = "Tambah Transaksi";
        require_once __DIR__ . '/../views/transactions/create.php';
    }

    // STORE: Proses simpan transaksi baru
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $categoryId = $_POST['category_id'] ?? null;
        $amount     = $_POST['amount'] ?? null;
        $date       = $_POST['date'] ?? null;

        // VALIDASI SERVER-SIDE (jangan pernah percaya input browser!)
        $type = $this->getCategoryType($categoryId); // sekaligus cek kepemilikan kategori
        $errors = [];
        if ($type === null)                      $errors[] = "Kategori tidak valid atau bukan milik Anda!";
        if (!is_numeric($amount) || $amount <= 0) $errors[] = "Jumlah harus berupa angka lebih dari 0!";
        if (empty($date))                        $errors[] = "Tanggal wajib diisi!";

        if (!empty($errors)) {
            $error = implode(" ", $errors);
            $categories = $this->category->readAll()->fetchAll(PDO::FETCH_ASSOC);
            $pageTitle = "Tambah Transaksi";
            require_once __DIR__ . '/../views/transactions/create.php';
            return;
        }

        $this->transaction->category_id = $categoryId;
        $this->transaction->type        = $type; // tipe OTOMATIS mengikuti kategori (konsistensi data)
        $this->transaction->amount      = $amount;
        $this->transaction->description = $_POST['description'] ?? '';
        $this->transaction->date        = $date;

        if ($this->transaction->create()) {
            header("Location: index.php?page=transactions&success=created");
            exit();
        }

        $error = "Gagal menyimpan transaksi. Silakan coba lagi.";
        $categories = $this->category->readAll()->fetchAll(PDO::FETCH_ASSOC);
        $pageTitle = "Tambah Transaksi";
        require_once __DIR__ . '/../views/transactions/create.php';
    }

    // EDIT: Tampilkan form edit transaksi
    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) { header("Location: index.php?page=transactions"); exit(); }

        // Cek kepemilikan: transaksi harus milik user yang login
        $transaction = $this->transaction->readOneById($id, $_SESSION['user_id']);
        if (!$transaction) {
            header("Location: index.php?page=transactions&error=notfound");
            exit();
        }

        $categories = $this->category->readAll()->fetchAll(PDO::FETCH_ASSOC);
        $pageTitle = "Edit Transaksi";
        require_once __DIR__ . '/../views/transactions/edit.php';
    }

    // UPDATE: Proses update transaksi
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $id = $_POST['id'] ?? null;
        $existing = $id ? $this->transaction->readOneById($id, $_SESSION['user_id']) : null;
        if (!$existing) {
            header("Location: index.php?page=transactions&error=notfound");
            exit();
        }

        $categoryId = $_POST['category_id'] ?? null;
        $amount     = $_POST['amount'] ?? null;
        $date       = $_POST['date'] ?? null;

        $type = $this->getCategoryType($categoryId);
        $errors = [];
        if ($type === null)                      $errors[] = "Kategori tidak valid atau bukan milik Anda!";
        if (!is_numeric($amount) || $amount <= 0) $errors[] = "Jumlah harus berupa angka lebih dari 0!";
        if (empty($date))                        $errors[] = "Tanggal wajib diisi!";

        if (!empty($errors)) {
            // UX BEST PRACTICE: isi ulang form dengan data yang dikirim user agar tidak hilang
            $error = implode(" ", $errors);
            $transaction = $existing;
            $transaction['category_id'] = $categoryId;
            $transaction['amount']      = $amount;
            $transaction['date']        = $date;
            $transaction['description'] = $_POST['description'] ?? '';
            $categories = $this->category->readAll()->fetchAll(PDO::FETCH_ASSOC);
            $pageTitle = "Edit Transaksi";
            require_once __DIR__ . '/../views/transactions/edit.php';
            return;
        }

        $this->transaction->id          = $id;
        $this->transaction->category_id = $categoryId;
        $this->transaction->type        = $type;
        $this->transaction->amount      = $amount;
        $this->transaction->description = $_POST['description'] ?? '';
        $this->transaction->date        = $date;

        if ($this->transaction->update()) {
            header("Location: index.php?page=transactions&success=updated");
            exit();
        }

        $error = "Gagal mengupdate transaksi.";
        $transaction = $existing;
        $categories = $this->category->readAll()->fetchAll(PDO::FETCH_ASSOC);
        $pageTitle = "Edit Transaksi";
        require_once __DIR__ . '/../views/transactions/edit.php';
    }

    // DELETE: Hapus transaksi
    public function destroy() {
        $id = $_GET['id'] ?? null;
        if (!$id) { header("Location: index.php?page=transactions"); exit(); }

        $this->transaction->id = $id;
        if ($this->transaction->delete()) {
            header("Location: index.php?page=transactions&success=deleted");
            exit();
        }
        header("Location: index.php?page=transactions&error=delete_failed");
        exit();
    }
}
?>