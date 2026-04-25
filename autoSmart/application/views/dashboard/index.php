<?php
$months_labels   = json_encode(array_column($monthly_purchases, 'month'));
$purchase_totals = json_encode(array_column($monthly_purchases, 'total'));
$sales_totals    = json_encode(array_column($monthly_sales, 'total'));
$cat_labels      = json_encode(array_column($stock_by_category, 'category_name'));
$cat_stocks      = json_encode(array_column($stock_by_category, 'total_stock'));
$bar_labels      = json_encode(array_column($top_stock_products, 'product_name'));
$bar_available   = json_encode(array_column($top_stock_products, 'stock_available'));
$bar_min         = json_encode(array_column($top_stock_products, 'min_stock_quantity'));
$profit          = $sales_value - $purchase_value;
?>
<style>
.stat-card{border-radius:14px;padding:20px 22px;color:#fff;position:relative;overflow:hidden;cursor:pointer;transition:transform .18s,box-shadow .18s;text-decoration:none;display:block}
.stat-card:hover{transform:translateY(-3px);box-shadow:0 8px 24px rgba(0,0,0,.18)}
.stat-card .sv{font-size:1.9rem;font-weight:800;line-height:1}
.stat-card .sl{font-size:.77rem;opacity:.88;margin-top:5px}
.stat-card .sc{font-size:.71rem;margin-top:7px;opacity:.82}
.stat-card .si{position:absolute;right:18px;top:50%;transform:translateY(-50%);font-size:3rem;opacity:.13}
.mini-card{border:none;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.06);padding:14px 16px;display:flex;align-items:center;gap:14px}
.mini-icon{border-radius:10px;padding:11px;font-size:1.1rem;flex-shrink:0}
.chart-card{border:none;border-radius:14px;box-shadow:0 2px 10px rgba(0,0,0,.06)}
.chart-card .card-header{background:#fff;border-bottom:1px solid #f0f2f5;border-radius:14px 14px 0 0!important;padding:13px 18px;font-weight:600;font-size:.88rem}
.badge-cash{background:#d1fae5;color:#065f46}
.badge-credit{background:#fef3c7;color:#92400e}
</style>

<!-- STAT CARDS -->
<div class="row g-3 mb-3">
    <div class="col-6 col-xl-3">
        <a href="<?= base_url('product') ?>" class="stat-card" style="background:linear-gradient(135deg,#4f8ef7,#2563eb)">
            <div class="sv"><?= number_format($total_products) ?></div>
            <div class="sl">Active Products</div>
            <div class="sc"><i class="fas fa-arrow-right me-1"></i>View all</div>
            <i class="fas fa-boxes si"></i>
        </a>
    </div>
    <div class="col-6 col-xl-3">
        <a href="<?= base_url('stock') ?>" class="stat-card" style="background:linear-gradient(135deg,#f59e0b,#d97706)">
            <div class="sv"><?= number_format($low_stock) ?></div>
            <div class="sl">Low Stock Alerts</div>
            <div class="sc"><i class="fas fa-exclamation-triangle me-1"></i><?= $low_stock > 0 ? 'Needs attention' : 'All good!' ?></div>
            <i class="fas fa-exclamation-triangle si"></i>
        </a>
    </div>
    <div class="col-6 col-xl-3">
        <a href="<?= base_url('purchase') ?>" class="stat-card" style="background:linear-gradient(135deg,#10b981,#059669)">
            <div class="sv">&#8377;<?= number_format($purchase_value, 0) ?></div>
            <div class="sl">Total Purchase Value</div>
            <div class="sc"><i class="fas fa-truck me-1"></i><?= $total_purchases ?> invoices</div>
            <i class="fas fa-truck si"></i>
        </a>
    </div>
    <div class="col-6 col-xl-3">
        <a href="<?= base_url('inventory') ?>" class="stat-card" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed)">
            <div class="sv">&#8377;<?= number_format($sales_value, 0) ?></div>
            <div class="sl">Total Sales Value</div>
            <div class="sc"><i class="fas fa-file-invoice me-1"></i><?= $total_orders ?> orders</div>
            <i class="fas fa-file-invoice si"></i>
        </a>
    </div>
</div>

<!-- MINI STAT ROW -->
<div class="row g-3 mb-3">
    <div class="col-6 col-xl-3">
        <div class="mini-card">
            <div class="mini-icon" style="background:#eff6ff"><i class="fas fa-industry text-primary"></i></div>
            <div><div class="fw-bold fs-5"><?= $total_suppliers ?></div><div class="text-muted" style="font-size:.78rem">Active Suppliers</div></div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="mini-card">
            <div class="mini-icon" style="background:#f0fdf4"><i class="fas fa-users text-success"></i></div>
            <div><div class="fw-bold fs-5"><?= $total_customers ?></div><div class="text-muted" style="font-size:.78rem">Active Customers</div></div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="mini-card">
            <div class="mini-icon" style="background:#fefce8"><i class="fas fa-tags text-warning"></i></div>
            <div><div class="fw-bold fs-5"><?= count($stock_by_category) ?></div><div class="text-muted" style="font-size:.78rem">Product Categories</div></div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="mini-card">
            <div class="mini-icon" style="background:#fdf4ff"><i class="fas fa-chart-line" style="color:#8b5cf6"></i></div>
            <div>
                <div class="fw-bold fs-5 <?= $profit >= 0 ? 'text-success' : 'text-danger' ?>">
                    &#8377;<?= number_format(abs($profit), 0) ?>
                </div>
                <div class="text-muted" style="font-size:.78rem"><?= $profit >= 0 ? 'Gross Profit' : 'Net Loss' ?></div>
            </div>
        </div>
    </div>
</div>

<!-- CHARTS ROW 1 -->
<div class="row g-3 mb-3">
    <div class="col-lg-8">
        <div class="card chart-card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-bar text-primary me-2"></i>Purchases vs Sales — Last 6 Months</span>
                <div class="btn-group btn-group-sm" id="chartToggle">
                    <button class="btn btn-primary active" onclick="switchChart('bar',this)">Bar</button>
                    <button class="btn btn-outline-primary" onclick="switchChart('line',this)">Line</button>
                </div>
            </div>
            <div class="card-body" style="height:260px;position:relative">
                <canvas id="psChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card chart-card h-100">
            <div class="card-header"><i class="fas fa-chart-pie text-success me-2"></i>Stock by Category</div>
            <div class="card-body d-flex align-items-center justify-content-center" style="height:260px;position:relative">
                <?php if (empty($stock_by_category)): ?>
                    <p class="text-muted mb-0">No stock data yet.</p>
                <?php else: ?>
                    <canvas id="catChart"></canvas>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- CHARTS ROW 2 -->
<div class="row g-3 mb-3">
    <div class="col-lg-6">
        <div class="card chart-card h-100">
            <div class="card-header"><i class="fas fa-layer-group text-primary me-2"></i>Top Products — Stock vs Min Level</div>
            <div class="card-body" style="height:240px;position:relative">
                <?php if (empty($top_stock_products)): ?>
                    <p class="text-muted text-center mt-4">No stock data yet.</p>
                <?php else: ?>
                    <canvas id="stockBar"></canvas>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card chart-card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-exclamation-triangle text-warning me-2"></i>Low Stock Items</span>
                <a href="<?= base_url('stock') ?>" class="btn btn-sm btn-outline-secondary">All Stock</a>
            </div>
            <div class="card-body p-0" style="max-height:240px;overflow-y:auto">
                <table class="table table-hover mb-0">
                    <thead class="table-light sticky-top"><tr>
                        <th class="ps-3">Product</th>
                        <th class="text-center">Available</th>
                        <th class="text-center">Min</th>
                        <th class="text-center pe-3">Alert</th>
                    </tr></thead>
                    <tbody>
                        <?php if (empty($low_stock_items)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-check-circle text-success me-1"></i>All stocks sufficient!
                            </td></tr>
                        <?php else: ?>
                            <?php foreach ($low_stock_items as $s):
                                $pct = $s->min_stock_quantity > 0 ? min(100, round(($s->stock_available / $s->min_stock_quantity) * 100)) : 0; ?>
                            <tr>
                                <td class="ps-3" style="max-width:150px">
                                    <span class="fw-semibold d-block text-truncate" style="font-size:.82rem"><?= htmlspecialchars($s->product_name) ?></span>
                                    <div class="progress mt-1" style="height:3px"><div class="progress-bar bg-danger" style="width:<?= $pct ?>%"></div></div>
                                </td>
                                <td class="text-center"><span class="badge bg-danger"><?= $s->stock_available ?></span></td>
                                <td class="text-center text-muted"><?= $s->min_stock_quantity ?></td>
                                <td class="text-center pe-3">
                                    <span class="badge <?= $s->stock_available == 0 ? 'bg-dark' : 'bg-danger' ?>" style="font-size:.7rem">
                                        <?= $s->stock_available == 0 ? 'Out' : 'Low' ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- RECENT ACTIVITY -->
<div class="row g-3">
    <div class="col-lg-6">
        <div class="card chart-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-truck text-primary me-2"></i>Recent Purchases</span>
                <a href="<?= base_url('purchase/add') ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i>New</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light"><tr>
                        <th class="ps-3">Date</th><th>Supplier</th><th class="text-end pe-3">Amount</th>
                    </tr></thead>
                    <tbody>
                        <?php if (empty($recent_purchases)): ?>
                            <tr><td colspan="3" class="text-center text-muted py-3">No purchases yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($recent_purchases as $p): ?>
                            <tr style="cursor:pointer" onclick="location.href='<?= base_url('purchase/view/'.$p->purchase_id) ?>'">
                                <td class="ps-3" style="font-size:.83rem"><?= date('d M Y', strtotime($p->date_of_purchase)) ?></td>
                                <td class="fw-semibold" style="font-size:.83rem"><?= htmlspecialchars($p->supplier_name) ?></td>
                                <td class="text-end pe-3 fw-semibold text-success">&#8377;<?= number_format($p->total_amount, 2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card chart-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-file-invoice me-2" style="color:#8b5cf6"></i>Recent Sales Orders</span>
                <a href="<?= base_url('inventory/add') ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-plus me-1"></i>New</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light"><tr>
                        <th class="ps-3">Date</th><th>Customer</th><th class="text-center">Pay</th><th class="text-end pe-3">Total</th>
                    </tr></thead>
                    <tbody>
                        <?php if (empty($recent_orders)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-3">No orders yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($recent_orders as $o): ?>
                            <tr style="cursor:pointer" onclick="location.href='<?= base_url('inventory/view/'.$o->inventory_order_id) ?>'">
                                <td class="ps-3" style="font-size:.83rem"><?= date('d M Y', strtotime($o->inventory_order_date)) ?></td>
                                <td class="fw-semibold" style="font-size:.83rem"><?= htmlspecialchars($o->customer_name) ?></td>
                                <td class="text-center">
                                    <span class="badge <?= $o->payment_status === 'cash' ? 'badge-cash' : 'badge-credit' ?>" style="font-size:.7rem">
                                        <?= ucfirst($o->payment_status) ?>
                                    </span>
                                </td>
                                <td class="text-end pe-3 fw-semibold">&#8377;<?= number_format($o->inventory_order_total, 2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- CHART.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
const MONTHS   = <?= $months_labels ?>;
const PURCHASES= <?= $purchase_totals ?>;
const SALES    = <?= $sales_totals ?>;
const CATLABELS= <?= $cat_labels ?>;
const CATSTOCKS= <?= $cat_stocks ?>;
const BARLABELS= <?= $bar_labels ?>;
const BARAVAIL = <?= $bar_available ?>;
const BARMIN   = <?= $bar_min ?>;
const PALETTE  = ['#4f8ef7','#10b981','#f59e0b','#8b5cf6','#ef4444','#06b6d4','#f97316','#84cc16','#ec4899','#14b8a6'];

Chart.defaults.font.family = "'Segoe UI', sans-serif";

// 1. Purchase vs Sales
const psCtx = document.getElementById('psChart');
let psChart;
function buildPS(type) {
    if (psChart) psChart.destroy();
    psChart = new Chart(psCtx, {
        type,
        data: {
            labels: MONTHS,
            datasets: [
                { label:'Purchases (₹)', data:PURCHASES, backgroundColor: type==='bar'?'rgba(79,142,247,.8)':'rgba(79,142,247,.12)', borderColor:'#4f8ef7', borderWidth:2, borderRadius:type==='bar'?6:0, tension:.4, fill:type==='line', pointRadius:4, pointBackgroundColor:'#4f8ef7' },
                { label:'Sales (₹)',     data:SALES,     backgroundColor: type==='bar'?'rgba(16,185,129,.8)':'rgba(16,185,129,.12)', borderColor:'#10b981', borderWidth:2, borderRadius:type==='bar'?6:0, tension:.4, fill:type==='line', pointRadius:4, pointBackgroundColor:'#10b981' }
            ]
        },
        options: {
            responsive:true, maintainAspectRatio:false,
            plugins: {
                legend:{ position:'top', labels:{ boxWidth:10, font:{size:11} } },
                tooltip:{ callbacks:{ label: c => ' ₹'+c.parsed.y.toLocaleString('en-IN',{minimumFractionDigits:2}) } }
            },
            scales: {
                x:{ grid:{display:false}, ticks:{font:{size:11}} },
                y:{ grid:{color:'#f5f5f5'}, ticks:{ font:{size:10}, callback: v=>'₹'+(v>=1000?(v/1000).toFixed(0)+'K':v) } }
            }
        }
    });
}
function switchChart(type, btn) {
    buildPS(type);
    document.querySelectorAll('#chartToggle button').forEach(b => {
        b.className = b === btn ? 'btn btn-primary active' : 'btn btn-outline-primary';
    });
}
buildPS('bar');

// 2. Category doughnut
<?php if (!empty($stock_by_category)): ?>
new Chart(document.getElementById('catChart'), {
    type:'doughnut',
    data:{ labels:CATLABELS, datasets:[{ data:CATSTOCKS, backgroundColor:PALETTE.slice(0,CATLABELS.length), borderWidth:2, borderColor:'#fff', hoverOffset:8 }] },
    options:{
        responsive:true, maintainAspectRatio:false, cutout:'65%',
        plugins:{
            legend:{ position:'bottom', labels:{ boxWidth:10, font:{size:10}, padding:8 } },
            tooltip:{ callbacks:{ label: c=>' '+c.label+': '+c.parsed+' units' } }
        }
    }
});
<?php endif; ?>

// 3. Horizontal bar: stock vs min
<?php if (!empty($top_stock_products)): ?>
new Chart(document.getElementById('stockBar'), {
    type:'bar',
    data:{
        labels:BARLABELS,
        datasets:[
            { label:'Available', data:BARAVAIL, backgroundColor:'rgba(79,142,247,.85)', borderRadius:5 },
            { label:'Min Level', data:BARMIN,   backgroundColor:'rgba(239,68,68,.5)',   borderRadius:5 }
        ]
    },
    options:{
        indexAxis:'y', responsive:true, maintainAspectRatio:false,
        plugins:{
            legend:{ position:'top', labels:{ boxWidth:10, font:{size:10} } },
            tooltip:{ callbacks:{ label: c=>' '+c.dataset.label+': '+c.parsed.x+' units' } }
        },
        scales:{
            x:{ grid:{color:'#f5f5f5'}, ticks:{font:{size:10}} },
            y:{ grid:{display:false}, ticks:{font:{size:10}} }
        }
    }
});
<?php endif; ?>
</script>
