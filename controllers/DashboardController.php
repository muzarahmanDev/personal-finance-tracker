<?php
// controllers/DashboardController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Transaction.php';
require_once __DIR__ . '/../middleware/Auth.php';

class DashboardController {
    private $db;
    private $transaction;

    public function __construct() {
        // SATPAM: wajib login
        requireLogin();

        $database = new Database();
        $this->db = $database->getConnection();

        $this->transaction = new Transaction($this->db);
    }

    public function index() {
        $userId = $_SESSION['user_id'];

        // 1. Ambil ringkasan keuangan (income, expense, balance)
        $summary = $this->transaction->getSummary($userId);

        // 2. Ambil 5 transaksi terbaru
        $recentTransactions = $this->transaction->getRecent($userId, 5);

        // 3. Kirim data ke View
        $pageTitle = "Dashboard";
        $userName  = $_SESSION['user_name'] ?? "User";

        require_once __DIR__ . '/../views/dashboard/index.php';
    }
}
?>