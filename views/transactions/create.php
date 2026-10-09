<?php
// views/transactions/create.php
require_once __DIR__ . '/../layouts/header.php';
?>

<h2><i class="bi bi-plus-circle"></i> Tambah Transaksi</h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="card shadow-sm mt-3">
    <div class="card-body">
        <form action="index.php?page=store-transaction" method="POST">
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    <optgroup label="Pemasukan">
                        <?php foreach ($categories as $cat): ?>
                            <?php if ($cat['type'] == 'income'): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php echo (isset($_POST['category_id']) && $cat['id'] == $_POST['category_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="Pengeluaran">
                        <?php foreach ($categories as $cat): ?>
                            <?php if ($cat['type'] == 'expense'): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php echo (isset($_POST['category_id']) && $cat['id'] == $_POST['category_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </optgroup>
                </select>
                <div class="form-text">Tipe transaksi otomatis mengikuti kategori yang dipilih.</div>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Jumlah (Rp)</label>
                <!-- Repopulate: jika error, input user tidak hilang -->
                <input type="number" class="form-control" id="amount" name="amount" min="1" step="1"
                       value="<?php echo htmlspecialchars($_POST['amount'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="date" name="date"
                       value="<?php echo htmlspecialchars($_POST['date'] ?? date('Y-m-d')); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi (opsional)</label>
                <textarea class="form-control" id="description" name="description" rows="2"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php?page=transactions" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>