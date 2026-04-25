<div class="d-flex align-items-center mb-3 gap-2">
    <a href="<?= base_url('purchase') ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left"></i></a>
    <h5 class="fw-bold mb-0">New Purchase Invoice</h5>
</div>
<div class="card">
    <div class="card-body p-4">
        <?= form_open('purchase/add') ?>
        <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Supplier <span class="text-danger">*</span></label>
                <select name="supplier_id" class="form-select" required>
                    <option value="">-- Select Supplier --</option>
                    <?php foreach ($suppliers as $s): ?>
                        <option value="<?= $s->id ?>"><?= htmlspecialchars($s->firm_name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Date of Purchase <span class="text-danger">*</span></label>
                <input type="date" name="date_of_purchase" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Invoice / Bill No</label>
                <input type="text" name="invoice_cash_bill_no" class="form-control" placeholder="Optional">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Bill Amount <span class="text-danger">*</span></label>
                <input type="number" name="bill_amount" id="billAmount" class="form-control" step="0.01" min="0"
                    placeholder="0.00" required oninput="calcTotal()">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">SGST (%)</label>
                <input type="number" name="SGST" id="sgst" class="form-control" step="0.01" min="0" value="0" oninput="calcTotal()">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">CGST (%)</label>
                <input type="number" name="CGST" id="cgst" class="form-control" step="0.01" min="0" value="0" oninput="calcTotal()">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Total Amount</label>
                <input type="text" id="totalAmount" class="form-control bg-light fw-bold" readonly placeholder="0.00">
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="fw-semibold mb-0">Products Received</h6>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addRow()">
                <i class="fas fa-plus me-1"></i>Add Row
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="productTable">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th style="width:120px">Quantity</th>
                        <th style="width:130px">Unit Cost</th>
                        <th style="width:140px">Purchase UOM</th>
                        <th style="width:50px"></th>
                    </tr>
                </thead>
                <tbody id="productRows">
                    <tr>
                        <td>
                            <select name="product_id[]" class="form-select form-select-sm" required>
                                <option value="">-- Product --</option>
                                <?php foreach ($products as $p): ?>
                                    <option value="<?= $p->id ?>"><?= htmlspecialchars($p->product_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input type="number" name="quantity[]" class="form-control form-control-sm" step="0.01" min="0" required></td>
                        <td><input type="number" name="unit_cost[]" class="form-control form-control-sm" step="0.01" min="0" value="0"></td>
                        <td><input type="text" name="purchase_uom[]" class="form-control form-control-sm" placeholder="Pieces"></td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i class="fas fa-times"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Save Purchase</button>
            <a href="<?= base_url('purchase') ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
        <?= form_close() ?>
    </div>
</div>

<script>
const productOptions = `<?php foreach ($products as $p): ?><option value="<?= $p->id ?>"><?= htmlspecialchars($p->product_name) ?></option><?php endforeach; ?>`;

function addRow() {
    const tbody = document.getElementById('productRows');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td><select name="product_id[]" class="form-select form-select-sm" required><option value="">-- Product --</option>${productOptions}</select></td>
        <td><input type="number" name="quantity[]" class="form-control form-control-sm" step="0.01" min="0" required></td>
        <td><input type="number" name="unit_cost[]" class="form-control form-control-sm" step="0.01" min="0" value="0"></td>
        <td><input type="text" name="purchase_uom[]" class="form-control form-control-sm" placeholder="Pieces"></td>
        <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i class="fas fa-times"></i></button></td>`;
    tbody.appendChild(tr);
}

function removeRow(btn) {
    const rows = document.getElementById('productRows').querySelectorAll('tr');
    if (rows.length > 1) btn.closest('tr').remove();
}

function calcTotal() {
    const bill = parseFloat(document.getElementById('billAmount').value) || 0;
    const sgst = parseFloat(document.getElementById('sgst').value) || 0;
    const cgst = parseFloat(document.getElementById('cgst').value) || 0;
    const total = bill + (bill * sgst / 100) + (bill * cgst / 100);
    document.getElementById('totalAmount').value = '₹' + total.toFixed(2);
}
</script>
