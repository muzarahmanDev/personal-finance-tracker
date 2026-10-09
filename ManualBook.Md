Halo Zaky! Ide yang sangat bagus. Sebagai Senior Engineer, saya akan menyusun **"Master Manual Book & Developer Journal"** ini dengan sangat detail, terstruktur, dan berurutan. 

Dokumen ini dirancang agar kamu bisa membacanya ulang di masa depan, bahkan jika kamu lupa cara setup dari nol. Ini mencakup **Step-by-Step Execution**, **Konsep di Baliknya**, dan **Troubleshooting (Error Logs)** yang pernah kita alami.

Mari kita mulai!

---

# 📘 MASTER MANUAL BOOK: PERSONAL FINANCE TRACKER
**Author:** Muhammad Zaky Rahman  
**Role:** Backend Developer  
**Tech Stack:** PHP Native (OOP/MVC), MySQL (PDO), Bootstrap 5, Git/GitHub, Laragon.

---

## 🏗️ PHASE 1: Environment & Project Initialization

### Langkah 1: Persiapan Folder & Inisialisasi Git
**Konsep:** Kita memisahkan folder proyek dari folder server (`www`) untuk keamanan dan manajemen portofolio yang profesional. Git digunakan untuk melacak setiap perubahan kode.

**Aksi di Terminal (Git Bash / VS Code Terminal):**
1. Buat folder utama dan masuk ke dalamnya:
   ```bash
   mkdir personal-finance-tracker
   cd personal-finance-tracker
   ```
2. Inisialisasi Git:
   ```bash
   git init
   ```

**Aksi di VS Code:**
1. Buka folder `personal-finance-tracker` di VS Code.
2. Buat file **`.gitignore`** di root folder. Isi dengan:
   ```text
   .DS_Store
   Thumbs.db
   .vscode/
   .env
   config/config.local.php
   vendor/
   ```
3. Buat struktur folder kosong: `config`, `controllers`, `models`, `middleware`, `includes`, `views` (beserta sub-folder: `layouts`, `auth`, `dashboard`, `transactions`, `categories`), dan `public` (beserta sub-folder: `css`, `js`, `images`).
4. Buat file kosong **`README.md`** di root folder.

> ⚠️ **Error Log #1: `'git' is not recognized...`**
> *   **Penyebab:** Git belum terdaftar di PATH Windows atau kamu menggunakan PowerShell bawaan.
> *   **Solusi:** Gunakan **Git Bash** atau **VS Code Terminal** yang sudah terdeteksi Git.

---

### Langkah 2: Setup Database MySQL
**Konsep:** Database adalah entitas terpisah. Kita buat skema tabel terlebih dahulu sebelum menyentuh kode PHP.

**Aksi di phpMyAdmin (`http://localhost/phpmyadmin`):**
1. Buat database baru bernama **`financetrack_db`** (Pilih Collation: `utf8mb4_unicode_ci`).
2. Klik database tersebut, buka tab **SQL**, dan jalankan script ini:

