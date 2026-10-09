<?php
// models/Transaction.php
class Transaction {
    private $conn;
    private $table = 'transactions';

    // Properti tabel
    public $id;
    public $user_id;
    public $category_id;
    public $type;
    public $amount;
    public $description;
    public $date;

    public function __construct($db) {
        $this->conn = $db;
    }

    // READ: Ambil semua transaksi milik user (JOIN kategori agar nama terbaca)
    public function readAllByUser($user_id) {
        $query = "SELECT t.id, t.type, t.amount, t.description, t.date,
                         c.name AS category_name
                  FROM " . $this->table . " t
                  LEFT JOIN categories c ON t.category_id = c.id
                  WHERE t.user_id = :user_id
                  ORDER BY t.date DESC, t.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt;
    }

    // READ: Ambil satu transaksi (dengan cek kepemilikan = keamanan)
    public function readOneById($id, $user_id) {
        $query = "SELECT id, category_id, type, amount, description, date
                  FROM " . $this->table . "
                  WHERE id = :id AND user_id = :user_id
                  LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // CREATE
    public function create() {
        $query = "INSERT INTO " . $this->table . "
                  SET user_id = :user_id,
                      category_id = :category_id,
                      type = :type,
                      amount = :amount,
                      description = :description,
                      date = :date";
        $stmt = $this->conn->prepare($query);

        $this->description = htmlspecialchars(strip_tags($this->description ?? ''));

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":date", $this->date);

        return $stmt->execute();
    }

    // UPDATE (dengan cek kepemilikan)
    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET category_id = :category_id,
                      type = :type,
                      amount = :amount,
                      description = :description,
                      date = :date
                  WHERE id = :id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);

        $this->description = htmlspecialchars(strip_tags($this->description ?? ''));

        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);

        return $stmt->execute();
    }

    // DELETE (dengan cek kepemilikan)
    public function delete() {
        $query = "DELETE FROM " . $this->table . "
                  WHERE id = :id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);
        return $stmt->execute();
    }

        /**
     * SUMMARY: Hitung total pemasukan, pengeluaran, dan saldo dalam SATU query.
     * Menggunakan teknik Conditional Aggregation: SUM(CASE WHEN ...).
     */
    public function getSummary($userId) {
        $query = "SELECT 
                    COALESCE(SUM(CASE WHEN type = 'income'  THEN amount ELSE 0 END), 0) AS total_income,
                    COALESCE(SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END), 0) AS total_expense
                  FROM " . $this->table . "
                  WHERE user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $income  = (float)$row['total_income'];
        $expense = (float)$row['total_expense'];
        
        // Saldo dihitung di sisi PHP (business logic, bukan urusan database)
        return [
            'income'  => $income,
            'expense' => $expense,
            'balance' => $income - $expense,
        ];
    }

    /**
     * RECENT: Ambil beberapa transaksi terbaru untuk widget dashboard.
     */
    public function getRecent($userId, $limit = 5) {
        // LIMIT tidak aman pakai placeholder string, jadi kita cast ke integer.
        // Aman karena $limit berasal dari kode kita sendiri, BUKAN input user.
        $limit = (int)$limit;
        
        $query = "SELECT t.id, t.type, t.amount, t.description, t.date,
                         c.name AS category_name
                  FROM " . $this->table . " t
                  LEFT JOIN categories c ON t.category_id = c.id
                  WHERE t.user_id = :user_id
                  ORDER BY t.date DESC, t.id DESC
                  LIMIT " . $limit;
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
?>