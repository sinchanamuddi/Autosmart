<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-industry text-primary me-2"></i>Suppliers</h5>
    <a href="<?= base_url('supplier/add') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Add Supplier</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">#</th>
                    <th>Firm Name</th>
                    <th>Contact Person</th>
                    <th>Contact No</th>
                    <th>GSTIN</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($suppliers)): ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">No suppliers found.</td></tr>
                <?php else: ?>
                    <?php foreach ($suppliers as $i => $s): ?>
                    <tr>
                        <td class="ps-3 text-muted"><?= $i + 1 ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($s->firm_name) ?></td>
                        <td><?= htmlspecialchars($s->contact_person_name) ?></td>
                        <td><?= htmlspecialchars($s->contact_no) ?></td>
                        <td class="text-muted" style="font-size:.82rem"><?= htmlspecialchars($s->GSTIN) ?: '—' ?></td>
                        <td>
                            <span class="badge <?= $s->supplier_status === 'active' ? 'badge-active' : 'badge-inactive' ?>">
                                <?= ucfirst($s->supplier_status) ?>
                            </span>
                        </td>
                        <td class="text-end pe-3">
                            <a href="<?= base_url('supplier/edit/' . $s->id) ?>" class="btn btn-sm btn-outline-primary btn-action me-1"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('supplier/delete/' . $s->id) ?>" class="btn btn-sm btn-outline-danger btn-action"
                               onclick="return confirm('Delete this supplier?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
