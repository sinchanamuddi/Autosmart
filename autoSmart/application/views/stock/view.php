<div class="d-flex align-items-center mb-3 gap-2">
    <a href="<?= base_url('stock') ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left"></i></a>
    <h5 class="fw-bold mb-0">Stock Detail — <?= htmlspecialchars($product->product_name) ?></h5>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#10b981,#059669)">
            <div class="stat-value"><?= $stock_total ? $stock_total->total_purchase_quantity : 0 ?></div>
            <div class="stat-label">Total Purchased</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed)">
            <div class="stat-value"><?= $stock_total ? $stock_total->total_sales_quantity : 0 ?></div>
            <div class="stat-label">Total Sold</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#4f8ef7,#2563eb)">
            <div class="stat-value"><?= $stock_total ? $stock_total->stock_available : 0 ?></div>
            <div class="stat-label">Available Stock (<?= htmlspecialchars($product->uom_name) ?>)</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#f59e0b,#d97706)">
            <div class="stat-value"><?= $product->min_stock_quantity ?></div>
            <div class="stat-label">Min Stock Level</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header fw-semibold"><i class="fas fa-truck me-2 text-success"></i>Stock In (Purchases)</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Date</th>
                            <th>Supplier</th>
                            <th class="text-end pe-3">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($stock_in)): ?>
                            <tr><td colspan="3" class="text-center text-muted py-3">No purchases yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($stock_in as $s): ?>
                            <tr>
                                <td class="ps-3"><?= date('d M Y', strtotime($s->date_of_purchase)) ?></td>
                                <td><?= htmlspecialchars($s->supplier_name) ?></td>
                                <td class="text-end pe-3 fw-semibold text-success">+<?= $s->stock_in ?> <?= htmlspecialchars($s->purchase_uom) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header fw-semibold"><i class="fas fa-file-invoice me-2 text-danger"></i>Stock Out (Sales)</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Date</th>
                            <th>Customer</th>
                            <th class="text-end pe-3">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($stock_out)): ?>
                            <tr><td colspan="3" class="text-center text-muted py-3">No sales yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($stock_out as $s): ?>
                            <tr>
                                <td class="ps-3"><?= date('d M Y', strtotime($s->inventory_order_date)) ?></td>
                                <td><?= htmlspecialchars($s->customer_name) ?></td>
                                <td class="text-end pe-3 fw-semibold text-danger">-<?= $s->stock_out ?> <?= htmlspecialchars($s->sale_uom) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
