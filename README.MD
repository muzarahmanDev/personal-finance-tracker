# 📋 PERSONAL FINANCE TRACKER
## Project Blueprint & Technical Specification

**Version:** 1.0.0  
**Author:** Muhammad Zaky Rahman  
**Created:** September 2026  
**Status:** Planning Phase

---

## 📑 DAFTAR ISI

1. [Project Overview](#1-project-overview)
2. [Technical Stack](#2-technical-stack)
3. [System Architecture](#3-system-architecture)
4. [Database Design](#4-database-design)
5. [Backend Specification](#5-backend-specification)
6. [Frontend Specification](#6-frontend-specification)
7. [Security Guidelines](#7-security-guidelines)
8. [Development Workflow](#8-development-workflow)
9. [File Structure](#9-file-structure)
10. [Development Roadmap](#10-development-roadmap)
11. [Testing Strategy](#11-testing-strategy)
12. [Deployment Guide](#12-deployment-guide)

---

## 1. PROJECT OVERVIEW

### 1.1 Deskripsi Proyek
**Personal Finance Tracker (PFT)** adalah aplikasi web berbasis PHP Native yang memungkinkan pengguna untuk mencatat, memantau, dan mengelola keuangan pribadi secara digital. Aplikasi ini dirancang untuk memberikan kemudahan dalam tracking pemasukan dan pengeluaran harian.

### 1.2 Tujuan Proyek
- **Educational Purpose:** Memahami fundamental web development (PHP, MySQL, MVC pattern)
- **Portfolio Building:** Membangun proyek fungsional untuk portofolio GitHub
- **Problem Solving:** Memberikan solusi sederhana untuk manajemen keuangan pribadi

### 1.3 Target Pengguna
- Individu yang ingin mencatat keuangan pribadi
- Mahasiswa yang ingin mengelola uang saku
- Profesional muda yang ingin tracking pengeluaran

### 1.4 Fitur Utama (MVP - Minimum Viable Product)

| ID Fitur | Nama Fitur | Prioritas | Status |
|----------|------------|-----------|--------|
| F-01 | User Registration | High | Planned |
| F-02 | User Login & Authentication | High | Planned |
| F-03 | Dashboard Ringkasan Keuangan | High | Planned |
| F-04 | CRUD Transaksi (Pemasukan/Pengeluaran) | High | Planned |
| F-05 | Manajemen Kategori | Medium | Planned |
| F-06 | Filter & Search Transaksi | Medium | Planned |
| F-07 | Export Data (Opsional) | Low | Backlog |

---

## 2. TECHNICAL STACK

### 2.1 Backend
- **Language:** PHP 8.3.30 atau lebih tinggi
- **Paradigm:** Native PHP (Vanilla) - **NO Framework**
- **Architecture:** MVC (Model-View-Controller) Pattern
- **Database Driver:** PDO (PHP Data Objects) - MySQL

**Alasan Pemilihan:**
- Memahami fundamental tanpa "magic" framework
- Kontrol penuh atas setiap baris kode
- Pembelajaran mendalam tentang HTTP, Session, dan Database

### 2.2 Database
- **DBMS:** MySQL 5.7+ / MariaDB 10.3+
- **Management Tool:** phpMyAdmin / MySQL Workbench
- **Character Set:** utf8mb4_unicode_ci

### 2.3 Frontend
- **HTML5:** Semantic HTML
- **CSS Framework:** Bootstrap 5.3 (CDN)
- **JavaScript:** Vanilla JavaScript (ES6+)
- **Icons:** Bootstrap Icons / FontAwesome (CDN)
- **Charts (Opsional):** Chart.js (CDN)

### 2.4 Development Tools
- **Local Server:** XAMPP / Laragon / WAMP
- **Code Editor:** VS Code (Recommended) / Sublime Text / PhpStorm
- **Version Control:** Git & GitHub
- **Browser:** Google Chrome (DevTools)
- **API Testing:** Postman (Opsional)

### 2.5 Database Connection
```php
// Method: PDO (PHP Data Objects)
// Alasan: 
// - Support prepared statements (anti SQL Injection)
// - Support multiple database
// - Error handling yang lebih baik
// - Object-oriented approach
```

---

## 3. SYSTEM ARCHITECTURE

### 3.1 Architecture Pattern: MVC (Model-View-Controller)

```
┌─────────────────────────────────────────────────────────┐
│                      CLIENT (Browser)                    │
│                    (HTML/CSS/JavaScript)                 │
└────────────────────┬────────────────────────────────────┘
                     │ HTTP Request/Response
                     ▼
─────────────────────────────────────────────────────────┐
│                   PRESENTATION LAYER                     │
│                    (Views - PHP/HTML)                    │
│          login.php, dashboard.php, transactions.php      │
└────────────────────┬────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────┐
│                  APPLICATION LAYER                       │
│            (Controllers - Business Logic)                │
│    AuthController, TransactionController, etc.           │
└────────────────────┬────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────┐
│                     DATA LAYER                           │
│              (Models - Database Access)                  │
│         UserModel, TransactionModel, CategoryModel       │
└────────────────────┬────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────┐
│                    DATABASE (MySQL)                      │
│         users, transactions, categories tables           │
─────────────────────────────────────────────────────────┘
```

### 3.2 Request Flow Example

```
1. User akses: /transactions/create
2. Router → TransactionController@create()
3. Controller → CategoryModel->getAll() (ambil kategori)
4. Controller → load view: transactions/create.php
5. View → Render HTML dengan data kategori
6. Browser → Tampilkan form ke user
```

---

## 4. DATABASE DESIGN

### 4.1 Entity Relationship Diagram (ERD)

```
┌─────────────────────────┐
│         users           │
├─────────────────────────┤
│ id (PK, AI)             │
│ name (VARCHAR 100)      │
│ email (VARCHAR 150)     │◄─── UNIQUE
│ password (VARCHAR 255)  │
│ created_at (TIMESTAMP)  │
│ updated_at (TIMESTAMP)  │
└───────────┬─────────────┘
            │
            │ 1:N
            │
            ▼
┌─────────────────────────┐      ┌─────────────────────────┐
│     transactions        │      │      categories         │
├─────────────────────────┤      ├─────────────────────────┤
│ id (PK, AI)             │      │ id (PK, AI)             │
│ user_id (FK)            │      │ user_id (FK)            │
│ category_id (FK)        │◄─────┤ name (VARCHAR 50)       │
│ type (ENUM)             │      │ type (ENUM)             │
│ amount (DECIMAL 10,2)   │      │ created_at (TIMESTAMP)  │
│ description (TEXT)      │      │ updated_at (TIMESTAMP)  │
│ date (DATE)             │      └─────────────────────────┘
│ created_at (TIMESTAMP)  │
│ updated_at (TIMESTAMP)  │
└─────────────────────────┘
```

### 4.2 Table Specifications

#### **Table: users**
```sql
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Field Descriptions:**
- `id`: Primary key, auto increment
- `name`: Nama lengkap user
- `email`: Email unik untuk login
- `password`: Hashed password (bcrypt)
- `created_at`: Waktu registrasi
- `updated_at`: Waktu update terakhir

#### **Table: categories**
```sql
CREATE TABLE categories (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    name VARCHAR(50) NOT NULL,
    type ENUM('income', 'expense') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_type (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Field Descriptions:**
- `user_id`: Foreign key ke users (relasi one-to-many)
- `name`: Nama kategori (misal: "Makan", "Gaji")
- `type`: Tipe kategori (income/expense)
- `ON DELETE CASCADE`: Jika user dihapus, kategori ikut terhapus

#### **Table: transactions**
```sql
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
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT,
    INDEX idx_user_id (user_id),
    INDEX idx_date (date),
    INDEX idx_type (type),
    INDEX idx_category_id (category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Field Descriptions:**
- `amount`: Nominal uang (DECIMAL untuk presisi)
- `description`: Catatan transaksi (optional)
- `date`: Tanggal transaksi
- `ON DELETE RESTRICT`: Kategori tidak bisa dihapus jika ada transaksi

### 4.3 Default Data (Seeders)

```sql
-- Insert default categories untuk testing
INSERT INTO categories (user_id, name, type) VALUES
(1, 'Gaji', 'income'),
(1, 'Bonus', 'income'),
(1, 'Makan', 'expense'),
(1, 'Transport', 'expense'),
(1, 'Belanja', 'expense'),
(1, 'Hiburan', 'expense'),
(1, 'Kesehatan', 'expense');
```

---

## 5. BACKEND SPECIFICATION

### 5.1 Directory Structure (Backend)

```
backend/
├── config/
│   ├── database.php          # Database connection (PDO)
│   └── config.php            # Global configuration
├── controllers/
│   ├── AuthController.php    # Login, Register, Logout
│   ├── DashboardController.php
│   ├── TransactionController.php
│   ── CategoryController.php
├── models/
│   ├── User.php
│   ├── Transaction.php
│   └── Category.php
├── middleware/
│   └── Auth.php              # Authentication middleware
├── includes/
│   ├── functions.php         # Helper functions
│   ├── session.php           # Session management
│   └── validation.php        # Input validation
└── public/
    └── index.php             # Entry point (Front Controller)
```

### 5.2 Database Connection Pattern

**File: `config/database.php`**
```php
<?php
class Database {
    private $host = "localhost";
    private $db_name = "pft_db";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->exec("set names utf8mb4");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
```

**Best Practices:**
- Gunakan **PDO** bukan MySQLi
- Set error mode ke **ERRMODE_EXCEPTION**
- Gunakan **prepared statements** untuk semua query
- Set charset ke **utf8mb4**

### 5.3 Model Pattern (Example)

**File: `models/User.php`**
```php
<?php
class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new user
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET name=:name, email=:email, password=:password";

        $stmt = $this->conn->prepare($query);

        // Sanitize & hash
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $password_hash);

        return $stmt->execute();
    }

    // Check if email exists
    public function emailExists() {
        $query = "SELECT id, password FROM " . $this->table . " 
                  WHERE email = :email LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // Login
    public function login() {
        if($this->emailExists()) {
            $query = "SELECT id, password FROM " . $this->table . " 
                      WHERE email = :email LIMIT 1";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $this->email);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(password_verify($this->password, $row['password'])) {
                $this->id = $row['id'];
                return true;
            }
        }
        return false;
    }
}
?>
```

### 5.4 Controller Pattern (Example)

**File: `controllers/AuthController.php`**
```php
<?php
require_once 'config/database.php';
require_once 'models/User.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    // Show register form
    public function register() {
        include 'views/auth/register.php';
    }

    // Process registration
    public function store() {
        // Validate input
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->name = $_POST['name'];
            $this->user->email = $_POST['email'];
            $this->user->password = $_POST['password'];

            // Validation
            if(empty($this->user->name) || empty($this->user->email) || empty($this->user->password)) {
                $error = "All fields are required";
                include 'views/auth/register.php';
                return;
            }

            if($this->user->create()) {
                // Success - redirect to login
                header("Location: index.php?page=login&status=success");
            } else {
                $error = "Registration failed";
                include 'views/auth/register.php';
            }
        }
    }

    // Show login form
    public function login() {
        include 'views/auth/login.php';
    }

    // Process login
    public function authenticate() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->email = $_POST['email'];
            $this->user->password = $_POST['password'];

            if($this->user->login()) {
                // Set session
                $_SESSION['user_id'] = $this->user->id;
                $_SESSION['user_name'] = $this->user->name;
                $_SESSION['user_email'] = $this->user->email;

                header("Location: index.php?page=dashboard");
            } else {
                $error = "Invalid credentials";
                include 'views/auth/login.php';
            }
        }
    }

    // Logout
    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
    }
}
?>
```

### 5.5 Middleware Pattern

**File: `middleware/Auth.php`**
```php
<?php
function requireLogin() {
    if(!isset($_SESSION['user_id'])) {
        header("Location: index.php?page=login&message=Please login first");
        exit();
    }
}

function requireGuest() {
    if(isset($_SESSION['user_id'])) {
        header("Location: index.php?page=dashboard");
        exit();
    }
}
?>
```

### 5.6 Routing (Simple Front Controller)

**File: `public/index.php`**
```php
<?php
session_start();
require_once '../middleware/Auth.php';

// Simple routing
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch($page) {
    // Auth routes
    case 'register':
        require_once '../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;

    case 'store-register':
        require_once '../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->store();
        break;

    case 'login':
        require_once '../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;

    case 'authenticate':
        require_once '../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->authenticate();
        break;

    case 'logout':
        require_once '../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;

    // Protected routes
    case 'dashboard':
        requireLogin();
        require_once '../controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->index();
        break;

    case 'transactions':
        requireLogin();
        require_once '../controllers/TransactionController.php';
        $controller = new TransactionController();
        $controller->index();
        break;

    default:
        include 'views/home.php';
        break;
}
?>
```

---

## 6. FRONTEND SPECIFICATION

### 6.1 Design Principles
- **Responsive Design:** Mobile-first approach dengan Bootstrap 5
- **Consistency:** Gunakan komponen Bootstrap yang konsisten
- **Accessibility:** Semantic HTML, proper labels, ARIA attributes
- **Performance:** Minimize HTTP requests, lazy loading untuk gambar

### 6.2 Layout Structure

**File: `views/layouts/header.php`**
```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Finance Tracker - <?php echo $pageTitle ?? 'Home'; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php?page=dashboard">
                <i class="bi bi-wallet2"></i> PFT
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=dashboard">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=transactions">
                                <i class="bi bi-arrow-left-right"></i> Transaksi
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> <?php echo $_SESSION['user_name']; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="index.php?page=profile">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="index.php?page=logout">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=register">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mt-4">
```

**File: `views/layouts/footer.php`**
```php
    </main>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="container p-4">
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                © 2026 Personal Finance Tracker - Muhammad Zaky Rahman
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="public/js/script.js"></script>
</body>
</html>
```

### 6.3 Component Examples

**Dashboard Card Component:**
```php
<!-- views/dashboard/_card.php -->
<div class="col-md-4">
    <div class="card <?php echo $cardClass; ?> text-white mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="card-title"><?php echo $title; ?></h6>
                    <h3><?php echo $amount; ?></h3>
                </div>
                <i class="bi <?php echo $icon; ?> display-4"></i>
            </div>
        </div>
    </div>
</div>
```

### 6.4 JavaScript Guidelines

**File: `public/js/script.js`**
```javascript
// Confirmation before delete
function confirmDelete(message = 'Are you sure you want to delete this item?') {
    return confirm(message);
}

// Format currency (IDR)
function formatRupiah(angka) {
    const formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    });
    return formatter.format(angka);
}

// Auto-hide alert after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('input[required]');
    let isValid = true;

    inputs.forEach(input => {
        if(!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });

    return isValid;
}
```

---

## 7. SECURITY GUIDELINES

### 7.1 Password Security
✅ **DO:**
- Gunakan `password_hash()` dengan `PASSWORD_DEFAULT` (bcrypt)
- Gunakan `password_verify()` untuk login
- Minimum password: 8 karakter

❌ **DON'T:**
- Jangan simpan password plain text
- Jangan kirim password via GET method
- Jangan log password

**Implementation:**
```php
// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Verify password
if(password_verify($inputPassword, $hashedPassword)) {
    // Login success
}
```

### 7.2 SQL Injection Prevention
✅ **DO:**
- Selalu gunakan **Prepared Statements** (PDO)
- Bind semua parameter
- Validate dan sanitize input

❌ **DON'T:**
- Jangan concat user input langsung ke query

**Implementation:**
```php
// ✅ CORRECT
$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindParam(":email", $email);
$stmt->execute();

// ❌ WRONG - VULNERABLE
$query = "SELECT * FROM users WHERE email = '" . $_POST['email'] . "'";
```

### 7.3 XSS (Cross-Site Scripting) Prevention
✅ **DO:**
- Sanitize output dengan `htmlspecialchars()`
- Validate input
- Set Content Security Policy (CSP)

**Implementation:**
```php
// Escape output
echo htmlspecialchars($userInput, ENT_QUOTES, 'UTF-8');

// In views
<h1><?php echo htmlspecialchars($pageTitle); ?></h1>
```

### 7.4 Session Security
✅ **DO:**
- Regenerate session ID setelah login
- Set session timeout
- Use HTTPS (production)

**Implementation:**
```php
// After successful login
session_regenerate_id(true);
$_SESSION['user_id'] = $userId;
$_SESSION['last_activity'] = time();

// Check session timeout
if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_unset();
    session_destroy();
    header("Location: login.php?timeout=1");
}
```

### 7.5 CSRF Protection (Optional - Advanced)
```php
// Generate token
if(empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// In form
<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

// Validate token
if(!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    die("CSRF token validation failed");
}
```

---

## 8. DEVELOPMENT WORKFLOW

### 8.1 Git Workflow

**Branch Strategy:**
```
main (production-ready)
├── develop (integration branch)
│   ├── feature/auth-login
│   ├── feature/transaction-crud
│   └── bugfix/fix-validation
```

**Commit Message Convention:**
```
feat: add user registration feature
fix: correct validation error message
docs: update README with installation guide
style: format code according to PSR-12
refactor: simplify database connection logic
test: add unit test for User model
```

**Commit Checklist:**
- [ ] Code sudah berfungsi
- [ ] Tidak ada hard-coded values
- [ ] Sudah testing manual
- [ ] Commit message deskriptif
- [ ] Tidak ada file sensitive (.env, config dengan password)

### 8.2 Development Steps

**Step 1: Setup Environment**
1. Install XAMPP/Laragon
2. Clone repository
3. Buat database
4. Import SQL file
5. Konfigurasi `config/database.php`
6. Test akses localhost

**Step 2: Development Cycle**
```
1. Buat branch baru: git checkout -b feature/feature-name
2. Code development
3. Test di browser
4. Commit: git commit -m "feat: description"
5. Push: git push origin feature/feature-name
6. Create Pull Request (jika pakai GitHub)
7. Merge ke develop/main
```

**Step 3: Testing**
- Functional testing (manual)
- Browser compatibility (Chrome, Firefox)
- Responsive testing (mobile, tablet, desktop)
- Security testing (SQL injection, XSS)

### 8.3 Debugging Tools

**Browser DevTools:**
- Console: Lihat JavaScript errors
- Network: Monitor HTTP requests
- Elements: Inspect HTML/CSS

**PHP Debugging:**
```php
// Simple debugging
var_dump($variable);
die();

// Error reporting (development only)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log errors (production)
error_log("Error message: " . $error);
```

---

## 9. FILE STRUCTURE

```
personal-finance-tracker/
│
├── config/
│   ├── database.php              # PDO connection
│   └── config.php                # Global settings
│
├── controllers/
│   ├── AuthController.php        # Register, Login, Logout
│   ├── DashboardController.php   # Dashboard logic
│   ├── TransactionController.php # CRUD transactions
│   └── CategoryController.php    # CRUD categories
│
├── models/
│   ├── User.php                  # User model
│   ├── Transaction.php           # Transaction model
│   └── Category.php              # Category model
│
├── middleware/
│   └── Auth.php                  # Authentication check
│
├── includes/
│   ├── functions.php             # Helper functions
│   ├── session.php               # Session handler
│   └── validation.php            # Input validation
│
├── views/
│   ├── layouts/
│   │   ├── header.php
│   │   └── footer.php
│   │
│   ├── auth/
│   │   ├── login.php
│   │   └── register.php
│   │
│   ├── dashboard/
│   │   ── index.php
│   │
│   ├── transactions/
│   │   ├── index.php             # List transactions
│   │   ├── create.php            # Add transaction
│   │   ├── edit.php              # Edit transaction
│   │   └── show.php              # Detail transaction
│   │
│   ── categories/
│       └── index.php
│
├── public/
│   ├── css/
│   │   └── style.css             # Custom CSS
│   ├── js/
│   │   └── script.js             # Custom JavaScript
│   ├── images/
│   │   └── (assets)
│   └── index.php                 # Entry point (Front Controller)
│
├── .gitignore
├── README.md
├── LICENSE
├── database.sql                  # Database schema
└── composer.json                 # (Optional - untuk dependencies)
```

---

## 10. DEVELOPMENT ROADMAP

### Phase 1: Foundation (Week 1-2)
**Goal:** Setup environment dan autentikasi dasar

| Task | Priority | Estimated Time | Status |
|------|----------|----------------|--------|
| Setup XAMPP & database | High | 2 hours |  |
| Create database schema | High | 3 hours | ⬜ |
| Setup folder structure | High | 1 hour |  |
| Database connection (PDO) | High | 2 hours | ⬜ |
| User registration | High | 6 hours |  |
| User login & session | High | 6 hours | ⬜ |
| Logout functionality | High | 2 hours |  |

**Deliverables:**
- ✅ User bisa register
- ✅ User bisa login
- ✅ Session management berfungsi
- ✅ Protected routes (redirect jika belum login)

### Phase 2: Core Features (Week 3-4)
**Goal:** CRUD transaksi dan kategori

| Task | Priority | Estimated Time | Status |
|------|----------|----------------|--------|
| Category CRUD | High | 8 hours |  |
| Transaction create | High | 6 hours | ⬜ |
| Transaction read (list) | High | 6 hours |  |
| Transaction update | High | 6 hours | ⬜ |
| Transaction delete | High | 4 hours | ⬜ |
| Filter by date/category | Medium | 6 hours | ⬜ |

**Deliverables:**
- ✅ User bisa manage kategori
- ✅ User bisa CRUD transaksi
- ✅ Filter dan search berfungsi

### Phase 3: Dashboard & UI (Week 5)
**Goal:** Dashboard dan visualisasi data

| Task | Priority | Estimated Time | Status |
|------|----------|----------------|--------|
| Dashboard layout | High | 4 hours | ⬜ |
| Calculate total income/expense | High | 4 hours | ⬜ |
| Display summary cards | High | 4 hours |  |
| Recent transactions list | High | 4 hours | ⬜ |
| Chart visualization (optional) | Low | 6 hours | ⬜ |
| Responsive design | High | 6 hours | ⬜ |

**Deliverables:**
- ✅ Dashboard dengan ringkasan
- ✅ Visualisasi data
- ✅ Mobile responsive

### Phase 4: Polish & Deploy (Week 6)
**Goal:** Testing, documentation, deployment

| Task | Priority | Estimated Time | Status |
|------|----------|----------------|--------|
| Input validation | High | 6 hours | ⬜ |
| Error handling | High | 4 hours |  |
| Security audit | High | 4 hours | ⬜ |
| Bug fixing | High | 8 hours |  |
| README documentation | High | 4 hours | ⬜ |
| Deployment (optional) | Medium | 6 hours | ⬜ |

**Deliverables:**
- ✅ Aplikasi stabil dan aman
- ✅ Dokumentasi lengkap
- ✅ Siap deploy

---

## 11. TESTING STRATEGY

### 11.1 Manual Testing Checklist

**Authentication:**
- [ ] Register dengan data valid → berhasil
- [ ] Register dengan email sudah ada → error
- [ ] Register dengan password < 8 char → error
- [ ] Login dengan credentials benar → masuk dashboard
- [ ] Login dengan credentials salah → error
- [ ] Logout → kembali ke login
- [ ] Akses halaman protected tanpa login → redirect

**Transactions:**
- [ ] Create transaction dengan data lengkap → berhasil
- [ ] Create transaction tanpa kategori → error
- [ ] Read transactions → tampil semua data user
- [ ] Update transaction → data berubah
- [ ] Delete transaction → data hilang
- [ ] Filter by date → hanya tampil sesuai filter
- [ ] Pagination → navigasi halaman berfungsi

**Security:**
- [ ] SQL Injection attempt → ditolak
- [ ] XSS attempt → sanitized
- [ ] Access another user's data → forbidden
- [ ] Session hijacking → prevented

### 11.2 Test Cases Example

**Test Case: User Registration**
```
Test ID: TC-AUTH-001
Feature: User Registration
Precondition: User belum terdaftar

Steps:
1. Buka halaman register
2. Isi name: "Test User"
3. Isi email: "test@example.com"
4. Isi password: "password123"
5. Klik tombol "Register"

Expected Result:
- User berhasil dibuat
- Redirect ke halaman login
- Pesan sukses ditampilkan

Actual Result: [Fill after testing]
Status: Pass/Fail
```

---

## 12. DEPLOYMENT GUIDE

### 12.1 Preparation
**Requirements:**
- Web hosting dengan PHP 7.4+ dan MySQL
- FTP client (FileZilla)
- Database access (cPanel/phpMyAdmin)

### 12.2 Deployment Steps

**Step 1: Upload Files**
```bash
1. Compress project folder ke ZIP
2. Upload ke hosting via FTP/cPanel
3. Extract di server
```

**Step 2: Database Setup**
```bash
1. Buat database baru di cPanel
2. Buat user database dengan password
3. Import file database.sql
4. Update config/database.php dengan credentials hosting
```

**Step 3: Configuration**
```php
// config/database.php
private $host = "localhost";
private $db_name = "your_database_name";
private $username = "your_database_user";
private $password = "your_strong_password";
```

**Step 4: Set Permissions**
```bash
chmod 755 config/
chmod 755 public/
chmod 644 config/database.php
```

**Step 5: Test**
```
1. Akses domain.com
2. Test register dan login
3. Test semua fitur
4. Check error logs
```

### 12.3 Post-Deployment Checklist
- [ ] HTTPS enabled (SSL certificate)
- [ ] Display errors OFF (production)
- [ ] Database backup configured
- [ ] Strong passwords set
- [ ] .git directory removed
- [ ] robots.txt configured

---

## 📎 APPENDIX

### A. Useful Resources
- **PHP Documentation:** https://www.php.net/docs.php
- **PDO Tutorial:** https://php.net/manual/en/book.pdo.php
- **Bootstrap 5:** https://getbootstrap.com/docs/5.3/
- **MySQL Documentation:** https://dev.mysql.com/doc/
- **Git Documentation:** https://git-scm.com/doc

### B. Common Errors & Solutions

| Error | Cause | Solution |
|-------|-------|----------|
| "SQLSTATE[HY000] [1045]" | Wrong database credentials | Check config/database.php |
| "Undefined index" | Accessing non-existent array key | Use isset() or null coalescing |
| "Headers already sent" | Output before header() | Check for whitespace before <?php |
| "PDOException" | Database connection failed | Check if MySQL is running |

### C. Code Standards (PSR-12)
- Indentation: 4 spaces (no tabs)
- Class names: PascalCase (e.g., `UserController`)
- Method names: camelCase (e.g., `getUserData`)
- Variable names: camelCase (e.g., `$userName`)
- File names: PascalCase for classes, lowercase for views
- Line length: Max 120 characters

---

**Document Version:** 1.0.0  
**Last Updated:** September 2026  
**Author:** Muhammad Zaky Rahman  
**Status:** Approved for Development

---

## 📝 CHANGELOG

**v1.0.0 - September 12, 2026**
- Initial document creation
- Complete technical specification
- Database design finalized
- Development roadmap defined

---

*This document serves as the single source of truth for the Personal Finance Tracker project. Any changes must be documented in the changelog.*