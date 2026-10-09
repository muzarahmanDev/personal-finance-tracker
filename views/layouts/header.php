<?php
// views/layouts/header.php
$currentPage = $_GET['page'] ?? 'dashboard';
$navActive = function (array $pages) use ($currentPage) {
    return in_array($currentPage, $pages, true) ? ' active' : '';
};
$navCurrent = function (array $pages) use ($currentPage) {
    return in_array($currentPage, $pages, true) ? ' aria-current="page"' : '';
};
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'PFT'; ?> - Personal Finance Tracker</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark navbar-pft sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php?page=dashboard"><i class="bi bi-wallet2"></i> PFT</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Buka menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto ms-lg-3 gap-lg-1">
                    <li class="nav-item">
                        <a class="nav-link<?php echo $navActive(['dashboard']); ?>"<?php echo $navCurrent(['dashboard']); ?> href="index.php?page=dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php echo $navActive(['categories', 'create-category', 'edit-category']); ?>"<?php echo $navCurrent(['categories', 'create-category', 'edit-category']); ?> href="index.php?page=categories">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php echo $navActive(['transactions', 'create-transaction', 'edit-transaction']); ?>"<?php echo $navCurrent(['transactions', 'create-transaction', 'edit-transaction']); ?> href="index.php?page=transactions">Transaksi</a>
                    </li>
                </ul>
                <div class="d-flex flex-column flex-lg-row align-items-lg-center gap-2 gap-lg-3 mt-3 mt-lg-0 pb-2 pb-lg-0">
                    <span class="nav-user"><i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    <a class="btn btn-sm btn-outline-light" href="index.php?page=logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>
    <main class="container py-4 flex-grow-1">