<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2><i class="bi bi-plus-circle"></i> Tambah Kategori Baru</h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<div class="card shadow-sm mt-3">
    <div class="card-body">
        <form action="index.php?page=store-category" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Tipe Kategori</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="expense">Pengeluaran (Expense)</option>
                    <option value="income">Pemasukan (Income)</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php?page=categories" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>