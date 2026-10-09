<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'PFT'; ?> - Personal Finance Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php?page=dashboard"><i class="bi bi-wallet2"></i> PFT</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php?page=dashboard">Dashboard</a>
                <a class="nav-link" href="index.php?page=categories">Kategori</a>
                <a class="nav-link" href="index.php?page=transactions">Transaksi</a>
                <span class="nav-link text-white">Halo, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
                <a class="nav-link btn btn-outline-light ms-2 px-3" href="index.php?page=logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>
        </div>
    </nav>
    <main class="container mt-4"></main>