<?php
// views/dashboard/index.php
// Pastikan $pageTitle dan $userName sudah dikirim dari Controller
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - PFT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php?page=dashboard">
                <i class="bi bi-wallet2"></i> PFT
            </a>
            <div class="navbar-nav ms-auto">
                <span class="nav-link text-white">Halo, <?php echo htmlspecialchars($userName); ?>! 👋</span>
                <a class="nav-link btn btn-outline-light ms-2 px-3" href="index.php?page=logout">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5 text-center">
                        <i class="bi bi-speedometer2 display-1 text-primary mb-3"></i>
                        <h2 class="card-title">Selamat Datang di Dashboard!</h2>
                        <p class="text-muted">Ini adalah halaman utama aplikasi Personal Finance Tracker kamu.</p>
                        <p class="text-muted">Fitur CRUD Transaksi dan Kategori akan segera hadir di sini.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>