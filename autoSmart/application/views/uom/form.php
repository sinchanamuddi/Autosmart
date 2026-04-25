<div class="d-flex align-items-center mb-3 gap-2">
    <a href="<?= base_url('uom') ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left"></i></a>
    <h5 class="fw-bold mb-0"><?= $uom ? 'Edit UOM' : 'Add UOM' ?></h5>
</div>
<div class="card" style="max-width:520px">
    <div class="card-body p-4">
        <?= form_open($uom ? 'uom/edit/' . $uom->id : 'uom/add') ?>
        <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

        <div class="mb-3">
            <label class="form-label fw-semibold">UOM Name <span class="text-danger">*</span></label>
            <input type="text" name="uom_name" class="form-control"
                value="<?= set_value('uom_name', $uom ? $uom->uom_name : '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">UOM Code</label>
            <input type="text" name="uom_code" class="form-control" placeholder="e.g. KG, PCS, BOX"
                value="<?= set_value('uom_code', $uom ? $uom->uom_code : '') ?>">
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold">Status</label>
            <select name="uom_status" class="form-select">
                <option value="active" <?= ($uom && $uom->uom_status === 'active') ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= ($uom && $uom->uom_status === 'inactive') ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i><?= $uom ? 'Update' : 'Save' ?></button>
            <a href="<?= base_url('uom') ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
        <?= form_close() ?>
    </div>
</div>
