<?php
// views/transactions/index.php
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-arrow-left-right"></i> Manajemen Transaksi</h2>
    <a href="index.php?page=create-transaction" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Transaksi</a>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php
        if ($_GET['success'] == 'created') echo "Transaksi berhasil ditambahkan!";
        elseif ($_GET['success'] == 'updated') echo "Transaksi berhasil diupdate!";
        elseif ($_GET['success'] == 'deleted') echo "Transaksi berhasil dihapus!";
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?php
        if ($_GET['error'] == 'notfound') echo "Transaksi tidak ditemukan!";
        elseif ($_GET['error'] == 'delete_failed') echo "Gagal menghapus transaksi!";
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <?php if (empty($transactions)): ?>
            <p class="text-center text-muted my-4">Belum ada transaksi. Yuk catat transaksi pertamamu! 💸</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
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
                                <td><?php echo formatTanggal($trx['date']); ?></td>
                                <td><?php echo htmlspecialchars($trx['category_name'] ?? 'Tanpa Kategori'); ?></td>
                                <td><?php echo htmlspecialchars($trx['description'] ?: '-'); ?></td>
                                <td>
                                    <?php if ($trx['type'] == 'income'): ?>
                                        <span class="text-success fw-bold">+ <?php echo formatRupiah($trx['amount']); ?></span>
                                    <?php else: ?>
                                        <span class="text-danger fw-bold">- <?php echo formatRupiah($trx['amount']); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="index.php?page=edit-transaction&id=<?php echo $trx['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                    <a href="index.php?page=delete-transaction&id=<?php echo $trx['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus transaksi ini?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>