<div class="d-flex align-items-center mb-3 gap-2">
    <a href="<?= base_url('inventory') ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left"></i></a>
    <h5 class="fw-bold mb-0">New Sales Order</h5>
</div>
<div class="card">
    <div class="card-body p-4">
        <?= form_open('inventory/add') ?>
        <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Customer <span class="text-danger">*</span></label>
                <select name="customer_id" class="form-select" required>
                    <option value="">-- Select Customer --</option>
                    <?php foreach ($customers as $c): ?>
                        <option value="<?= $c->id ?>"><?= htmlspecialchars($c->customer_name) ?><?= $c->firm_name ? ' (' . htmlspecialchars($c->firm_name) . ')' : '' ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Order Date <span class="text-danger">*</span></label>
                <input type="date" name="inventory_order_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Bill Type</label>
                <select name="bill_type" class="form-select">
                    <option value="Tax Invoice">Tax Invoice</option>
                    <option value="Bill of Supply">Bill of Supply</option>
                    <option value="BroughtForward">Brought Forward</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Payment Status</label>
                <select name="payment_status" class="form-select">
                    <option value="cash">Cash</option>
                    <option value="credit">Credit</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Discount (%)</label>
                <input type="number" name="pdiscount" class="form-control" min="0" max="100" value="0">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Cess (%)</label>
                <input type="number" name="pcess" class="form-control" min="0" value="0">
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="fw-semibold mb-0">Order Items</h6>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addRow()">
                <i class="fas fa-plus me-1"></i>Add Item
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="orderTable">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th style="width:100px">Stock</th>
                        <th style="width:110px">Qty</th>
                        <th style="width:120px">Price (₹)</th>
                        <th style="width:100px">Tax (₹)</th>
                        <th style="width:130px">Sale UOM</th>
                        <th style="width:110px">Amount</th>
                        <th style="width:50px"></th>
                    </tr>
                </thead>
                <tbody id="orderRows">
                    <tr>
                        <td>
                            <select name="product_id[]" class="form-select form-select-sm" required onchange="setStock(this)">
                                <option value="">-- Product --</option>
                                <?php foreach ($products as $p): ?>
                                    <option value="<?= $p->id ?>" data-stock="<?= $p->stock_available ?>" data-uom="<?= htmlspecialchars($p->uom_name) ?>">
                                        <?= htmlspecialchars($p->product_name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input type="text" class="form-control form-control-sm bg-light stock-field" readonly placeholder="—"></td>
                        <td><input type="number" name="quantity[]" class="form-control form-control-sm qty" step="0.01" min="0" required oninput="calcRow(this)"></td>
                        <td><input type="number" name="price[]" class="form-control form-control-sm price" step="0.01" min="0" value="0" oninput="calcRow(this)"></td>
                        <td><input type="number" name="tax[]" class="form-control form-control-sm" step="0.01" min="0" value="0"></td>
                        <td><input type="text" name="sale_uom[]" class="form-control form-control-sm uom-field" placeholder="Pieces"></td>
                        <td><input type="text" class="form-control form-control-sm bg-light row-total" readonly value="₹0.00"></td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i class="fas fa-times"></i></button></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="table-light">
                        <td colspan="6" class="text-end fw-semibold">Grand Total</td>
                        <td><input type="text" id="grandTotal" class="form-control form-control-sm bg-light fw-bold" readonly value="₹0.00"></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Save Order</button>
            <a href="<?= base_url('inventory') ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
        <?= form_close() ?>
    </div>
</div>

<script>
const productOptions = `<?php foreach ($products as $p): ?><option value="<?= $p->id ?>" data-stock="<?= $p->stock_available ?>" data-uom="<?= htmlspecialchars($p->uom_name) ?>"><?= htmlspecialchars($p->product_name) ?></option><?php endforeach; ?>`;

function setStock(sel) {
    const opt = sel.options[sel.selectedIndex];
    const row = sel.closest('tr');
    row.querySelector('.stock-field').value = opt.dataset.stock || '—';
    row.querySelector('.uom-field').value = opt.dataset.uom || '';
}

function calcRow(input) {
    const row = input.closest('tr');
    const qty = parseFloat(row.querySelector('.qty').value) || 0;
    const price = parseFloat(row.querySelector('.price').value) || 0;
    row.querySelector('.row-total').value = '₹' + (qty * price).toFixed(2);
    calcGrand();
}

function calcGrand() {
    let total = 0;
    document.querySelectorAll('.row-total').forEach(el => {
        total += parseFloat(el.value.replace('₹', '')) || 0;
    });
    document.getElementById('grandTotal').value = '₹' + total.toFixed(2);
}

function addRow() {
    const tbody = document.getElementById('orderRows');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td><select name="product_id[]" class="form-select form-select-sm" required onchange="setStock(this)"><option value="">-- Product --</option>${productOptions}</select></td>
        <td><input type="text" class="form-control form-control-sm bg-light stock-field" readonly placeholder="—"></td>
        <td><input type="number" name="quantity[]" class="form-control form-control-sm qty" step="0.01" min="0" required oninput="calcRow(this)"></td>
        <td><input type="number" name="price[]" class="form-control form-control-sm price" step="0.01" min="0" value="0" oninput="calcRow(this)"></td>
        <td><input type="number" name="tax[]" class="form-control form-control-sm" step="0.01" min="0" value="0"></td>
        <td><input type="text" name="sale_uom[]" class="form-control form-control-sm uom-field" placeholder="Pieces"></td>
        <td><input type="text" class="form-control form-control-sm bg-light row-total" readonly value="₹0.00"></td>
        <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i class="fas fa-times"></i></button></td>`;
    tbody.appendChild(tr);
}

function removeRow(btn) {
    const rows = document.getElementById('orderRows').querySelectorAll('tr');
    if (rows.length > 1) { btn.closest('tr').remove(); calcGrand(); }
}
</script>
