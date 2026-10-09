<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2><i class="bi bi-pencil-square"></i> Edit Kategori</h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<div class="card shadow-sm mt-3">
    <div class="card-body">
        <form action="index.php?page=update-category" method="POST">
            <input type="hidden" name="id" value="<?php echo $this->category->id ?? $_GET['id']; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kategori</label>
                <!-- Gunakan htmlspecialchars untuk mencegah XSS -->
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($this->category->name); ?>" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Tipe Kategori</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="expense" <?php echo ($this->category->type == 'expense') ? 'selected' : ''; ?>>Pengeluaran</option>
                    <option value="income" <?php echo ($this->category->type == 'income') ? 'selected' : ''; ?>>Pemasukan</option>
                </select>
            </div>
            <button type="submit" class="btn btn-warning">Update</button>
            <a href="index.php?page=categories" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>