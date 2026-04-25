<div class="d-flex align-items-center mb-3 gap-2">
    <a href="<?= base_url('category') ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left"></i></a>
    <h5 class="fw-bold mb-0"><?= $category ? 'Edit Category' : 'Add Category' ?></h5>
</div>
<div class="card" style="max-width:520px">
    <div class="card-body p-4">
        <?= form_open($category ? 'category/edit/' . $category->id : 'category/add') ?>
        <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

        <div class="mb-3">
            <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
            <input type="text" name="category_name" class="form-control"
                value="<?= set_value('category_name', $category ? $category->category_name : '') ?>" required>
            <?php if (form_error('category_name')): ?>
                <div class="text-danger small mt-1"><?= form_error('category_name') ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Status</label>
            <select name="category_status" class="form-select">
                <option value="active" <?= ($category && $category->category_status === 'active') ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= ($category && $category->category_status === 'inactive') ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i><?= $category ? 'Update' : 'Save' ?></button>
            <a href="<?= base_url('category') ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
        <?= form_close() ?>
    </div>
</div>
