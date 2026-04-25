<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-users text-primary me-2"></i>Customers</h5>
    <a href="<?= base_url('customers/add') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Add Customer</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">#</th>
                    <th>Name</th>
                    <th>Firm</th>
                    <th>Type</th>
                    <th>Contact</th>
                    <th>GSTIN</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($customers)): ?>
                    <tr><td colspan="8" class="text-center text-muted py-4">No customers found.</td></tr>
                <?php else: ?>
                    <?php foreach ($customers as $i => $c): ?>
                    <tr>
                        <td class="ps-3 text-muted"><?= $i + 1 ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($c->customer_name) ?></td>
                        <td><?= htmlspecialchars($c->firm_name) ?: '—' ?></td>
                        <td><?= htmlspecialchars($c->customer_type) ?></td>
                        <td><?= $c->contact_no ?: '—' ?></td>
                        <td class="text-muted" style="font-size:.82rem"><?= htmlspecialchars($c->GSTIN) ?: '—' ?></td>
                        <td>
                            <span class="badge <?= $c->customer_status === 'active' ? 'badge-active' : 'badge-inactive' ?>">
                                <?= ucfirst($c->customer_status) ?>
                            </span>
                        </td>
                        <td class="text-end pe-3">
                            <a href="<?= base_url('customers/edit/' . $c->id) ?>" class="btn btn-sm btn-outline-primary btn-action me-1"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('customers/delete/' . $c->id) ?>" class="btn btn-sm btn-outline-danger btn-action"
                               onclick="return confirm('Delete this customer?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
