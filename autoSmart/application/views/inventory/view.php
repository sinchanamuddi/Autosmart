<div class="d-flex align-items-center mb-3 gap-2">
    <a href="<?= base_url('inventory') ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left"></i></a>
    <h5 class="fw-bold mb-0">Sales Order #<?= $order->inventory_order_id ?></h5>
</div>
<div class="row g-3">
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="fw-semibold text-muted mb-3">Order Details</h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-muted" style="width:130px">Customer</td><td class="fw-semibold"><?= htmlspecialchars($order->customer_name) ?></td></tr>
                    <tr><td class="text-muted">Contact</td><td><?= $order->contact_no ?: '—' ?></td></tr>
                    <tr><td class="text-muted">GSTIN</td><td><?= htmlspecialchars($order->customer_gstin) ?: '—' ?></td></tr>
                    <tr><td class="text-muted">Order Date</td><td><?= date('d M Y', strtotime($order->inventory_order_date)) ?></td></tr>
                    <tr><td class="text-muted">Bill Type</td><td><?= htmlspecialchars($order->bill_type) ?></td></tr>
                    <tr><td class="text-muted">Payment</td><td>
                        <span class="badge <?= $order->payment_status === 'cash' ? 'badge-active' : 'bg-warning text-dark' ?>">
                            <?= ucfirst($order->payment_status) ?>
                        </span>
                    </td></tr>
                    <tr><td class="text-muted">Discount</td><td><?= $order->pdiscount ?>%</td></tr>
                    <tr><td class="text-muted fw-semibold">Total</td><td class="fw-bold text-success fs-6">₹<?= number_format($order->inventory_order_total, 2) ?></td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header fw-semibold">Order Items</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Product</th>
                            <th>HSN Code</th>
                            <th class="text-end">Qty</th>
                            <th>UOM</th>
                            <th class="text-end">Price</th>
                            <th class="text-end">Tax</th>
                            <th class="text-end pe-3">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $grand = 0; foreach ($items as $i => $item): $amt = $item->price * $item->quantity + $item->tax; $grand += $amt; ?>
                        <tr>
                            <td class="ps-3 text-muted"><?= $i + 1 ?></td>
                            <td class="fw-semibold"><?= htmlspecialchars($item->product_name) ?></td>
                            <td><?= $item->HSN_code ?></td>
                            <td class="text-end"><?= $item->quantity ?></td>
                            <td><?= htmlspecialchars($item->sale_uom) ?></td>
                            <td class="text-end">₹<?= number_format($item->price, 2) ?></td>
                            <td class="text-end">₹<?= number_format($item->tax, 2) ?></td>
                            <td class="text-end pe-3">₹<?= number_format($amt, 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="7" class="text-end fw-bold pe-3">Grand Total</td>
                            <td class="text-end pe-3 fw-bold text-success">₹<?= number_format($grand, 2) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
