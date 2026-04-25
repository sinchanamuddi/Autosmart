<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-boxes text-primary me-2"></i>Products</h5>
    <a href="<?= base_url('product/add') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Add Product</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">#</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>UOM</th>
                    <th>Tax</th>
                    <th>Min Stock</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr><td colspan="9" class="text-center text-muted py-4">No products found.</td></tr>
                <?php else: ?>
                    <?php foreach ($products as $i => $p): ?>
                    <tr>
                        <td class="ps-3 text-muted"><?= $i + 1 ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($p->product_name) ?></td>
                        <td><?= htmlspecialchars($p->category_name) ?></td>
                        <td><?= htmlspecialchars($p->supplier_name) ?></td>
                        <td><?= htmlspecialchars($p->uom_name) ?></td>
                        <td>
                            <?php if ($p->tax_status === 'taxable'): ?>
                                <span class="badge bg-info text-dark" style="font-size:.72rem">
                                    <?= $p->SGST + $p->CGST ?>% GST
                                </span>
                            <?php else: ?>
                                <span class="badge bg-light text-muted">Nil</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $p->min_stock_quantity ?></td>
                        <td>
                            <span class="badge <?= $p->product_status === 'active' ? 'badge-active' : 'badge-inactive' ?>">
                                <?= ucfirst($p->product_status) ?>
                            </span>
                        </td>
                        <td class="text-end pe-3">
                            <a href="<?= base_url('product/edit/' . $p->id) ?>" class="btn btn-sm btn-outline-primary btn-action me-1"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('product/delete/' . $p->id) ?>" class="btn btn-sm btn-outline-danger btn-action"
                               onclick="return confirm('Delete this product?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
