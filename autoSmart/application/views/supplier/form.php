<div class="d-flex align-items-center mb-3 gap-2">
    <a href="<?= base_url('supplier') ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left"></i></a>
    <h5 class="fw-bold mb-0"><?= $supplier ? 'Edit Supplier' : 'Add Supplier' ?></h5>
</div>
<div class="card">
    <div class="card-body p-4">
        <?= form_open($supplier ? 'supplier/edit/' . $supplier->id : 'supplier/add') ?>
        <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Firm Name <span class="text-danger">*</span></label>
                <input type="text" name="firm_name" class="form-control"
                    value="<?= set_value('firm_name', $supplier ? $supplier->firm_name : '') ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Contact Person <span class="text-danger">*</span></label>
                <input type="text" name="contact_person_name" class="form-control"
                    value="<?= set_value('contact_person_name', $supplier ? $supplier->contact_person_name : '') ?>" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Address</label>
                <textarea name="address" class="form-control" rows="2"><?= set_value('address', $supplier ? $supplier->address : '') ?></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Contact No <span class="text-danger">*</span></label>
                <input type="text" name="contact_no" class="form-control"
                    value="<?= set_value('contact_no', $supplier ? $supplier->contact_no : '') ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Alt Contact No</label>
                <input type="text" name="alt_contact_no" class="form-control"
                    value="<?= set_value('alt_contact_no', $supplier ? $supplier->alt_contact_no : '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email_id" class="form-control"
                    value="<?= set_value('email_id', $supplier ? $supplier->email_id : '') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Zipcode</label>
                <input type="text" name="zipcode" class="form-control"
                    value="<?= set_value('zipcode', $supplier ? $supplier->zipcode : '') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">GSTIN</label>
                <input type="text" name="GSTIN" class="form-control" maxlength="15"
                    value="<?= set_value('GSTIN', $supplier ? $supplier->GSTIN : '') ?>">
            </div>

            <div class="col-12"><hr class="my-1"><p class="text-muted fw-semibold mb-0" style="font-size:.85rem">Bank Details</p></div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Bank Name</label>
                <input type="text" name="bank_name" class="form-control"
                    value="<?= set_value('bank_name', $supplier ? $supplier->bank_name : '') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Branch</label>
                <input type="text" name="branch_name" class="form-control"
                    value="<?= set_value('branch_name', $supplier ? $supplier->branch_name : '') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">IFSC Code</label>
                <input type="text" name="IFSC_code" class="form-control"
                    value="<?= set_value('IFSC_code', $supplier ? $supplier->IFSC_code : '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Account Name</label>
                <input type="text" name="bank_act_name" class="form-control"
                    value="<?= set_value('bank_act_name', $supplier ? $supplier->bank_act_name : '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Account Number</label>
                <input type="text" name="bank_act_no" class="form-control"
                    value="<?= set_value('bank_act_no', $supplier ? $supplier->bank_act_no : '') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Status</label>
                <select name="supplier_status" class="form-select">
                    <option value="active" <?= ($supplier && $supplier->supplier_status === 'active') ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($supplier && $supplier->supplier_status === 'inactive') ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i><?= $supplier ? 'Update' : 'Save' ?></button>
            <a href="<?= base_url('supplier') ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
        <?= form_close() ?>
    </div>
</div>
