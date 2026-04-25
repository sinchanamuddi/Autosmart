<div class="d-flex align-items-center mb-3 gap-2">
    <a href="<?= base_url('users') ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left"></i></a>
    <h5 class="fw-bold mb-0"><?= $user ? 'Edit User' : 'Add User' ?></h5>
</div>
<div class="card" style="max-width:520px">
    <div class="card-body p-4">
        <?= form_open($user ? 'users/edit/' . $user->id : 'users/add') ?>
        <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

        <div class="mb-3">
            <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="user_name" class="form-control"
                value="<?= set_value('user_name', $user ? $user->user_name : '') ?>" required>
        </div>
        <?php if (!$user): ?>
        <div class="mb-3">
            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
            <input type="email" name="user_email" class="form-control"
                value="<?= set_value('user_email') ?>" required>
        </div>
        <?php else: ?>
        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($user->user_email) ?>" disabled>
        </div>
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label fw-semibold"><?= $user ? 'New Password' : 'Password' ?> <?= !$user ? '<span class="text-danger">*</span>' : '' ?></label>
            <input type="password" name="password" class="form-control" <?= !$user ? 'required' : '' ?>
                placeholder="<?= $user ? 'Leave blank to keep current' : 'Min 6 characters' ?>">
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
            <select name="user_type" class="form-select" required>
                <option value="master" <?= ($user && $user->user_type === 'master') ? 'selected' : '' ?>>Admin (master)</option>
                <option value="user" <?= ($user && $user->user_type === 'user') ? 'selected' : '' ?>>Staff (user)</option>
            </select>
        </div>
        <?php if ($user): ?>
        <div class="mb-4">
            <label class="form-label fw-semibold">Status</label>
            <select name="user_status" class="form-select">
                <option value="Active" <?= $user->user_status === 'Active' ? 'selected' : '' ?>>Active</option>
                <option value="Inactive" <?= $user->user_status === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
        <?php endif; ?>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i><?= $user ? 'Update' : 'Create User' ?></button>
            <a href="<?= base_url('users') ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
        <?= form_close() ?>
    </div>
</div>
