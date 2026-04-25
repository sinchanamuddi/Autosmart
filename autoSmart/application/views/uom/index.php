<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-ruler text-primary me-2"></i>Units of Measure (UOM)</h5>
    <a href="<?= base_url('uom/add') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Add UOM</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">#</th>
                    <th>UOM Name</th>
                    <th>Code</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($uoms)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">No UOMs found.</td></tr>
                <?php else: ?>
                    <?php foreach ($uoms as $i => $uom): ?>
                    <tr>
                        <td class="ps-3 text-muted"><?= $i + 1 ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($uom->uom_name) ?></td>
                        <td class="text-muted"><?= htmlspecialchars($uom->uom_code) ?: '—' ?></td>
                        <td>
                            <span class="badge <?= $uom->uom_status === 'active' ? 'badge-active' : 'badge-inactive' ?>">
                                <?= ucfirst($uom->uom_status) ?>
                            </span>
                        </td>
                        <td class="text-end pe-3">
                            <a href="<?= base_url('uom/edit/' . $uom->id) ?>" class="btn btn-sm btn-outline-primary btn-action me-1"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('uom/delete/' . $uom->id) ?>" class="btn btn-sm btn-outline-danger btn-action"
                               onclick="return confirm('Delete this UOM?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
