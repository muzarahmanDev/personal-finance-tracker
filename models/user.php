<?php
//models/user.php

class user
{
    private $conn;

    private $table = 'users';

    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;
    public $updated_at;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //  Metode untuk membuat user baru (Registrasi)

    public function create()
    {
        // 1. Siapkan query menggunakan Prepared Statement (Anti SQL Inject
        // Kita TIDAK memasukkan variabel PHP langsung ke dalam string query.

        $query = "INSERT INTO " . $this->table . " SET name=:name, email=:email, password=:password";

        // 2. Prepare statement
        $stmt = $this->conn->prepare($query);

        // 3. Sanitasi input (Mencegah XSS - Cross Site Scripting)
        // htmlspecialchars mengubah karakter khusus HTML menjadi entitas aman.
        // strip_tags menghapus tag HTML/PHP yang mungkin disisipkan user 

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));

        // 4. Hashing Password (WAJIB untuk keamanan!)
        // JANGAN PERNAH menyimpan password plain text. PASSWORD_DEFAULT menggunakan 

        $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->$password_hash);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    //     /**
    //  * Metode untuk mengecek apakah email sudah terdaftar di database
    // * Digunakan sebelum registrasi untuk mencegah duplikasi, atau saat login.
    // * @return bool true jika email ada, false jika tidak
    // */

    public function emailExists(){
        $query = "SELECT id, password FROM " . $this->table . " WHERE email = :email LIMIT"; 
        $stmt = $this->conn->prepare($query); 

        // sanitasi email sebelum dicek 
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(":email", $this->email); 
        $stmt->execute(); 

        // rowCount() mengembalikan jumlah baris yang ditemukan. 
        // Jika > 0, berarti email sudah ada.

        return $stmt->rowCount() > 0; 
    } 
}
?>