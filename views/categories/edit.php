<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="form-narrow">
    <div class="page-head">
        <h1 class="page-title"><i class="bi bi-pencil-square"></i> Edit Kategori</h1>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body p-3 p-md-4">
            <form action="index.php?page=update-category" method="POST">
                <input type="hidden" name="id" value="<?php echo $this->category->id ?? $_GET['id']; ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Kategori</label>
                    <!-- Gunakan htmlspecialchars untuk mencegah XSS -->
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($this->category->name); ?>" required>
                </div>
                <div class="mb-4">
                    <label for="type" class="form-label">Tipe Kategori</label>
                    <select class="form-select" id="type" name="type" required>
                        <option value="expense" <?php echo ($this->category->type == 'expense') ? 'selected' : ''; ?>>Pengeluaran</option>
                        <option value="income" <?php echo ($this->category->type == 'income') ? 'selected' : ''; ?>>Pemasukan</option>
                    </select>
                </div>
                <div class="d-grid gap-2 d-sm-flex">
                    <button type="submit" class="btn btn-primary px-4">Simpan perubahan</button>
                    <a href="index.php?page=categories" class="btn btn-outline-secondary px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>