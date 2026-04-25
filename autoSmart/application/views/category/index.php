<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-tags text-primary me-2"></i>Categories</h5>
    <a href="<?= base_url('category/add') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Add Category</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">#</th>
                    <th>Category Name</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($categories)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">No categories found.</td></tr>
                <?php else: ?>
                    <?php foreach ($categories as $i => $cat): ?>
                    <tr>
                        <td class="ps-3 text-muted"><?= $i + 1 ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($cat->category_name) ?></td>
                        <td>
                            <span class="badge <?= $cat->category_status === 'active' ? 'badge-active' : 'badge-inactive' ?>">
                                <?= ucfirst($cat->category_status) ?>
                            </span>
                        </td>
                        <td class="text-muted" style="font-size:.85rem"><?= date('d M Y', strtotime($cat->created_at)) ?></td>
                        <td class="text-end pe-3">
                            <a href="<?= base_url('category/edit/' . $cat->id) ?>" class="btn btn-sm btn-outline-primary btn-action me-1"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('category/delete/' . $cat->id) ?>" class="btn btn-sm btn-outline-danger btn-action"
                               onclick="return confirm('Delete this category?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
