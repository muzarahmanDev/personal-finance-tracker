<?php
// models/Category.php 

class category
{
    private $conn;
    private $table = 'categories';

    //properti untuk menampung data 

    public $id;
    public $user_id;
    public $name;
    public $type;

    // Constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * READ ALL: Ambil semua kategori milik user yang sedang login
     */

    public function readAll()
    {
        $query = "SELECT id, name, type, created_at FROM " . $this->table . " 
                  WHERE user_id = :user_id ORDER BY type, name ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    /**
     * READ ONE: Ambil satu kategori berdasarkan ID (untuk halaman Edit)
     */

    public function readOne()
    {
        $query = "SELECT id, name, type FROM " . $this->table . " 
                  WHERE id = :id AND user_id = :user_id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->name = $row['name'];
            $this->type = $row['type'];
            return true;
        }
        return false;
    }

    /**
     * CREATE: Tambah kategori baru
     */

    public function create()
    {
        $query = "INSERT INTO " . $this->table . " 
                  SET name=:name, type=:type, user_id=:user_id";

        $stmt = $this->conn->prepare($query);

        // Sanitasi input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->type = htmlspecialchars(strip_tags($this->type));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * UPDATE: Ubah kategori
     */

    public function update()
    {
        $query = "UPDATE " . $this->table . " 
                  SET name=:name, type=:type 
                  WHERE id=:id AND user_id=:user_id";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->type = htmlspecialchars(strip_tags($this->type));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * DELETE: Hapus kategori
     */
    public function delete()
    {
        // HAPUS HANYA JIKA user_id cocok (Mencegah user lain menghapus data kita)
        $query = "DELETE FROM " . $this->table . " 
                  WHERE id = :id AND user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

}

?>