<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-layer-group text-primary me-2"></i>Stock Overview</h5>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">#</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th class="text-end">Purchased</th>
                    <th class="text-end">Sold</th>
                    <th class="text-end">Available</th>
                    <th class="text-end">Min Stock</th>
                    <th>UOM</th>
                    <th>Alert</th>
                    <th class="text-end pe-3">Details</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($stocks)): ?>
                    <tr><td colspan="10" class="text-center text-muted py-4">No stock records found.</td></tr>
                <?php else: ?>
                    <?php foreach ($stocks as $i => $s): ?>
                    <?php $low = $s->stock_available <= $s->min_stock_quantity; ?>
                    <tr class="<?= $low ? 'table-warning' : '' ?>">
                        <td class="ps-3 text-muted"><?= $i + 1 ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($s->product_name) ?></td>
                        <td><?= htmlspecialchars($s->category_name) ?></td>
                        <td class="text-end"><?= $s->total_purchase_quantity ?></td>
                        <td class="text-end"><?= $s->total_sales_quantity ?></td>
                        <td class="text-end fw-bold <?= $low ? 'text-danger' : 'text-success' ?>">
                            <?= $s->stock_available ?>
                        </td>
                        <td class="text-end text-muted"><?= $s->min_stock_quantity ?></td>
                        <td><?= htmlspecialchars($s->uom_name) ?></td>
                        <td>
                            <?php if ($low): ?>
                                <span class="badge bg-danger"><i class="fas fa-exclamation-triangle me-1"></i>Low</span>
                            <?php else: ?>
                                <span class="badge badge-active"><i class="fas fa-check me-1"></i>OK</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end pe-3">
                            <a href="<?= base_url('stock/view/' . $s->product_id) ?>" class="btn btn-sm btn-outline-secondary btn-action">
                                <i class="fas fa-chart-bar"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
