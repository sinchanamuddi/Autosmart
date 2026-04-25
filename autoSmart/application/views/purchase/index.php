<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-truck text-primary me-2"></i>Purchase Invoices</h5>
    <a href="<?= base_url('purchase/add') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>New Purchase</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">#</th>
                    <th>Date</th>
                    <th>Supplier</th>
                    <th>Invoice No</th>
                    <th class="text-end">Bill Amount</th>
                    <th class="text-end">GST</th>
                    <th class="text-end">Total</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($purchases)): ?>
                    <tr><td colspan="9" class="text-center text-muted py-4">No purchases found.</td></tr>
                <?php else: ?>
                    <?php foreach ($purchases as $i => $p): ?>
                    <tr>
                        <td class="ps-3 text-muted"><?= $i + 1 ?></td>
                        <td><?= date('d M Y', strtotime($p->date_of_purchase)) ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($p->supplier_name) ?></td>
                        <td><?= $p->invoice_cash_bill_no ?: '—' ?></td>
                        <td class="text-end">₹<?= number_format($p->bill_amount, 2) ?></td>
                        <td class="text-end text-muted">₹<?= number_format($p->SGST + $p->CGST, 2) ?></td>
                        <td class="text-end fw-semibold text-success">₹<?= number_format($p->total_amount, 2) ?></td>
                        <td>
                            <span class="badge <?= $p->purchase_status === 'active' ? 'badge-active' : 'badge-inactive' ?>">
                                <?= ucfirst($p->purchase_status) ?>
                            </span>
                        </td>
                        <td class="text-end pe-3">
                            <a href="<?= base_url('purchase/view/' . $p->purchase_id) ?>" class="btn btn-sm btn-outline-secondary btn-action">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
