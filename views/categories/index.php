<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="page-head">
    <h1 class="page-title"><i class="bi bi-tags"></i> Manajemen Kategori</h1>
    <a href="index.php?page=create-category" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Kategori</a>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php
        if($_GET['success'] == 'created') echo "Kategori berhasil ditambahkan!";
        elseif($_GET['success'] == 'updated') echo "Kategori berhasil diupdate!";
        elseif($_GET['success'] == 'deleted') echo "Kategori berhasil dihapus!";
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php endif; ?>

<div class="card">
    <?php if (empty($categories)): ?>
        <div class="empty-state">
            <i class="bi bi-tags"></i>
            <p>Belum ada kategori. Buat kategori dulu sebelum mencatat transaksi.</p>
            <a href="index.php?page=create-category" class="btn btn-primary">Tambah kategori pertama</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle table-pft">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Tipe</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td class="k-name"><?php echo htmlspecialchars($cat['name']); ?></td>
                            <td class="k-type">
                                <?php if($cat['type'] == 'income'): ?>
                                    <span class="badge badge-type badge-income">Pemasukan</span>
                                <?php else: ?>
                                    <span class="badge badge-type badge-expense">Pengeluaran</span>
                                <?php endif; ?>
                            </td>
                            <td class="k-act text-end">
                                <div class="row-actions">
                                    <a href="index.php?page=edit-category&id=<?php echo $cat['id']; ?>" class="btn-icon" title="Edit" aria-label="Edit kategori"><i class="bi bi-pencil"></i></a>
                                    <a href="index.php?page=delete-category&id=<?php echo $cat['id']; ?>" class="btn-icon btn-icon-danger" title="Hapus" aria-label="Hapus kategori" onclick="return confirm('Yakin ingin menghapus kategori ini? Transaksi terkait tidak akan terhapus.')"><i class="bi bi-trash"></i></a>
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