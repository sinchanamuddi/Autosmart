<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-user-shield text-primary me-2"></i>System Users</h5>
    <a href="<?= base_url('users/add') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Add User</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">No users found.</td></tr>
                <?php else: ?>
                    <?php foreach ($users as $i => $u): ?>
                    <tr>
                        <td class="ps-3 text-muted"><?= $i + 1 ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($u->user_name) ?></td>
                        <td><?= htmlspecialchars($u->user_email) ?></td>
                        <td>
                            <span class="badge <?= $u->user_type === 'master' ? 'bg-warning text-dark' : 'bg-secondary' ?>">
                                <?= $u->user_type === 'master' ? 'Admin' : 'Staff' ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge <?= $u->user_status === 'Active' ? 'badge-active' : 'badge-inactive' ?>">
                                <?= $u->user_status ?>
                            </span>
                        </td>
                        <td class="text-muted" style="font-size:.85rem"><?= date('d M Y', strtotime($u->created_at)) ?></td>
                        <td class="text-end pe-3">
                            <a href="<?= base_url('users/edit/' . $u->id) ?>" class="btn btn-sm btn-outline-primary btn-action me-1"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('users/delete/' . $u->id) ?>" class="btn btn-sm btn-outline-danger btn-action"
                               onclick="return confirm('Delete this user?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
