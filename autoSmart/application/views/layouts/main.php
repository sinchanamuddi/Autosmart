<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> — AutoSmart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 240px;
            --sidebar-bg: #1a1f2e;
            --sidebar-hover: #2d3550;
            --accent: #4f8ef7;
        }
        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        #sidebar {
            width: var(--sidebar-width); min-height: 100vh; background: var(--sidebar-bg);
            position: fixed; top: 0; left: 0; z-index: 100; display: flex; flex-direction: column;
        }
        #sidebar .brand {
            padding: 20px 18px; border-bottom: 1px solid #2d3550;
            font-size: 1.25rem; font-weight: 700; color: #fff; letter-spacing: 1px;
        }
        #sidebar .brand span { color: var(--accent); }
        #sidebar .nav-section {
            padding: 10px 18px 4px; font-size: 0.7rem; color: #6c757d;
            text-transform: uppercase; letter-spacing: 1.5px; margin-top: 8px;
        }
        #sidebar a.nav-link {
            color: #adb5bd; padding: 9px 18px; border-radius: 6px; margin: 2px 8px;
            font-size: 0.875rem; display: flex; align-items: center; gap: 10px;
            transition: all 0.2s;
        }
        #sidebar a.nav-link:hover, #sidebar a.nav-link.active {
            background: var(--sidebar-hover); color: #fff;
        }
        #sidebar a.nav-link.active { border-left: 3px solid var(--accent); }
        #sidebar a.nav-link i { width: 18px; text-align: center; }
        #sidebar .sidebar-footer {
            margin-top: auto; padding: 16px 18px; border-top: 1px solid #2d3550;
            font-size: 0.8rem; color: #6c757d;
        }
        #main { margin-left: var(--sidebar-width); min-height: 100vh; }
        #topbar {
            background: #fff; height: 56px; display: flex; align-items: center;
            justify-content: space-between; padding: 0 24px;
            box-shadow: 0 1px 4px rgba(0,0,0,.08); position: sticky; top: 0; z-index: 99;
        }
        #topbar .page-title { font-weight: 600; font-size: 1rem; color: #333; }
        .content-area { padding: 24px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
        .card-header { background: #fff; border-bottom: 1px solid #f0f2f5; border-radius: 12px 12px 0 0 !important; padding: 16px 20px; }
        .stat-card { border-radius: 12px; padding: 20px; color: #fff; }
        .stat-card .stat-value { font-size: 2rem; font-weight: 700; }
        .stat-card .stat-label { font-size: 0.8rem; opacity: 0.85; }
        .badge-active { background: #d1fae5; color: #065f46; }
        .badge-inactive { background: #fee2e2; color: #991b1b; }
        .table th { font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; border-top: none; }
        .btn-action { padding: 4px 10px; font-size: 0.8rem; border-radius: 6px; }
        .alert { border-radius: 10px; border: none; }
    </style>
</head>
<body>

<!-- Sidebar -->
<div id="sidebar">
    <div class="brand">Auto<span>Smart</span></div>

    <div class="nav-section">Main</div>
    <a href="<?= base_url('dashboard') ?>" class="nav-link <?= (uri_string() == 'dashboard') ? 'active' : '' ?>">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>

    <div class="nav-section">Inventory</div>
    <a href="<?= base_url('product') ?>" class="nav-link <?= (strpos(uri_string(),'product') === 0) ? 'active' : '' ?>">
        <i class="fas fa-boxes"></i> Products
    </a>
    <a href="<?= base_url('stock') ?>" class="nav-link <?= (strpos(uri_string(),'stock') === 0) ? 'active' : '' ?>">
        <i class="fas fa-layer-group"></i> Stock
    </a>
    <a href="<?= base_url('purchase') ?>" class="nav-link <?= (strpos(uri_string(),'purchase') === 0) ? 'active' : '' ?>">
        <i class="fas fa-truck"></i> Purchases
    </a>
    <a href="<?= base_url('inventory') ?>" class="nav-link <?= (strpos(uri_string(),'inventory') === 0) ? 'active' : '' ?>">
        <i class="fas fa-file-invoice"></i> Sales Orders
    </a>

    <div class="nav-section">Masters</div>
    <a href="<?= base_url('category') ?>" class="nav-link <?= (strpos(uri_string(),'category') === 0) ? 'active' : '' ?>">
        <i class="fas fa-tags"></i> Categories
    </a>
    <a href="<?= base_url('uom') ?>" class="nav-link <?= (strpos(uri_string(),'uom') === 0) ? 'active' : '' ?>">
        <i class="fas fa-ruler"></i> Units (UOM)
    </a>
    <a href="<?= base_url('supplier') ?>" class="nav-link <?= (strpos(uri_string(),'supplier') === 0) ? 'active' : '' ?>">
        <i class="fas fa-industry"></i> Suppliers
    </a>
    <a href="<?= base_url('customers') ?>" class="nav-link <?= (strpos(uri_string(),'customers') === 0) ? 'active' : '' ?>">
        <i class="fas fa-users"></i> Customers
    </a>

    <?php if ($user_type === 'master'): ?>
    <div class="nav-section">Admin</div>
    <a href="<?= base_url('users') ?>" class="nav-link <?= (strpos(uri_string(),'users') === 0) ? 'active' : '' ?>">
        <i class="fas fa-user-shield"></i> Users
    </a>
    <?php endif; ?>

    <div class="sidebar-footer">
        <i class="fas fa-user-circle me-1"></i> <?= htmlspecialchars($user_name) ?>
        <span class="badge ms-1 <?= $user_type === 'master' ? 'bg-warning text-dark' : 'bg-secondary' ?>" style="font-size:0.65rem">
            <?= $user_type === 'master' ? 'Admin' : 'Staff' ?>
        </span>
    </div>
</div>

<!-- Main Content -->
<div id="main">
    <div id="topbar">
        <span class="page-title"><i class="fas fa-chevron-right me-2 text-muted" style="font-size:.7rem"></i><?= htmlspecialchars($page_title) ?></span>
        <a href="<?= base_url('logout') ?>" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-sign-out-alt me-1"></i> Logout
        </a>
    </div>

    <div class="content-area">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i><?= $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= $this->load->view($content_view, array(), TRUE) ?>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
