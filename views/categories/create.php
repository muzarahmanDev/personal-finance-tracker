<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="form-narrow">
    <div class="page-head">
        <h1 class="page-title"><i class="bi bi-plus-circle"></i> Tambah Kategori Baru</h1>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body p-3 p-md-4">
            <form action="index.php?page=store-category" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-4">
                    <label for="type" class="form-label">Tipe Kategori</label>
                    <select class="form-select" id="type" name="type" required>
                        <option value="expense">Pengeluaran (Expense)</option>
                        <option value="income">Pemasukan (Income)</option>
                    </select>
                </div>
                <div class="d-grid gap-2 d-sm-flex">
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                    <a href="index.php?page=categories" class="btn btn-outline-secondary px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>