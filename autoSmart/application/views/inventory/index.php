<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-file-invoice text-primary me-2"></i>Sales Orders</h5>
    <a href="<?= base_url('inventory/add') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>New Order</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">#</th>
                    <th>Order Date</th>
                    <th>Customer</th>
                    <th>Bill Type</th>
                    <th>Payment</th>
                    <th class="text-end">Total</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr><td colspan="8" class="text-center text-muted py-4">No sales orders found.</td></tr>
                <?php else: ?>
                    <?php foreach ($orders as $i => $o): ?>
                    <tr>
                        <td class="ps-3 text-muted"><?= $i + 1 ?></td>
                        <td><?= date('d M Y', strtotime($o->inventory_order_date)) ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($o->customer_name) ?></td>
                        <td><?= htmlspecialchars($o->bill_type) ?></td>
                        <td>
                            <span class="badge <?= $o->payment_status === 'cash' ? 'badge-active' : 'bg-warning text-dark' ?>">
                                <?= ucfirst($o->payment_status) ?>
                            </span>
                        </td>
                        <td class="text-end fw-semibold">₹<?= number_format($o->inventory_order_total, 2) ?></td>
                        <td>
                            <span class="badge <?= $o->inventory_order_status === 'active' ? 'badge-active' : 'badge-inactive' ?>">
                                <?= ucfirst($o->inventory_order_status) ?>
                            </span>
                        </td>
                        <td class="text-end pe-3">
                            <a href="<?= base_url('inventory/view/' . $o->inventory_order_id) ?>" class="btn btn-sm btn-outline-secondary btn-action">
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
