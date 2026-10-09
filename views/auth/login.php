<?php
// views/auth/login.php
$pageTitle = "Login";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Personal Finance Tracker</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="auth-wrap">
        <div class="auth-brand">
            <div class="auth-logo"><i class="bi bi-wallet2"></i></div>
            <h1>Personal Finance Tracker</h1>
            <p>Catat pemasukan dan pengeluaranmu.</p>
        </div>

        <div class="card auth-card">
            <div class="card-body">
                <h2 class="auth-title">Login</h2>

                <!-- Tampilkan pesan sukses setelah register -->
                <?php if (isset($_GET['success']) && $_GET['success'] === 'registered'): ?>
                    <div class="alert alert-success" role="alert">
                        Registrasi berhasil! Silakan login.
                    </div>
                <?php endif; ?>

                <!-- Tampilkan Error jika ada -->
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <!-- Form Login -->
                <form action="index.php?page=authenticate" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" autocomplete="email" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" autocomplete="current-password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-0 text-muted">Belum punya akun? <a href="index.php?page=register" class="fw-semibold">Daftar di sini</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>