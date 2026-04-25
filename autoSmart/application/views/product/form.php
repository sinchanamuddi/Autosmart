<div class="d-flex align-items-center mb-3 gap-2">
    <a href="<?= base_url('product') ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left"></i></a>
    <h5 class="fw-bold mb-0"><?= $product ? 'Edit Product' : 'Add Product' ?></h5>
</div>
<div class="card">
    <div class="card-body p-4">
        <?= form_open($product ? 'product/edit/' . $product->id : 'product/add') ?>
        <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                <input type="text" name="product_name" class="form-control"
                    value="<?= set_value('product_name', $product ? $product->product_name : '') ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">HSN Code <span class="text-danger">*</span></label>
                <input type="text" name="HSN_code" class="form-control"
                    value="<?= set_value('HSN_code', $product ? $product->HSN_code : '') ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Select --</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= $c->id ?>" <?= ($product && $product->category_id == $c->id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c->category_name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Supplier <span class="text-danger">*</span></label>
                <select name="supplier_id" class="form-select" required>
                    <option value="">-- Select --</option>
                    <?php foreach ($suppliers as $s): ?>
                        <option value="<?= $s->id ?>" <?= ($product && $product->supplier_id == $s->id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($s->firm_name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Unit (UOM) <span class="text-danger">*</span></label>
                <select name="uom_id" class="form-select" required>
                    <option value="">-- Select --</option>
                    <?php foreach ($uoms as $u): ?>
                        <option value="<?= $u->id ?>" <?= ($product && $product->uom_id == $u->id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($u->uom_name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Unit Conversion</label>
                <input type="number" name="unit_conversion" class="form-control" min="1"
                    value="<?= set_value('unit_conversion', $product ? $product->unit_conversion : 1) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Min Stock Qty <span class="text-danger">*</span></label>
                <input type="number" name="min_stock_quantity" class="form-control" min="0"
                    value="<?= set_value('min_stock_quantity', $product ? $product->min_stock_quantity : '') ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Tax Status</label>
                <select name="tax_status" class="form-select" id="taxStatus" onchange="toggleTax(this.value)">
                    <option value="taxable" <?= ($product && $product->tax_status === 'taxable') ? 'selected' : '' ?>>Taxable</option>
                    <option value="non-taxable" <?= ($product && $product->tax_status === 'non-taxable') ? 'selected' : '' ?>>Non-Taxable</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="product_status" class="form-select">
                    <option value="active" <?= (!$product || $product->product_status === 'active') ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($product && $product->product_status === 'inactive') ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <div class="col-md-3" id="sgstField">
                <label class="form-label fw-semibold">SGST (%)</label>
                <input type="number" name="SGST" class="form-control" step="0.01" min="0"
                    value="<?= set_value('SGST', $product ? $product->SGST : 0) ?>">
            </div>
            <div class="col-md-3" id="cgstField">
                <label class="form-label fw-semibold">CGST (%)</label>
                <input type="number" name="CGST" class="form-control" step="0.01" min="0"
                    value="<?= set_value('CGST', $product ? $product->CGST : 0) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Size</label>
                <input type="text" name="size" class="form-control"
                    value="<?= set_value('size', $product ? $product->size : '') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Grade</label>
                <input type="text" name="grade" class="form-control"
                    value="<?= set_value('grade', $product ? $product->grade : '') ?>">
            </div>

            <?php if (!$product): ?>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Opening Stock <span class="text-danger">*</span></label>
                <input type="number" name="init_stock_quantity" class="form-control" min="0" step="0.01"
                    value="<?= set_value('init_stock_quantity', 0) ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">As On Date <span class="text-danger">*</span></label>
                <input type="date" name="as_on_date" class="form-control"
                    value="<?= set_value('as_on_date', date('Y-m-d')) ?>" required>
            </div>
            <?php endif; ?>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i><?= $product ? 'Update' : 'Save' ?></button>
            <a href="<?= base_url('product') ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
        <?= form_close() ?>
    </div>
</div>
<script>
function toggleTax(val) {
    const show = val === 'taxable';
    document.getElementById('sgstField').style.display = show ? '' : 'none';
    document.getElementById('cgstField').style.display = show ? '' : 'none';
}
toggleTax(document.getElementById('taxStatus').value);
</script>
