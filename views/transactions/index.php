<?php
// views/transactions/index.php
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="page-head">
    <h1 class="page-title"><i class="bi bi-arrow-left-right"></i> Manajemen Transaksi</h1>
    <a href="index.php?page=create-transaction" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Transaksi</a>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php
        if ($_GET['success'] == 'created') echo "Transaksi berhasil ditambahkan!";
        elseif ($_GET['success'] == 'updated') echo "Transaksi berhasil diupdate!";
        elseif ($_GET['success'] == 'deleted') echo "Transaksi berhasil dihapus!";
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?php
        if ($_GET['error'] == 'notfound') echo "Transaksi tidak ditemukan!";
        elseif ($_GET['error'] == 'delete_failed') echo "Gagal menghapus transaksi!";
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php endif; ?>

<div class="card">
    <?php if (empty($transactions)): ?>
        <div class="empty-state">
            <i class="bi bi-journal-plus"></i>
            <p>Belum ada transaksi. Yuk catat transaksi pertamamu! 💸</p>
            <a href="index.php?page=create-transaction" class="btn btn-primary">Catat transaksi pertama</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle table-pft">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $trx): ?>
                        <tr>
                            <td class="c-date"><?php echo formatTanggal($trx['date']); ?></td>
                            <td class="c-cat"><?php echo htmlspecialchars($trx['category_name'] ?? 'Tanpa Kategori'); ?></td>
                            <td class="c-desc<?php echo empty($trx['description']) ? ' is-empty' : ''; ?>"><?php echo htmlspecialchars($trx['description'] ?: '-'); ?></td>
                            <td class="c-amt num">
                                <?php if ($trx['type'] == 'income'): ?>
                                    <span class="text-income fw-bold">+ <?php echo formatRupiah($trx['amount']); ?></span>
                                <?php else: ?>
                                    <span class="text-expense fw-bold">- <?php echo formatRupiah($trx['amount']); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="c-act text-end">
                                <div class="row-actions">
                                    <a href="index.php?page=edit-transaction&id=<?php echo $trx['id']; ?>" class="btn-icon" title="Edit" aria-label="Edit transaksi"><i class="bi bi-pencil"></i></a>
                                    <a href="index.php?page=delete-transaction&id=<?php echo $trx['id']; ?>" class="btn-icon btn-icon-danger" title="Hapus" aria-label="Hapus transaksi" onclick="return confirm('Yakin ingin menghapus transaksi ini?')"><i class="bi bi-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>