```sql
-- Tabel Users
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Categories
CREATE TABLE categories (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    name VARCHAR(50) NOT NULL,
    type ENUM('income', 'expense') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Transactions
CREATE TABLE transactions (
     id INT(11) AUTO_INCREMENT PRIMARY KEY,
     user_id INT(11) NOT NULL,
     category_id INT(11) NOT NULL,
     type ENUM('income', 'expense') NOT NULL,
     amount DECIMAL(10,2) NOT NULL,
     description TEXT,
     date DATE NOT NULL,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
     FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

> 💡 **Konsep `ENGINE=InnoDB...`:** `InnoDB` wajib untuk mendukung Foreign Key. `utf8mb4` mendukung emoji. `unicode_ci` membuat pencarian email tidak peduli huruf besar/kecil (case-insensitive).

---

### Langkah 3: Setup Virtual Host (Laragon)
**Konsep:** Mengarahkan domain lokal `pft.test` langsung ke folder `public` proyek kita di `D:\development\...`. Ini mencegah user mengakses file sensitif seperti `config/database.php` dari browser.

**Aksi:**
1. Buka File Explorer, buat file **`pft.test.conf`** di `C:\laragon\etc\apache2\sites-enabled\`.
2. Isi dengan:
   ```apache
   <VirtualHost *:80>
       ServerName pft.test
       DocumentRoot "D:/development/finance_track/personal-finance-tracker/public"
       <Directory "D:/development/finance_track/personal-finance-tracker/public">
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```
3. Buka **Notepad sebagai Administrator**, buka file `C:\Windows\System32\drivers\etc\hosts`. Tambahkan di baris paling bawah:
   ```text
   127.0.0.1    pft.test
   ```
4. **Restart Laragon** (Stop All -> Start All).

> ⚠️ **Error Log #2: `DNS_PROBE_FINISHED_NXDOMAIN`**
> *   **Penyebab:** File `hosts` belum diedit atau Notepad tidak dijalankan sebagai Administrator.
> ⚠️ **Error Log #3: `404 Not Found`**
> *   **Penyebab:** Typo nama file (misal `test_db.php` vs `test-db.php`) atau `DocumentRoot` tidak mengarah ke folder `public`.

---

## 🧠 PHASE 2: Database Connection & Version Control

### Langkah 4: Koneksi PDO
**Konsep:** Menggunakan PDO dengan *Prepared Statements* untuk mencegah SQL Injection.

**Aksi:** Buat file **`config/database.php`**:
```php
<?php
class Database {
    private $host = "localhost";
    private $db_name = "financetrack_db";
    private $username = "root";
    private $password = ""; 
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
```

---

### Langkah 5: First Commit & Push ke GitHub
**Konsep:** Mengamankan kode ke cloud dengan pesan commit yang profesional.

**Aksi di Terminal:**
1. Konfigurasi identitas (Hanya sekali seumur hidup di PC ini):
   ```bash
   git config --global user.name "Muhammad Zaky Rahman"
   git config --global user.email "email_kamu@github.com"
   ```
2. Commit dan Push:
   ```bash
   git add .
   git commit -m "feat: setup project structure, database schema, and PDO connection"
   git branch -M main
   git remote add origin https://github.com/muzarahmanDev/personal-finance-tracker.git
   git push -u origin main
   ```

---

##  PHASE 3: Authentication (MVC & Session)

### Langkah 6: Membuat Model User (`models/User.php`)
**Konsep:** Model hanya bertugas bicara dengan database. Password **WAJIB** di-hash menggunakan `password_hash()`.

**Aksi:** Buat file `models/User.php` (Isi dengan method `create()`, `emailExists()`, dan `login()` seperti yang telah kita buat sebelumnya. Pastikan **TIDAK ADA spasi** sebelum `<?php`).

> ⚠️ **Error Log #4: `SQLSTATE[42000] Syntax error... near '' at line 1`**
> *   **Penyebab:** Typo di query `emailExists()`. Tertulis `LIMIT` tanpa angka.
> *   **Solusi:** Perbaiki menjadi `LIMIT 1`.

### Langkah 7: Controller & View Auth
**Konsep:** Controller menangani logika (validasi, session), View hanya menampilkan HTML.

**Aksi:**
1. Buat **`controllers/AuthController.php`** (Handle `register`, `store`, `login`, `authenticate`, `logout`).
2. Buat **`views/auth/register.php`** dan **`views/auth/login.php`** (Gunakan Bootstrap 5).

> ⚠️ **Error Log #5: Redirect Gagal (Layar putih/refresh)**
> *   **Penyebab:** Ada spasi sebelum `<?php` di file Model/Controller, atau typo variabel (`$eror` vs `$error`).
> *   **Solusi:** Hapus spasi tersembunyi. Pastikan `exit();` ada setelah `header("Location: ...")`.

### Langkah 8: Routing & Middleware (`public/index.php` & `middleware/Auth.php`)
**Konsep:** `index.php` adalah pintu gerbang (Front Controller). Middleware adalah "satpam" yang mengecek session.

**Aksi:**
1. Buat **`middleware/Auth.php`** berisi fungsi `requireLogin()`.
2. Update **`public/index.php`** dengan `switch($page)` untuk routing `register`, `login`, `dashboard`, `logout`.
3. Buat **`controllers/DashboardController.php`** dan **`views/dashboard/index.php`**. Panggil `requireLogin()` di dalam `__construct()` Controller.

---

##  PHASE 4: Core Features (Category CRUD)

### Langkah 9: Membuat Model Category (`models/Category.php`)
**Konsep: Multi-Tenancy (Keamanan Data).** Setiap query **WAJIB** menyertakan `WHERE user_id = :user_id` agar User A tidak bisa melihat data User B.

**Aksi:** Buat `models/Category.php` dengan method: `readAll()`, `readOne()`, `create()`, `update()`, `delete()`.

### Langkah 10: Controller & View Category
**Aksi:**
1. Buat **`controllers/CategoryController.php`**. Di `__construct()`, panggil `requireLogin()` dan set `$this->category->user_id = $_SESSION['user_id'];`.
2. Buat **`views/categories/index.php`** (Tabel daftar kategori), **`create.php`** (Form tambah), **`edit.php`** (Form edit).

### Langkah 11: Layouts (DRY Principle)
**Konsep:** *Don't Repeat Yourself*. Pisahkan Header dan Footer agar tidak perlu copy-paste tag `<html>` dan Navbar di setiap halaman.

**Aksi:**
1. Buat **`views/layouts/header.php`** (Berisi `<html>`, `<head>`, Navbar).
2. Buat **`views/layouts/footer.php`** (Berisi `</main>`, Footer, `<script>`).
3. Di setiap View (Dashboard, Category), panggil layout ini:
   ```php
   <?php require_once __DIR__ . '/../layouts/header.php'; ?>
   <!-- Konten Halaman -->
   <?php require_once __DIR__ . '/../layouts/footer.php'; ?>
   ```

### Langkah 12: Update Router
**Aksi:** Tambahkan `case` untuk `categories`, `create-category`, `store-category`, `edit-category`, `update-category`, `delete-category` di `public/index.php`.

---

## 🛠️ Troubleshooting Handbook (Quick Reference)

| Gejala / Error | Penyebab Umum | Cara Debugging / Solusi |
| :--- | :--- | :--- |
| **Layar putih / Tidak ada error** | Error fatal tapi `display_errors` mati. | Tambahkan `error_reporting(E_ALL); ini_set('display_errors', 1);` di baris atas `index.php`. |
| **Redirect (`header()`) tidak jalan** | Ada output (spasi/echo) sebelum `header()`. | Cek spasi sebelum `<?php`. Pastikan ada `exit();` setelah `header()`. |
| **SQL Syntax Error** | Typo di query SQL, variabel kosong. | Gunakan `echo $query; die();` di Model untuk melihat query mentah yang dikirim ke DB. |
| **Data masuk DB tapi tidak redirect** | Logika `if` tidak terpenuhi atau return `false`. | Gunakan `die("Sampai sini");` di dalam blok `if` untuk melacak alur eksekusi. |
| **404 Not Found** | URL salah, atau file tidak ada di folder `public`. | Cek URL di browser. Pastikan file ada di folder yang ditunjuk `DocumentRoot`. |

---

## 🌟 Senior Dev Tips (Golden Rules)

1. **Jangan pernah percaya input user.** Selalu anggap input user adalah "racun". Sanitasi di Controller/Model, dan *escape* (`htmlspecialchars`) di View.
2. **Konsistensi Nama.** 
   * File web/URL: `kebab-case` (contoh: `create-category.php`)
   * Class PHP: `PascalCase` (contoh: `CategoryController`)
   * Variabel/Method: `camelCase` (contoh: `$userName`, `readAll()`)
   * Database: `snake_case` (contoh: `user_id`)
3. **Commit Sering, Push Sering.** Commit setiap kali satu fungsi kecil berhasil.
4. **Baca Pesan Error.** Stack trace di PHP itu seperti peta harta karun. Ia memberitahu file mana dan baris ke berapa yang bermasalah.

---

Zaky, ini adalah **cetak biru (blueprint) perjalanan coding kamu** sejauh ini. Simpan dokumen ini baik-baik. 

Apakah format dan tingkat detail ini sudah sesuai dengan yang kamu bayangkan untuk manual book kamu? Jika sudah oke, kita bisa langsung gas ke tantangan berikutnya: **CRUD Transaksi & Dashboard Summary**! 🚀