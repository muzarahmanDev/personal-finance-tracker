<?php
// views/dashboard/index.php
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../layouts/header.php';
?>

<h1 class="page-title mb-3">Selamat datang, <?php echo htmlspecialchars($userName); ?>! 👋</h1>

<!-- ===== RINGKASAN (Blueprint 6.3) ===== -->
<section class="balance-hero" aria-label="Ringkasan keuangan">
    <div class="balance-main">
        <p class="balance-label">Saldo saat ini</p>
        <p class="balance-amount num"><?php echo formatRupiah($summary['balance']); ?></p>
    </div>
    <div class="balance-split">
        <div>
            <p class="split-label"><i class="bi bi-arrow-down-left"></i> Total pemasukan</p>
            <p class="split-amount in num"><?php echo formatRupiah($summary['income']); ?></p>
        </div>
        <div>
            <p class="split-label"><i class="bi bi-arrow-up-right"></i> Total pengeluaran</p>
            <p class="split-amount out num"><?php echo formatRupiah($summary['expense']); ?></p>
        </div>
    </div>
</section>

<div class="quick-actions">
    <a href="index.php?page=create-transaction" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Catat transaksi</a>
    <a href="index.php?page=categories" class="btn btn-outline-primary"><i class="bi bi-tags"></i> Kelola kategori</a>
</div>

<!-- ===== TRANSAKSI TERBARU ===== -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="h6 fw-bold mb-0"><i class="bi bi-clock-history"></i> Transaksi Terakhir</h2>
        <a href="index.php?page=transactions" class="small fw-semibold text-decoration-none">Lihat semua</a>
    </div>
    <?php if (empty($recentTransactions)): ?>
        <div class="empty-state">
            <i class="bi bi-journal-plus"></i>
            <p>Belum ada transaksi.</p>
            <a href="index.php?page=create-transaction" class="btn btn-primary">Catat transaksi pertama</a>
        </div>
    <?php else: ?>
        <ul class="list-unstyled mb-0">
            <?php foreach ($recentTransactions as $trx): ?>
                <?php $isIncome = ($trx['type'] == 'income'); ?>
                <li class="trx-item">
                    <span class="trx-icon <?php echo $isIncome ? 'income' : 'expense'; ?>">
                        <i class="bi <?php echo $isIncome ? 'bi-arrow-down-left' : 'bi-arrow-up-right'; ?>"></i>
                    </span>
                    <div class="trx-main">
                        <div class="trx-cat text-truncate"><?php echo htmlspecialchars($trx['category_name'] ?? 'Tanpa Kategori'); ?></div>
                        <div class="trx-meta text-truncate">
                            <?php echo formatTanggal($trx['date']); ?>
                            <?php echo !empty($trx['description']) ? '· ' . htmlspecialchars($trx['description']) : ''; ?>
                        </div>
                    </div>
                    <div class="trx-amt num <?php echo $isIncome ? 'text-income' : 'text-expense'; ?>">
                        <?php echo $isIncome ? '+' : '-'; ?> <?php echo formatRupiah($trx['amount']); ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>