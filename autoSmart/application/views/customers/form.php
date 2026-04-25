<div class="d-flex align-items-center mb-3 gap-2">
    <a href="<?= base_url('customers') ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left"></i></a>
    <h5 class="fw-bold mb-0"><?= $customer ? 'Edit Customer' : 'Add Customer' ?></h5>
</div>
<div class="card" style="max-width:700px">
    <div class="card-body p-4">
        <?= form_open($customer ? 'customers/edit/' . $customer->id : 'customers/add') ?>
        <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Customer Name <span class="text-danger">*</span></label>
                <input type="text" name="customer_name" class="form-control"
                    value="<?= set_value('customer_name', $customer ? $customer->customer_name : '') ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Firm Name</label>
                <input type="text" name="firm_name" class="form-control"
                    value="<?= set_value('firm_name', $customer ? $customer->firm_name : '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Customer Type <span class="text-danger">*</span></label>
                <select name="customer_type" class="form-select" required>
                    <option value="Registered" <?= ($customer && $customer->customer_type === 'Registered') ? 'selected' : '' ?>>Registered</option>
                    <option value="Unregistered" <?= (!$customer || $customer->customer_type === 'Unregistered') ? 'selected' : '' ?>>Unregistered</option>
                    <option value="Consumer" <?= ($customer && $customer->customer_type === 'Consumer') ? 'selected' : '' ?>>Consumer</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">GSTIN</label>
                <input type="text" name="GSTIN" class="form-control" maxlength="15"
                    value="<?= set_value('GSTIN', $customer ? $customer->GSTIN : '') ?>">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Address</label>
                <input type="text" name="address" class="form-control"
                    value="<?= set_value('address', $customer ? $customer->address : '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Place</label>
                <input type="text" name="place" class="form-control"
                    value="<?= set_value('place', $customer ? $customer->place : '') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Zipcode</label>
                <input type="text" name="zipcode" class="form-control" maxlength="6"
                    value="<?= set_value('zipcode', $customer ? $customer->zipcode : '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Contact No</label>
                <input type="text" name="contact_no" class="form-control"
                    value="<?= set_value('contact_no', $customer ? $customer->contact_no : '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email_id" class="form-control"
                    value="<?= set_value('email_id', $customer ? $customer->email_id : '') ?>">
            </div>
            <?php if ($customer): ?>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Status</label>
                <select name="customer_status" class="form-select">
                    <option value="active" <?= $customer->customer_status === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $customer->customer_status === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <?php endif; ?>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i><?= $customer ? 'Update' : 'Save' ?></button>
            <a href="<?= base_url('customers') ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
        <?= form_close() ?>
    </div>
</div>
