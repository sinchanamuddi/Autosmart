<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — AutoSmart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #1a1f2e 0%, #2d3550 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { width: 100%; max-width: 420px; border-radius: 18px; box-shadow: 0 20px 60px rgba(0,0,0,.4); border: none; }
        .login-card .card-body { padding: 40px; }
        .brand { font-size: 1.8rem; font-weight: 800; color: #1a1f2e; letter-spacing: 1px; }
        .brand span { color: #4f8ef7; }
        .form-control { border-radius: 8px; padding: 10px 14px; border: 1.5px solid #e2e8f0; }
        .form-control:focus { border-color: #4f8ef7; box-shadow: 0 0 0 3px rgba(79,142,247,.15); }
        .btn-login { background: #4f8ef7; border: none; border-radius: 8px; padding: 11px; font-weight: 600; font-size: 1rem; }
        .btn-login:hover { background: #3a7ae8; }
        .input-group-text { border-radius: 8px 0 0 8px; border: 1.5px solid #e2e8f0; border-right: none; background: #f8fafc; color: #6c757d; }
        .input-group .form-control { border-radius: 0 8px 8px 0; }
    </style>
</head>
<body>
    <div class="login-card card">
        <div class="card-body">
            <div class="text-center mb-4">
                <div class="brand">Auto<span>Smart</span></div>
                <p class="text-muted mt-1" style="font-size:.9rem">Inventory Management System</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger py-2"><i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?= form_open('auth/login', array('autocomplete' => 'off')) ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="admin@gmail.com"
                            value="<?= set_value('email') ?>" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>
                <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
                <button type="submit" class="btn btn-login btn-primary w-100 text-white">
                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                </button>
            <?= form_close() ?>

            <p class="text-center text-muted mt-3 mb-0" style="font-size:.8rem">
                Default: admin@gmail.com / admin
            </p>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
