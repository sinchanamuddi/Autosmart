<div class="d-flex align-items-center mb-3 gap-2">
    <a href="<?= base_url('purchase') ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left"></i></a>
    <h5 class="fw-bold mb-0">Purchase Invoice #<?= $invoice->purchase_id ?></h5>
</div>
<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="fw-semibold text-muted mb-3">Invoice Details</h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-muted" style="width:140px">Supplier</td><td class="fw-semibold"><?= htmlspecialchars($invoice->supplier_name) ?></td></tr>
                    <tr><td class="text-muted">Supplier GSTIN</td><td><?= htmlspecialchars($invoice->supplier_gstin) ?: '—' ?></td></tr>
                    <tr><td class="text-muted">Date</td><td><?= date('d M Y', strtotime($invoice->date_of_purchase)) ?></td></tr>
                    <tr><td class="text-muted">Invoice No</td><td><?= $invoice->invoice_cash_bill_no ?: '—' ?></td></tr>
                    <tr><td class="text-muted">Bill Amount</td><td>₹<?= number_format($invoice->bill_amount, 2) ?></td></tr>
                    <tr><td class="text-muted">SGST</td><td>₹<?= number_format($invoice->SGST, 2) ?></td></tr>
                    <tr><td class="text-muted">CGST</td><td>₹<?= number_format($invoice->CGST, 2) ?></td></tr>
                    <tr><td class="text-muted fw-semibold">Total</td><td class="fw-bold text-success fs-6">₹<?= number_format($invoice->total_amount, 2) ?></td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header fw-semibold">Products Received</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Product</th>
                            <th>HSN Code</th>
                            <th class="text-end">Quantity</th>
                            <th>UOM</th>
                            <th class="text-end">Unit Cost</th>
                            <th class="text-end pe-3">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $i => $item): ?>
                        <tr>
                            <td class="ps-3 text-muted"><?= $i + 1 ?></td>
                            <td class="fw-semibold"><?= htmlspecialchars($item->product_name) ?></td>
                            <td><?= $item->HSN_code ?></td>
                            <td class="text-end"><?= $item->quantity ?></td>
                            <td><?= htmlspecialchars($item->purchase_uom) ?></td>
                            <td class="text-end">₹<?= number_format($item->unit_cost, 2) ?></td>
                            <td class="text-end pe-3">₹<?= number_format($item->unit_cost * $item->quantity, 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
