<?php
//controller/AuthController.php 

// Memanggil file yang dibutuhkan menggunakan __DIR__ (Best Practice)
// __DIR__ berarti "folder tempat file ini berada", sehingga path tidak akan error
// meskipun dipanggil dari folder yang berbeda (seperti dari public/index.php)

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController{
    private $db; 
    private $user; 
    public function __construct(){
        $database = new Database(); 
        $this->db = $database->getConnection(); 
        $this->user = new User($this->db); 
    }

    // Menampilkan halaman form registrasi (GET Request) 
    
    public function register(){
        // memanggil view 
        require_once __DIR__ . '/../views/auth/register.php'; 
    }

    // Memproses data registrasi dari form (POST Request)
    public function store(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // 1. Ambil data dari form dan masukkan ke object User

            $this->user->name = $_POST['name']; 
            $this->user->email = $_POST['email']; 
            $this->user->password = $_POST['password']; 

            // 2. Validasi Sederhana (Cek kosong atau tidak)

            if(empty($this->user->name) || empty($this->user->email) || empty($this->user->password)){
                $eror = "semua field wajib diisi"; 
                require_once __DIR__ . '/../views/auth/register.php';
                return; // Hentikan eksekusi di sini
            }

            // 3. Cek apakah email sudah terdaftar

            if($this->user->emailExists()){
                $eror = "email sudah terdaftar, gunakan email lain!"; 
                require_once __DIR__ . '/../views/auth/register.php'; 
                return; 
            }

             // 4. Jika aman, simpan ke database melalui Model

            if($this->user->create()){
                //jika aman, redirect ke halaman login 

                header("location: index.php?page=login&succes=registered"); 
                exit(); //WAJIB ADA EXIT, SETELAH HEADER() REDIRECT BIAR APA? BIARINNNN
            }else{
                $eror = "Registrasi gagal, silahkan coba lagi nanti, kapan? kapan-kapan!"; 
                require_once __DIR__ . '/../views/auth/register.php';
            }

        }
    }

}

?>