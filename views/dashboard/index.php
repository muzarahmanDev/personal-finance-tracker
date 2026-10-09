<?php
// views/dashboard/index.php
// View ini sekarang menggunakan Layout bersama (header & footer)
// Sesuai prinsip DRY: Navbar & Footer tidak ditulis ulang di sini
?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-5 text-center">
                <i class="bi bi-speedometer2 display-1 text-primary mb-3"></i>
                <h2 class="card-title">Selamat Datang, <?php echo htmlspecialchars($userName); ?>! 👋</h2>
                <p class="text-muted">Kelola keuanganmu mulai dari sini.</p>
                <div class="mt-4">
                    <a href="index.php?page=categories" class="btn btn-outline-primary me-2">
                        <i class="bi bi-tags"></i> Kelola Kategori
                    </a>
                    <a href="index.php?page=transactions" class="btn btn-primary">
                        <i class="bi bi-arrow-left-right"></i> Kelola Transaksi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>